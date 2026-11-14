<?php

declare(strict_types=1);

namespace Neo\CookieconsentBundle\Catalog;

/**
 * Templates for common services. Choosing one fills provider, purpose,
 * cookies, transfer and the privacy policy link; services the extension can
 * load itself need only their ID. The scan and the blocking recognise a
 * template by its patterns (ServiceTemplate).
 *
 * Purposes and durations are codes; their texts for visitors come from the
 * translations (purpose.<code>, duration.<code>) in eleven languages. A
 * provider "@self" is the operator of the website (self-hosted services).
 */
final class ServiceCatalog
{
    private const GOOGLE = 'Google Ireland Limited, Dublin';
    private const GOOGLE_PRIVACY = 'https://policies.google.com/privacy';
    private const MICROSOFT = 'Microsoft Ireland Operations Limited, Dublin';
    private const MICROSOFT_PRIVACY = 'https://privacy.microsoft.com/privacystatement';
    private const META = 'Meta Platforms Ireland Limited, Dublin';
    private const META_PRIVACY = 'https://www.facebook.com/privacy/policy/';
    private const CLOUDFLARE = 'Cloudflare, Inc., San Francisco';
    private const CLOUDFLARE_PRIVACY = 'https://www.cloudflare.com/privacypolicy/';
    private const UUID = '[a-f0-9]{8}-[a-f0-9]{4}-[a-f0-9]{4}-[a-f0-9]{4}-[a-f0-9]{12}';

    /** Order of the categories in choices and lists. */
    public const CATEGORIES = ['necessary', 'functional', 'statistics', 'marketing'];

    /** @var array<string, ServiceTemplate>|null */
    private array|null $templates = null;

    /** @return array<string, ServiceTemplate> */
    public function all(): array
    {
        if (null === $this->templates) {
            $this->templates = [];

            foreach (self::data() as $key => $d) {
                $this->templates[$key] = new ServiceTemplate(
                    $key,
                    $d['name'],
                    $d['provider'],
                    $d['category'],
                    $d['purpose'],
                    $d['transfer'] ?? '',
                    $d['privacy'],
                    $d['cookies'] ?? [],
                    $d['id'][0] ?? '',
                    $d['id'][1] ?? '',
                    $d['url'] ?? false,
                    $d['loader'] ?? '',
                    $d['patterns'] ?? [],
                    $d['id_from'] ?? '',
                    $d['google'] ?? false,
                    $d['self_gated'] ?? false,
                    $d['linker'] ?? false,
                );
            }
        }

        return $this->templates;
    }

    public function get(string $key): ServiceTemplate|null
    {
        return $this->all()[$key] ?? null;
    }

    /**
     * Choice for the back end, grouped by category (labels resolved by the caller).
     *
     * @return array<string, array<string, string>>
     */
    public function grouped(): array
    {
        $groups = [];

        foreach ($this->all() as $key => $template) {
            $groups[$template->category][$key] = $template->name;
        }

        foreach ($groups as &$names) {
            natcasesort($names);
        }

        return array_replace(array_intersect_key(array_flip(self::CATEGORIES), $groups), $groups);
    }

