<?php

declare(strict_types=1);

namespace Neo\CookieconsentBundle\Scan;

use Contao\Config;
use Contao\CoreBundle\Routing\ContentUrlGenerator;
use Contao\PageModel;
use Doctrine\DBAL\Connection;
use Neo\BasicBundle\Cache\PageCacheTags;
use Neo\CookieconsentBundle\Catalog\ServiceCatalog;
use Neo\CookieconsentBundle\Catalog\ServiceTemplate;
use Neo\CookieconsentBundle\Consent\HtmlBlocker;
use Neo\CookieconsentBundle\Consent\Service;
use Neo\CookieconsentBundle\Consent\ServiceFactory;
use Neo\CookieconsentBundle\Consent\ServiceRepository;
use Neo\CookieconsentBundle\Consent\Settings;
use Neo\CookieconsentBundle\Consent\Texts;
use Psr\Log\LoggerInterface;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Address;
use Symfony\Component\Mime\Email;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;

/**
 * Reads the published pages of this website and looks for services: scripts,
 * embedded content, web fonts and widgets of the catalogue, and scripts or
 * iframes of other hosts the catalogue does not know. Services of the
 * catalogue that are not listed yet are added (published, "loaded by the
 * page", so the blocking holds them back until consent); unknown hosts are
 * listed under "Scan results" for a decision. A mail names what is new.
 */
final class Scanner
{
    public const FINDINGS = 'tl_neo_cookieconsent_finding';

    public function __construct(
        private readonly HttpClientInterface $httpClient,
        private readonly Connection $db,
        private readonly ServiceCatalog $catalog,
        private readonly ServiceRepository $services,
        private readonly Settings $settings,
        private readonly Texts $texts,
        private readonly ContentUrlGenerator $urls,
        private readonly MailerInterface $mailer,
        private readonly LoggerInterface $logger,
        private readonly PageCacheTags $cacheTags,
        private readonly ServiceFactory $factory,
    ) {
    }

    public function run(): ScanResult
    {
        $result = new ScanResult();
        $limit = max(1, min(200, (int) $this->settings->get('scan_limit')));
        $findings = [];
        $ownHosts = [];
        $language = 'en';

        foreach ($this->pages($limit) as [$page, $root]) {
            try {
                $url = $this->urls->generate($page, [], UrlGeneratorInterface::ABSOLUTE_URL);
            } catch (\Throwable) {
                continue;
            }

            $host = strtolower((string) parse_url($url, PHP_URL_HOST));
            $ownHosts[$host] = true;
            $ownHosts[preg_replace('/^www\./', '', $host)] = true;
            $language = Texts::primary((string) ($page->rootLanguage ?: $page->language ?: $language));

            try {
                $response = $this->httpClient->request('GET', $url);

                if (200 !== $response->getStatusCode() || !str_contains($response->getHeaders(false)['content-type'][0] ?? '', 'text/html')) {
                    $result->errors[] = $url.' ('.$response->getStatusCode().')';
                    continue;
                }

                $html = $response->getContent(false);
            } catch (\Throwable $e) {
                $result->errors[] = $url.' ('.$e->getMessage().')';
                continue;
            }

            ++$result->pages;

            foreach ($this->detect($html) as $hit) {
                $key = $hit['template'] ?: 'host:'.$hit['host'];
                $findings[$key] ??= $hit + ['url' => $url, 'pages' => 0, 'roots' => [], 'loose' => false];
                ++$findings[$key]['pages'];
                $findings[$key]['roots'][$root] = true;
                $findings[$key]['loose'] = $findings[$key]['loose'] || !$hit['blocked'];

                if ('' === $findings[$key]['id'] && '' !== $hit['id']) {
                    $findings[$key]['id'] = $hit['id'];
                }
            }
        }

        $custom = array_values(array_filter($this->services->forRoot(0), static fn (Service $s): bool => [] !== $s->hosts));
        $multiRoot = (int) $this->db->fetchOne("SELECT COUNT(*) FROM tl_page WHERE type = 'root'") > 1;

        foreach ($findings as $key => $finding) {
            if ('' === $finding['template']) {
                if (isset($ownHosts[$finding['host']]) || isset($ownHosts[preg_replace('/^www\./', '', $finding['host'])]) || $this->knownHost($finding['host'], $custom)) {
                    unset($findings[$key]);
                    continue;
                }
            }

            $status = $this->store($key, $finding);

            if ('' !== $finding['template'] && 'ignored' !== $status && !$this->services->hasTemplate($finding['template'])) {
                $result->added[] = $this->add($this->catalog->get($finding['template']), $finding, $multiRoot ? array_keys($finding['roots']) : [], $language);
                $this->db->update(self::FINDINGS, ['status' => 'added'], ['finding_key' => $key]);
            } elseif ('' === $finding['template'] && 'new' === $status) {
                $result->unknown[] = $finding['host'];
            }
        }

        $result->found = \count($findings);
        $this->services->reset();

        // Cached pages must show the services just added.
        if ([] !== $result->added) {
            $this->cacheTags->invalidate(['contao.db.'.ServiceRepository::TABLE]);
        }
        $this->settings->update(['last_scan' => time(), 'last_scan_note' => json_encode($result->toArray())]);

        if ([] !== $result->added || [] !== $result->unknown) {
            $this->mail($result, $language);
        }

        return $result;
    }

