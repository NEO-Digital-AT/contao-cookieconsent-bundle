<?php

declare(strict_types=1);

namespace Neo\CookieconsentBundle\Consent;

use Doctrine\DBAL\Connection;

/**
 * The one settings record (tl_neo_cookieconsent_settings) with defaults for
 * every field, so the banner works before anyone saved the settings.
 */
final class Settings
{
    public const TABLE = 'tl_neo_cookieconsent_settings';

    private const DEFAULTS = [
        'id' => 0,
        'active' => '1',
        'show_on' => 'immediately',
        'position' => 'bottom',
        'overlay' => '',
        'reopen' => 'left',
        'privacy_page' => 0,
        'imprint_page' => 0,
        'block_scripts' => '1',
        'block_embeds' => '1',
        'consent_mode' => '1',
        'log' => '1',
        'log_days' => 1095,
        'scan' => '1',
        'scan_limit' => 25,
        'scan_mail' => '',
        'version' => 1,
        'version_hash' => '',
        'version_at' => 0,
        'last_scan' => 0,
    ];

    /** @var array<string, mixed>|null */
    private array|null $row = null;

    public function __construct(private readonly Connection $db)
    {
    }

    /** @return array<string, mixed> */
    public function all(): array
    {
        if (null === $this->row) {
            try {
                $row = $this->db->fetchAssociative('SELECT * FROM '.self::TABLE.' ORDER BY id LIMIT 1');
            } catch (\Throwable) {
                $row = false; // table not created yet (before the database update)
            }

            $this->row = array_replace(self::DEFAULTS, \is_array($row) ? $row : []);
        }

        return $this->row;
    }

    public function get(string $key): mixed
    {
        return $this->all()[$key] ?? null;
    }

    public function flag(string $key): bool
    {
        return '1' === (string) $this->get($key);
    }

    /** Creates the record on the first visit of the back end. */
    public function ensureRow(): int
    {
        $id = $this->db->fetchOne('SELECT id FROM '.self::TABLE.' ORDER BY id LIMIT 1');

        if (false !== $id) {
            return (int) $id;
        }

        $this->db->insert(self::TABLE, ['tstamp' => time(), 'version' => 1, 'version_at' => time()]);
        $this->row = null;

        return (int) $this->db->lastInsertId();
    }

    /** @param array<string, mixed> $values */
    public function update(array $values): void
    {
        $id = $this->ensureRow();
        $this->db->update(self::TABLE, $values, ['id' => $id]);
        $this->row = null;
    }
}