    /** @return array<string, array<string, mixed>> */
    private static function data(): array
    {
        // gtag.js once per page, however many Google tags (GA4, Ads) are allowed.
        $gtag = '<script>window.dataLayer=window.dataLayer||[];window.gtag=window.gtag||function(){dataLayer.push(arguments)};'
            .'if(!window.__nccGtagJs){window.__nccGtagJs=1;var g=document.createElement("script");g.async=true;'
            .'g.src="https://www.googletagmanager.com/gtag/js?id={id}";document.head.appendChild(g);gtag("js",new Date())}'
            .'{linker}gtag("config","{id}");</script>';

        return [
            // Statistics
            'ga4' => [
                'name' => 'Google Analytics 4', 'provider' => self::GOOGLE, 'category' => 'statistics', 'purpose' => 'analytics',
                'transfer' => 'us', 'privacy' => self::GOOGLE_PRIVACY, 'cookies' => ['_ga' => '2y', '_ga_*' => '2y'],
                'id' => ['G-XXXXXXXXXX', '#^G-[A-Z0-9]{4,12}$#'], 'loader' => $gtag, 'google' => true, 'linker' => true,
                'patterns' => ['script' => ['#googletagmanager\.com/gtag/js\?id=G-#i', '#gtag\(\s*["\x27]config["\x27]\s*,\s*["\x27]G-#i']],
                'id_from' => '#\b(G-[A-Z0-9]{6,12})\b#',
            ],
            'gtm' => [
                'name' => 'Google Tag Manager', 'provider' => self::GOOGLE, 'category' => 'statistics', 'purpose' => 'tag_manager',
                'transfer' => 'us', 'privacy' => self::GOOGLE_PRIVACY, 'google' => true,
                'id' => ['GTM-XXXXXXX', '#^GTM-[A-Z0-9]{4,10}$#'],
                'loader' => '<script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({"gtm.start":new Date().getTime(),event:"gtm.js"});var f=d.getElementsByTagName(s)[0],j=d.createElement(s);j.async=true;j.src="https://www.googletagmanager.com/gtm.js?id="+i;f.parentNode.insertBefore(j,f);})(window,document,"script","dataLayer","{id}");</script>',
                'patterns' => ['script' => ['#googletagmanager\.com/gtm\.js#i'], 'iframe' => ['#googletagmanager\.com/ns\.html#i']],
                'id_from' => '#\b(GTM-[A-Z0-9]{4,10})\b#',
            ],
            'matomo' => [
                'name' => 'Matomo', 'provider' => '@self', 'category' => 'statistics', 'purpose' => 'analytics',
                'privacy' => '', 'cookies' => ['_pk_id.*' => '13m', '_pk_ses.*' => '30min'],
                'id' => ['1', '#^\d{1,6}$#'], 'url' => true,
                'loader' => '<script>var _paq=window._paq=window._paq||[];_paq.push(["trackPageView"]);_paq.push(["enableLinkTracking"]);(function(){var u="{url}";_paq.push(["setTrackerUrl",u+"matomo.php"]);_paq.push(["setSiteId","{id}"]);var d=document,g=d.createElement("script"),s=d.getElementsByTagName("script")[0];g.async=true;g.src=u+"matomo.js";s.parentNode.insertBefore(g,s);})();</script>',
                'patterns' => ['script' => ['#/(matomo|piwik)\.js#i', '#_paq\.push#']],
                'id_from' => '#setSiteId["\x27]\s*,\s*["\x27]?(\d{1,6})#',
            ],
            'clarity' => [
                'name' => 'Microsoft Clarity', 'provider' => self::MICROSOFT, 'category' => 'statistics', 'purpose' => 'heatmap',
                'transfer' => 'us', 'privacy' => self::MICROSOFT_PRIVACY, 'cookies' => ['_clck' => '1y', '_clsk' => '1d', 'CLID' => '1y', 'MUID' => '1y'],
                'id' => ['abcdef1234', '#^[a-z0-9]{6,12}$#'],
                'loader' => '<script>(function(c,l,a,r,i,t,y){c[a]=c[a]||function(){(c[a].q=c[a].q||[]).push(arguments)};t=l.createElement(r);t.async=1;t.src="https://www.clarity.ms/tag/"+i;y=l.getElementsByTagName(r)[0];y.parentNode.insertBefore(t,y);})(window,document,"clarity","script","{id}");</script>',
                'patterns' => ['script' => ['#clarity\.ms/tag/#i', '#["\x27]clarity["\x27]\s*,\s*["\x27]script["\x27]#i']],
                'id_from' => '#clarity\.ms/tag/([a-z0-9]{6,12})|["\x27]script["\x27]\s*,\s*["\x27]([a-z0-9]{6,12})["\x27]#i',
            ],
            'hotjar' => [
                'name' => 'Hotjar', 'provider' => 'Hotjar Ltd., St. Julian’s', 'category' => 'statistics', 'purpose' => 'heatmap',
                'privacy' => 'https://www.hotjar.com/legal/policies/privacy/', 'cookies' => ['_hjSessionUser_*' => '1y', '_hjSession_*' => '30min'],
                'id' => ['1234567', '#^\d{5,10}$#'],
                'loader' => '<script>(function(h,o,t,j,a,r){h.hj=h.hj||function(){(h.hj.q=h.hj.q||[]).push(arguments)};h._hjSettings={hjid:{id},hjsv:6};a=o.getElementsByTagName("head")[0];r=o.createElement("script");r.async=1;r.src=t+h._hjSettings.hjid+j+h._hjSettings.hjsv;a.appendChild(r);})(window,document,"https://static.hotjar.com/c/hotjar-",".js?sv=");</script>',
                'patterns' => ['script' => ['#static\.hotjar\.com#i', '#_hjSettings#']],
                'id_from' => '#hjid\s*:\s*(\d{5,10})#',
            ],
            'etracker' => [
                'name' => 'etracker Analytics', 'provider' => 'etracker GmbH, Hamburg', 'category' => 'statistics', 'purpose' => 'analytics',
                'privacy' => 'https://www.etracker.com/datenschutz/', 'cookies' => ['_et_coid' => '2y'],
                'id' => ['AbCdEf', '#^[A-Za-z0-9]{4,12}$#'],
                'loader' => '<script id="_etLoader" charset="UTF-8" data-block-cookies="true" data-secure-code="{id}" src="https://code.etracker.com/code/e.js" async></script>',
                'patterns' => ['script' => ['#code\.etracker\.com#i']],
                'id_from' => '#data-secure-code=["\x27]([A-Za-z0-9]{4,12})#',
            ],
            'mouseflow' => [
                'name' => 'Mouseflow', 'provider' => 'Mouseflow ApS, Copenhagen', 'category' => 'statistics', 'purpose' => 'heatmap',
                'privacy' => 'https://mouseflow.com/legal/privacy-policy/', 'cookies' => ['mf_user' => '90d', 'mf_*' => 'session'],
                'id' => ['abcdefab-cdef-abcd-efab-cdefabcdefab', '#^'.self::UUID.'$#'],
                'loader' => '<script>window._mfq=window._mfq||[];(function(){var mf=document.createElement("script");mf.defer=true;mf.src="https://cdn.mouseflow.com/projects/{id}.js";document.getElementsByTagName("head")[0].appendChild(mf);})();</script>',
                'patterns' => ['script' => ['#cdn\.mouseflow\.com#i']],
                'id_from' => '#mouseflow\.com/projects/('.self::UUID.')#i',
            ],
            'plausible' => [
                'name' => 'Plausible Analytics', 'provider' => 'Plausible Insights OÜ, Tallinn', 'category' => 'statistics', 'purpose' => 'analytics_cookieless',
                'privacy' => 'https://plausible.io/privacy',
                'id' => ['example.com', '#^[a-z0-9.-]+\.[a-z]{2,}$#'],
                'loader' => '<script defer data-domain="{id}" src="https://plausible.io/js/script.js"></script>',
                'patterns' => ['script' => ['#plausible\.io/js/#i']],
                'id_from' => '#data-domain=["\x27]([a-z0-9.-]+\.[a-z]{2,})#i',
            ],
            'cloudflare-analytics' => [
                'name' => 'Cloudflare Web Analytics', 'provider' => self::CLOUDFLARE, 'category' => 'statistics', 'purpose' => 'analytics_cookieless',
                'transfer' => 'us', 'privacy' => self::CLOUDFLARE_PRIVACY,
                'id' => ['0123456789abcdef0123456789abcdef', '#^[a-f0-9]{32}$#'],
                'loader' => '<script defer src="https://static.cloudflareinsights.com/beacon.min.js" data-cf-beacon="{&quot;token&quot;:&quot;{id}&quot;}"></script>',
                'patterns' => ['script' => ['#static\.cloudflareinsights\.com/beacon#i']],
                'id_from' => '#token&?q?u?o?t?;?"?\s*:\s*&?q?u?o?t?;?"?([a-f0-9]{32})#',
            ],

            // Marketing
            'google-ads' => [
                'name' => 'Google Ads', 'provider' => self::GOOGLE, 'category' => 'marketing', 'purpose' => 'ads',
                'transfer' => 'us', 'privacy' => self::GOOGLE_PRIVACY, 'cookies' => ['_gcl_au' => '90d', 'IDE' => '13m', 'test_cookie' => '15min'],
                'id' => ['AW-123456789', '#^AW-\d{6,12}$#'], 'loader' => $gtag, 'google' => true, 'linker' => true,
                'patterns' => ['script' => ['#googletagmanager\.com/gtag/js\?id=AW-#i', '#gtag\(\s*["\x27]config["\x27]\s*,\s*["\x27]AW-#i', '#googleadservices\.com/pagead/conversion#i']],
                'id_from' => '#\b(AW-\d{6,12})\b#',
            ],
            'adsense' => [
                'name' => 'Google AdSense', 'provider' => self::GOOGLE, 'category' => 'marketing', 'purpose' => 'ad_network',
                'transfer' => 'us', 'privacy' => self::GOOGLE_PRIVACY, 'cookies' => ['__gads' => '13m', '__gpi' => '13m', '__eoi' => '6m'],
                'id' => ['ca-pub-0000000000000000', '#^ca-pub-\d{10,20}$#'], 'google' => true,
                'loader' => '<script async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js?client={id}" crossorigin="anonymous"></script>',
                'patterns' => ['script' => ['#pagead2\.googlesyndication\.com/pagead/js/adsbygoogle#i']],
                'id_from' => '#\b(ca-pub-\d{10,20})\b#',
            ],
            'meta-pixel' => [
                'name' => 'Meta Pixel (Facebook, Instagram)', 'provider' => self::META, 'category' => 'marketing', 'purpose' => 'social_ads',
                'transfer' => 'us', 'privacy' => self::META_PRIVACY, 'cookies' => ['_fbp' => '90d', 'fr' => '90d'],
                'id' => ['123456789012345', '#^\d{10,20}$#'],
                'loader' => '<script>!function(f,b,e,v,n,t,s){if(f.fbq)return;n=f.fbq=function(){n.callMethod?n.callMethod.apply(n,arguments):n.queue.push(arguments)};if(!f._fbq)f._fbq=n;n.push=n;n.loaded=!0;n.version="2.0";n.queue=[];t=b.createElement(e);t.async=!0;t.src=v;s=b.getElementsByTagName(e)[0];s.parentNode.insertBefore(t,s)}(window,document,"script","https://connect.facebook.net/en_US/fbevents.js");fbq("init","{id}");fbq("track","PageView");</script>',
                'patterns' => ['script' => ['#connect\.facebook\.net/[a-zA-Z_]+/fbevents\.js#i', '#fbq\(\s*["\x27]init#'], 'html' => ['#facebook\.com/tr\?id=#i']],
                'id_from' => '#fbq\(\s*["\x27]init["\x27]\s*,\s*["\x27](\d{10,20})|facebook\.com/tr\?id=(\d{10,20})#',
            ],
            'linkedin-insight' => [
                'name' => 'LinkedIn Insight Tag', 'provider' => 'LinkedIn Ireland Unlimited Company, Dublin', 'category' => 'marketing', 'purpose' => 'social_ads',
                'transfer' => 'us', 'privacy' => 'https://www.linkedin.com/legal/privacy-policy',
                'cookies' => ['li_sugr' => '90d', 'bcookie' => '1y', 'lidc' => '1d', 'UserMatchHistory' => '30d', 'AnalyticsSyncHistory' => '30d', 'li_fat_id' => '30d'],
                'id' => ['1234567', '#^\d{3,12}$#'],
                'loader' => '<script>window._linkedin_partner_id="{id}";window._linkedin_data_partner_ids=window._linkedin_data_partner_ids||[];window._linkedin_data_partner_ids.push(window._linkedin_partner_id);(function(l){if(!l){window.lintrk=function(a,b){window.lintrk.q.push([a,b])};window.lintrk.q=[]}var s=document.getElementsByTagName("script")[0];var b=document.createElement("script");b.async=true;b.src="https://snap.licdn.com/li.lms-analytics/insight.min.js";s.parentNode.insertBefore(b,s);})(window.lintrk);</script>',
                'patterns' => ['script' => ['#snap\.licdn\.com/li\.lms-analytics#i', '#_linkedin_partner_id#']],
                'id_from' => '#_linkedin_partner_id\s*=\s*["\x27]?(\d{3,12})#',
            ],
            'microsoft-ads' => [
                'name' => 'Microsoft Advertising (Bing Ads)', 'provider' => self::MICROSOFT, 'category' => 'marketing', 'purpose' => 'ads',
                'transfer' => 'us', 'privacy' => self::MICROSOFT_PRIVACY, 'cookies' => ['_uetsid' => '1d', '_uetvid' => '13m', 'MUID' => '1y'],
                'id' => ['12345678', '#^\d{5,12}$#'],
                'loader' => '<script>(function(w,d,t,r,u){var f,n,i;w[u]=w[u]||[],f=function(){var o={ti:"{id}",enableAutoSpaTracking:true};o.q=w[u],w[u]=new UET(o),w[u].push("pageLoad")},n=d.createElement(t),n.src=r,n.async=1,n.onload=n.onreadystatechange=function(){var s=this.readyState;s&&s!=="loaded"&&s!=="complete"||(f(),n.onload=n.onreadystatechange=null)},i=d.getElementsByTagName(t)[0],i.parentNode.insertBefore(n,i)})(window,document,"script","https://bat.bing.com/bat.js","uetq");</script>',
                'patterns' => ['script' => ['#bat\.bing\.com/bat\.js#i']],
                'id_from' => '#\bti\s*:\s*["\x27](\d{5,12})#',
            ],
            'tiktok-pixel' => [
                'name' => 'TikTok Pixel', 'provider' => 'TikTok Technology Limited, Dublin', 'category' => 'marketing', 'purpose' => 'social_ads',
                'transfer' => 'world', 'privacy' => 'https://www.tiktok.com/legal/page/eea/privacy-policy/en', 'cookies' => ['_ttp' => '13m', '_tt_enable_cookie' => '13m'],
                'id' => ['ABCDEFGHIJ1234567890', '#^[A-Z0-9]{10,30}$#'],
                'loader' => '<script>!function(w,d,t){w.TiktokAnalyticsObject=t;var ttq=w[t]=w[t]||[];ttq.methods=["page","track","identify","instances","debug","on","off","once","ready","alias","group","enableCookie","disableCookie"],ttq.setAndDefer=function(t,e){t[e]=function(){t.push([e].concat(Array.prototype.slice.call(arguments,0)))}};for(var i=0;i<ttq.methods.length;i++)ttq.setAndDefer(ttq,ttq.methods[i]);ttq.instance=function(t){for(var e=ttq._i[t]||[],n=0;n<ttq.methods.length;n++)ttq.setAndDefer(e,ttq.methods[n]);return e},ttq.load=function(e,n){var i="https://analytics.tiktok.com/i18n/pixel/events.js";ttq._i=ttq._i||{},ttq._i[e]=[],ttq._i[e]._u=i,ttq._t=ttq._t||{},ttq._t[e]=+new Date,ttq._o=ttq._o||{},ttq._o[e]=n||{};var o=document.createElement("script");o.async=!0,o.src=i+"?sdkid="+e+"&lib="+t;var a=document.getElementsByTagName("script")[0];a.parentNode.insertBefore(o,a)};ttq.load("{id}");ttq.page()}(window,document,"ttq");</script>',
                'patterns' => ['script' => ['#analytics\.tiktok\.com/i18n/pixel#i']],
                'id_from' => '#ttq\.load\(\s*["\x27]([A-Z0-9]{10,30})#',
            ],
            'pinterest-tag' => [
                'name' => 'Pinterest Tag', 'provider' => 'Pinterest Europe Ltd., Dublin', 'category' => 'marketing', 'purpose' => 'social_ads',
                'transfer' => 'us', 'privacy' => 'https://policy.pinterest.com/privacy-policy', 'cookies' => ['_pin_unauth' => '1y', '_pinterest_ct_ua' => '1y', '_epik' => '1y'],
                'id' => ['2612345678901', '#^\d{8,20}$#'],
                'loader' => '<script>!function(e){if(!window.pintrk){window.pintrk=function(){window.pintrk.queue.push(Array.prototype.slice.call(arguments))};var n=window.pintrk;n.queue=[],n.version="3.0";var t=document.createElement("script");t.async=!0,t.src=e;var r=document.getElementsByTagName("script")[0];r.parentNode.insertBefore(t,r)}}("https://s.pinimg.com/ct/core.js");pintrk("load","{id}");pintrk("page");</script>',
                'patterns' => ['script' => ['#s\.pinimg\.com/ct/core\.js#i']],
                'id_from' => '#pintrk\(\s*["\x27]load["\x27]\s*,\s*["\x27](\d{8,20})#',
            ],
            'snap-pixel' => [
                'name' => 'Snap Pixel (Snapchat)', 'provider' => 'Snap B.V., Amsterdam', 'category' => 'marketing', 'purpose' => 'social_ads',
                'transfer' => 'us', 'privacy' => 'https://values.snap.com/privacy/privacy-policy', 'cookies' => ['_scid' => '13m'],
                'id' => ['abcdefab-cdef-abcd-efab-cdefabcdefab', '#^'.self::UUID.'$#'],
                'loader' => '<script>(function(e,t,n){if(e.snaptr)return;var a=e.snaptr=function(){a.handleRequest?a.handleRequest.apply(a,arguments):a.queue.push(arguments)};a.queue=[];var s="script";var r=t.createElement(s);r.async=!0;r.src=n;var u=t.getElementsByTagName(s)[0];u.parentNode.insertBefore(r,u);})(window,document,"https://sc-static.net/scevent.min.js");snaptr("init","{id}",{});snaptr("track","PAGE_VIEW");</script>',
                'patterns' => ['script' => ['#sc-static\.net/scevent\.min\.js#i']],
                'id_from' => '#snaptr\(\s*["\x27]init["\x27]\s*,\s*["\x27]('.self::UUID.')#i',
            ],
            'x-pixel' => [
                'name' => 'X Pixel (Twitter)', 'provider' => 'Twitter International Unlimited Company, Dublin', 'category' => 'marketing', 'purpose' => 'social_ads',
                'transfer' => 'us', 'privacy' => 'https://x.com/privacy', 'cookies' => ['personalization_id' => '2y', 'muc_ads' => '2y'],
                'id' => ['o1234', '#^[a-z0-9]{4,10}$#'],
                'loader' => '<script>!function(e,t,n,s,u,a){e.twq||(s=e.twq=function(){s.exe?s.exe.apply(s,arguments):s.queue.push(arguments)},s.version="1.1",s.queue=[],u=t.createElement(n),u.async=!0,u.src="https://static.ads-twitter.com/uwt.js",a=t.getElementsByTagName(n)[0],a.parentNode.insertBefore(u,a))}(window,document,"script");twq("config","{id}");</script>',
                'patterns' => ['script' => ['#static\.ads-twitter\.com/uwt\.js#i']],
                'id_from' => '#twq\(\s*["\x27]config["\x27]\s*,\s*["\x27]([a-z0-9]{4,10})#i',
            ],
            'reddit-pixel' => [
                'name' => 'Reddit Pixel', 'provider' => 'Reddit, Inc., San Francisco', 'category' => 'marketing', 'purpose' => 'social_ads',
                'transfer' => 'us', 'privacy' => 'https://www.reddit.com/policies/privacy-policy', 'cookies' => ['_rdt_uuid' => '90d'],
                'id' => ['a2_abcd1234', '#^(a2|t2)_[a-z0-9]{4,20}$#'],
                'loader' => '<script>!function(w,d){if(!w.rdt){var p=w.rdt=function(){p.sendEvent?p.sendEvent.apply(p,arguments):p.callQueue.push(arguments)};p.callQueue=[];var t=d.createElement("script");t.src="https://www.redditstatic.com/ads/pixel.js",t.async=!0;var s=d.getElementsByTagName("script")[0];s.parentNode.insertBefore(t,s)}}(window,document);rdt("init","{id}");rdt("track","PageVisit");</script>',
                'patterns' => ['script' => ['#redditstatic\.com/ads/pixel\.js#i']],
                'id_from' => '#rdt\(\s*["\x27]init["\x27]\s*,\s*["\x27]((?:a2|t2)_[a-z0-9]{4,20})#',
            ],
            'leadinfo' => [
                'name' => 'Leadinfo', 'provider' => 'Leadinfo B.V., Rotterdam', 'category' => 'marketing', 'purpose' => 'b2b',
                'privacy' => 'https://www.leadinfo.com/en/legal/privacy/', 'cookies' => ['_li_id' => '2y', '_li_ses' => 'session'],
                'id' => ['LI-1234567890', '#^LI-[A-Z0-9]{6,16}$#'],
                'loader' => '<script>(function(l,e,a,d,i,n,f,o){if(!l[i]){l.GlobalLeadinfoNamespace=l.GlobalLeadinfoNamespace||[];l.GlobalLeadinfoNamespace.push(i);l[i]=function(){(l[i].q=l[i].q||[]).push(arguments)};l[i].t=l[i].t||n;l[i].q=l[i].q||[];o=e.createElement(a);f=e.getElementsByTagName(a)[0];o.async=1;o.src=d;f.parentNode.insertBefore(o,f);}}(window,document,"script","https://cdn.leadinfo.net/ping.js","leadinfo","{id}"));</script>',
                'patterns' => ['script' => ['#cdn\.leadinfo\.net/ping\.js#i']],
                'id_from' => '#\b(LI-[A-Z0-9]{6,16})\b#',
            ],
            'leadfeeder' => [
                'name' => 'Leadfeeder (Dealfront)', 'provider' => 'Liidio Oy, Helsinki', 'category' => 'marketing', 'purpose' => 'b2b',
                'privacy' => 'https://www.leadfeeder.com/privacy/', 'cookies' => ['_lfa' => '2y'],
                'id' => ['AbCdEf123456', '#^[A-Za-z0-9]{8,32}$#'],
                'loader' => '<script>window.ldfdr=window.ldfdr||function(){(ldfdr._q=ldfdr._q||[]).push([].slice.call(arguments))};</script><script async src="https://sc.lfeeder.com/lftracker_v1_{id}.js"></script>',
                'patterns' => ['script' => ['#sc\.lfeeder\.com/lftracker#i']],
                'id_from' => '#lftracker_v1_([A-Za-z0-9]{8,32})#',
            ],
            'hubspot' => [
                'name' => 'HubSpot', 'provider' => 'HubSpot Ireland Limited, Dublin', 'category' => 'marketing', 'purpose' => 'crm',
                'transfer' => 'us', 'privacy' => 'https://legal.hubspot.com/privacy-policy',
                'cookies' => ['__hstc' => '13m', 'hubspotutk' => '13m', '__hssc' => '30min', '__hssrc' => 'session'],
                'id' => ['1234567', '#^\d{4,12}$#'],
                'loader' => '<script id="hs-script-loader" async defer src="https://js.hs-scripts.com/{id}.js"></script>',
                'patterns' => ['script' => ['#js(-eu1)?\.hs-scripts\.com/#i', '#js(-eu1)?\.hs-analytics\.net/#i']],
                'id_from' => '#hs-scripts\.com/(\d{4,12})\.js#',
            ],
            'criteo' => [
                'name' => 'Criteo', 'provider' => 'Criteo SA, Paris', 'category' => 'marketing', 'purpose' => 'ad_network',
                'privacy' => 'https://www.criteo.com/privacy/', 'cookies' => ['cto_bundle' => '13m'],
                'patterns' => ['script' => ['#static\.criteo\.net/js/ld/#i']],
            ],

            // Functional: embedded content
            'youtube' => [
                'name' => 'YouTube', 'provider' => self::GOOGLE, 'category' => 'functional', 'purpose' => 'video',
                'transfer' => 'us', 'privacy' => self::GOOGLE_PRIVACY, 'cookies' => ['YSC' => 'session', 'VISITOR_INFO1_LIVE' => '6m'],
                'patterns' => ['iframe' => ['#^(https?:)?//(www\.)?(youtube\.com|youtube-nocookie\.com)/embed/#i'], 'script' => ['#youtube\.com/iframe_api#i']],
            ],
            'vimeo' => [
                'name' => 'Vimeo', 'provider' => 'Vimeo.com, Inc., New York', 'category' => 'functional', 'purpose' => 'video',
                'transfer' => 'us', 'privacy' => 'https://vimeo.com/legal/privacy/policy', 'cookies' => ['vuid' => '2y'],
                'patterns' => ['iframe' => ['#^(https?:)?//player\.vimeo\.com/video/#i'], 'script' => ['#player\.vimeo\.com/api/player\.js#i']],
            ],
            'google-maps' => [
                'name' => 'Google Maps', 'provider' => self::GOOGLE, 'category' => 'functional', 'purpose' => 'map',
                'transfer' => 'us', 'privacy' => self::GOOGLE_PRIVACY, 'cookies' => ['NID' => '6m'],
                'patterns' => ['iframe' => ['#^(https?:)?//(www\.)?google\.[a-z.]{2,6}/maps/embed#i', '#^(https?:)?//maps\.google\.[a-z.]{2,6}/#i'], 'script' => ['#maps\.googleapis\.com/maps/api/js#i']],
            ],
            'openstreetmap' => [
                'name' => 'OpenStreetMap', 'provider' => 'OpenStreetMap Foundation, Cambridge', 'category' => 'functional', 'purpose' => 'map',
                'privacy' => 'https://osmfoundation.org/wiki/Privacy_Policy',
                'patterns' => ['iframe' => ['#^(https?:)?//(www\.)?openstreetmap\.org/export/embed#i']],
            ],
            'instagram' => [
                'name' => 'Instagram', 'provider' => self::META, 'category' => 'functional', 'purpose' => 'social_embed',
                'transfer' => 'us', 'privacy' => 'https://privacycenter.instagram.com/policy',
                'patterns' => ['iframe' => ['#^(https?:)?//(www\.)?instagram\.com/(p|reel|tv)/[^/]+/embed#i'], 'script' => ['#(www\.)?instagram\.com/embed\.js#i']],
            ],
            'facebook' => [
                'name' => 'Facebook', 'provider' => self::META, 'category' => 'functional', 'purpose' => 'social_embed',
                'transfer' => 'us', 'privacy' => self::META_PRIVACY, 'cookies' => ['fr' => '90d', 'datr' => '2y'],
                'patterns' => ['iframe' => ['#^(https?:)?//(www\.)?facebook\.com/plugins/#i'], 'script' => ['#connect\.facebook\.net/[a-zA-Z_]+/sdk\.js#i']],
            ],
            'x-embed' => [
                'name' => 'X (Twitter)', 'provider' => 'Twitter International Unlimited Company, Dublin', 'category' => 'functional', 'purpose' => 'social_embed',
                'transfer' => 'us', 'privacy' => 'https://x.com/privacy', 'cookies' => ['guest_id' => '2y', 'personalization_id' => '2y'],
                'patterns' => ['iframe' => ['#^(https?:)?//platform\.twitter\.com/embed/#i'], 'script' => ['#platform\.twitter\.com/widgets\.js#i']],
            ],
            'spotify' => [
                'name' => 'Spotify', 'provider' => 'Spotify AB, Stockholm', 'category' => 'functional', 'purpose' => 'audio',
                'transfer' => 'us', 'privacy' => 'https://www.spotify.com/legal/privacy-policy/',
                'patterns' => ['iframe' => ['#^(https?:)?//open\.spotify\.com/embed#i']],
            ],
            'soundcloud' => [
                'name' => 'SoundCloud', 'provider' => 'SoundCloud Global Limited & Co. KG, Berlin', 'category' => 'functional', 'purpose' => 'audio',
                'transfer' => 'us', 'privacy' => 'https://soundcloud.com/pages/privacy',
                'patterns' => ['iframe' => ['#^(https?:)?//w\.soundcloud\.com/player/#i']],
            ],
            'calendly' => [
                'name' => 'Calendly', 'provider' => 'Calendly LLC, Atlanta', 'category' => 'functional', 'purpose' => 'scheduling',
                'transfer' => 'us', 'privacy' => 'https://calendly.com/legal/privacy-notice',
                'patterns' => ['iframe' => ['#^(https?:)?//calendly\.com/#i'], 'script' => ['#assets\.calendly\.com/assets/external/widget\.js#i']],
            ],
            'typeform' => [
                'name' => 'Typeform', 'provider' => 'Typeform S.L., Barcelona', 'category' => 'functional', 'purpose' => 'form',
                'transfer' => 'us', 'privacy' => 'https://www.typeform.com/legal/privacy-policy',
                'patterns' => ['iframe' => ['#^(https?:)?//form\.typeform\.com/#i'], 'script' => ['#embed\.typeform\.com/#i']],
            ],
            'brevo-forms' => [
                'name' => 'Brevo', 'provider' => 'Sendinblue SAS, Paris', 'category' => 'functional', 'purpose' => 'form',
                'privacy' => 'https://www.brevo.com/legal/privacypolicy/',
                'patterns' => ['iframe' => ['#^(https?:)?//[a-z0-9.-]*sibforms\.com/#i'], 'script' => ['#sibforms\.com/forms/end-form/build/main\.js#i']],
            ],
            'google-docs' => [
                'name' => 'Google Docs, Forms, Calendar', 'provider' => self::GOOGLE, 'category' => 'functional', 'purpose' => 'documents',
                'transfer' => 'us', 'privacy' => self::GOOGLE_PRIVACY, 'cookies' => ['NID' => '6m'],
                'patterns' => ['iframe' => ['#^(https?:)?//(docs|calendar|drive)\.google\.com/#i']],
            ],

            // Functional: protection, fonts, widgets
            'recaptcha' => [
                'name' => 'Google reCAPTCHA', 'provider' => self::GOOGLE, 'category' => 'functional', 'purpose' => 'captcha',
                'transfer' => 'us', 'privacy' => self::GOOGLE_PRIVACY, 'cookies' => ['_GRECAPTCHA' => '6m'],
                'patterns' => ['script' => ['#(google\.com|recaptcha\.net)/recaptcha/#i']],
            ],
            'hcaptcha' => [
                'name' => 'hCaptcha', 'provider' => 'Intuition Machines, Inc., San Francisco', 'category' => 'functional', 'purpose' => 'captcha',
                'transfer' => 'us', 'privacy' => 'https://www.hcaptcha.com/privacy',
                'patterns' => ['script' => ['#(js\.)?hcaptcha\.com/1/api\.js#i']],
            ],
            'turnstile' => [
                'name' => 'Cloudflare Turnstile', 'provider' => self::CLOUDFLARE, 'category' => 'functional', 'purpose' => 'captcha',
                'transfer' => 'us', 'privacy' => self::CLOUDFLARE_PRIVACY,
                'patterns' => ['script' => ['#challenges\.cloudflare\.com/turnstile#i']],
            ],
            'google-fonts' => [
                'name' => 'Google Fonts', 'provider' => self::GOOGLE, 'category' => 'functional', 'purpose' => 'fonts',
                'transfer' => 'us', 'privacy' => self::GOOGLE_PRIVACY,
                'patterns' => ['link' => ['#fonts\.googleapis\.com/css#i']],
            ],
            'adobe-fonts' => [
                'name' => 'Adobe Fonts', 'provider' => 'Adobe Systems Software Ireland Limited, Dublin', 'category' => 'functional', 'purpose' => 'fonts',
                'transfer' => 'us', 'privacy' => 'https://www.adobe.com/privacy/policy.html',
                'patterns' => ['link' => ['#use\.typekit\.net/#i'], 'script' => ['#use\.typekit\.net/#i']],
            ],
            'tawk' => [
                'name' => 'tawk.to', 'provider' => 'tawk.to inc., Wilmington', 'category' => 'functional', 'purpose' => 'chat',
                'transfer' => 'us', 'privacy' => 'https://www.tawk.to/privacy-policy/',
                'id' => ['0123456789abcdef01234567/default', '#^[a-z0-9]{8,32}/[a-z0-9]{4,16}$#i'],
                'loader' => '<script>var Tawk_API=Tawk_API||{},Tawk_LoadStart=new Date();(function(){var s1=document.createElement("script"),s0=document.getElementsByTagName("script")[0];s1.async=true;s1.src="https://embed.tawk.to/{id}";s1.charset="UTF-8";s1.setAttribute("crossorigin","*");s0.parentNode.insertBefore(s1,s0);})();</script>',
                'patterns' => ['script' => ['#embed\.tawk\.to/#i']],
                'id_from' => '#embed\.tawk\.to/([a-z0-9]{8,32}/[a-z0-9]{4,16})#i',
            ],
            'zendesk' => [
                'name' => 'Zendesk Chat', 'provider' => 'Zendesk, Inc., San Francisco', 'category' => 'functional', 'purpose' => 'chat',
                'transfer' => 'us', 'privacy' => 'https://www.zendesk.com/company/agreements-and-terms/privacy-notice/', 'cookies' => ['__zlcmid' => '1y'],
                'id' => ['abcdefab-cdef-abcd-efab-cdefabcdefab', '#^'.self::UUID.'$#'],
                'loader' => '<script id="ze-snippet" src="https://static.zdassets.com/ekr/snippet.js?key={id}"></script>',
                'patterns' => ['script' => ['#static\.zdassets\.com/ekr/snippet\.js#i']],
                'id_from' => '#snippet\.js\?key=('.self::UUID.')#i',
            ],
            'intercom' => [
                'name' => 'Intercom', 'provider' => 'Intercom R&D Unlimited Company, Dublin', 'category' => 'functional', 'purpose' => 'chat',
                'transfer' => 'us', 'privacy' => 'https://www.intercom.com/legal/privacy',
                'patterns' => ['script' => ['#widget\.intercom\.io/widget/#i', '#intercomSettings#']],
            ],
            'trustpilot' => [
                'name' => 'Trustpilot', 'provider' => 'Trustpilot A/S, Copenhagen', 'category' => 'functional', 'purpose' => 'reviews',
                'privacy' => 'https://legal.trustpilot.com/for-everyone/end-user-privacy-terms',
                'patterns' => ['script' => ['#widget\.trustpilot\.com/bootstrap#i']],
            ],
            'provenexpert' => [
                'name' => 'ProvenExpert', 'provider' => 'Expert Systems AG, Berlin', 'category' => 'functional', 'purpose' => 'reviews',
                'privacy' => 'https://www.provenexpert.com/en-us/privacy-policy/',
                'patterns' => ['script' => ['#provenexpert\.(com|net)/#i'], 'html' => ['#images\.provenexpert\.com#i']],
            ],
            'ai-chat' => [
                'name' => 'AI chat', 'provider' => '@self', 'category' => 'functional', 'purpose' => 'ai_chat',
                // The chat keeps the open conversation in the session storage of the tab (key nsa:<id>:<language>).
                'privacy' => '', 'self_gated' => true, 'cookies' => ['nsa:*' => 'session'],
                'patterns' => ['html' => ['#data-nsa-config#']],
            ],
        ];
    }
}