    /**
     * Services in one page.
     *
     * @return list<array{template: string, host: string, id: string, blocked: bool}>
     */
    public function detect(string $html): array
    {
        // Our own configuration (it carries the loaders as text) is not part of the page.
        $html = preg_replace('#<script\b[^>]*\bid="ncc-[a-z]+"[^>]*>.*?</script>#is', '', $html) ?? $html;
        $hits = [];
        $sources = [];

        preg_match_all('#<script\b([^>]*)>(.*?)</script>#is', $html, $m, PREG_SET_ORDER);

        foreach ($m as $s) {
            $attrs = HtmlBlocker::attributes($s[1]);
            $type = strtolower($attrs['type'] ?? '');

            if (!\in_array($type, ['', 'text/javascript', 'application/javascript', 'module', 'text/plain'], true)) {
                continue;
            }

            $sources[] = ['script', $attrs['src'] ?? $s[2], isset($attrs['data-ncc-category']), isset($attrs['src'])];
        }

        preg_match_all('#<iframe\b([^>]*)>#i', $html, $m, PREG_SET_ORDER);

        foreach ($m as $s) {
            $attrs = HtmlBlocker::attributes($s[1]);

            if (isset($attrs['src'])) {
                // Blocked: the iframe sits in the <template> of a placeholder.
                $before = substr($html, 0, (int) strpos($html, $s[0]));
                $blocked = (int) strrpos($before, 'data-ncc-embed') > (int) strrpos($before, '</template>');
                $sources[] = ['iframe', $attrs['src'], $blocked, true];
            }
        }

        preg_match_all('#<link\b([^>]*)>#i', $html, $m, PREG_SET_ORDER);

        foreach ($m as $s) {
            $attrs = HtmlBlocker::attributes($s[1]);

            if (isset($attrs['data-ncc-href'])) {
                $sources[] = ['link', $attrs['data-ncc-href'], true, true];
            } elseif ('stylesheet' === strtolower($attrs['rel'] ?? '') && isset($attrs['href'])) {
                $sources[] = ['link', $attrs['href'], false, true];
            }
        }

        foreach ($sources as [$context, $value, $blocked, $isAddress]) {
            $value = html_entity_decode((string) $value, ENT_QUOTES);
            $template = $this->templateFor($context, $value);

            if (null !== $template) {
                $hits[] = ['template' => $template->key, 'host' => '', 'id' => $this->extractId($template, $html), 'blocked' => $blocked || $template->selfGated];
                continue;
            }

            if ($isAddress && 'link' !== $context) {
                $host = strtolower((string) parse_url(str_starts_with($value, '//') ? 'https:'.$value : $value, PHP_URL_HOST));

                if ('' !== $host) {
                    $hits[] = ['template' => '', 'host' => $host, 'id' => '', 'blocked' => $blocked];
                }
            }
        }

        foreach ($this->catalog->all() as $template) {
            foreach ($template->patterns('html') as $pattern) {
                if (1 === preg_match($pattern, $html)) {
                    $hits[] = ['template' => $template->key, 'host' => '', 'id' => $this->extractId($template, $html), 'blocked' => $template->selfGated];
                    break;
                }
            }
        }

        return $hits;
    }

    /** @return iterable<array{0: PageModel, 1: int}> */
    private function pages(int $limit): iterable
    {
        $now = time();
        $ids = $this->db->fetchFirstColumn(
            "SELECT id FROM tl_page WHERE type = 'regular' AND published = '1' AND protected = '' AND (start = '' OR start <= ?) AND (stop = '' OR stop > ?) ORDER BY pid, sorting LIMIT ".(int) ($limit * 4),
            [$now, $now],
        );

        // The first page of each website first, then the rest by most recent change.
        $pages = [];

        foreach ($ids as $id) {
            $page = PageModel::findWithDetails((int) $id);

            if (null !== $page && 'root' !== $page->type) {
                $pages[] = $page;
            }
        }

        $firsts = [];
        $rest = [];

        foreach ($pages as $page) {
            if (!isset($firsts[$page->rootId])) {
                $firsts[$page->rootId] = $page;
            } else {
                $rest[] = $page;
            }
        }

        usort($rest, static fn (PageModel $a, PageModel $b): int => (int) $b->tstamp <=> (int) $a->tstamp);

        foreach (\array_slice([...array_values($firsts), ...$rest], 0, $limit) as $page) {
            yield [$page, (int) $page->rootId];
        }
    }

    private function templateFor(string $context, string $value): ServiceTemplate|null
    {
        foreach ($this->catalog->all() as $template) {
            foreach ($template->patterns($context) as $pattern) {
                if (1 === preg_match($pattern, $value)) {
                    return $template;
                }
            }
        }

        return null;
    }

    private function extractId(ServiceTemplate $template, string $html): string
    {
        if ('' === $template->idFrom || !preg_match($template->idFrom, $html, $m)) {
            return '';
        }

        foreach (\array_slice($m, 1) as $group) {
            if ('' !== $group && $template->validId($group)) {
                return $group;
            }
        }

        return '';
    }

    /** @param list<Service> $custom */
    private function knownHost(string $host, array $custom): bool
    {
        foreach ($custom as $service) {
            foreach ($service->hosts as $h) {
                if ($host === $h || str_ends_with($host, '.'.$h)) {
                    return true;
                }
            }
        }

        return false;
    }

    /**
     * Keeps the finding; returns its status before this scan ("new" for a first finding).
     *
     * @param array<string, mixed> $finding
     */
    private function store(string $key, array $finding): string
    {
        $row = $this->db->fetchAssociative('SELECT id, status FROM '.self::FINDINGS.' WHERE finding_key = ?', [$key]);
        $values = [
            'tstamp' => time(),
            'last_seen' => time(),
            'url' => mb_substr((string) $finding['url'], 0, 1024),
            'pages' => (int) $finding['pages'],
            'tracking_id' => mb_substr((string) $finding['id'], 0, 128),
            'unblocked' => $finding['loose'] ? '1' : '',
        ];

        if (false === $row) {
            $listed = '' !== $finding['template'] && $this->services->hasTemplate($finding['template']);
            $this->db->insert(self::FINDINGS, $values + [
                'finding_key' => $key,
                'template' => (string) $finding['template'],
                'host' => (string) $finding['host'],
                'first_seen' => time(),
                'status' => $listed ? 'listed' : ('' === $finding['template'] ? 'unknown' : 'new'),
            ]);

            return 'new';
        }

        $this->db->update(self::FINDINGS, $values, ['id' => (int) $row['id']]);

        return (string) $row['status'];
    }

    /**
     * @param array<string, mixed> $finding
     * @param list<int>            $roots
     */
    private function add(ServiceTemplate|null $template, array $finding, array $roots, string $language): string
    {
        if (null === $template) {
            return '';
        }

        $this->factory->create($template, $template->category, $roots, $language, [
            'tracking_id' => mb_substr((string) $finding['id'], 0, 128),
            'source' => 'scan',
            'found_at' => time(),
            'found_url' => mb_substr((string) $finding['url'], 0, 1024),
        ]);

        return $this->factory->name($template, $language);
    }

    private function mail(ScanResult $result, string $language): void
    {
        $to = trim((string) $this->settings->get('scan_mail')) ?: trim((string) Config::get('adminEmail'));

        if ('' === $to) {
            return;
        }

        $lines = [$this->texts->trans('mail.intro', $language), ''];

        if ([] !== $result->added) {
            $lines[] = $this->texts->trans('mail.added', $language);

            foreach ($result->added as $name) {
                $lines[] = '- '.$name;
            }

            $lines[] = '';
        }

        if ([] !== $result->unknown) {
            $lines[] = $this->texts->trans('mail.unknown', $language);

            foreach ($result->unknown as $host) {
                $lines[] = '- '.$host;
            }

            $lines[] = '';
        }

        $lines[] = $this->texts->trans('mail.check', $language);

        try {
            $email = (new Email())->to($to)->subject($this->texts->trans('mail.subject', $language))->text(implode("\n", $lines));
            $from = trim((string) Config::get('adminEmail'));

            if ('' !== $from) {
                $email->from(new Address($from));
            }

            $this->mailer->send($email);
        } catch (\Throwable $e) {
            $this->logger->warning('Cookie consent scan: the mail could not be sent: '.$e->getMessage());
        }
    }
}
