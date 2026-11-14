<?php

declare(strict_types=1);

namespace Neo\CookieconsentBundle\Tests\Support;

use Doctrine\DBAL\Connection;
use Doctrine\DBAL\DriverManager;

/**
 * An SQLite database in memory with the tables of this bundle, built from the
 * "sql" definitions of its DCA files: the tests run the real queries against
 * the real column names and defaults.
 */
final class TestDatabase
{
    private const DCA = __DIR__.'/../../contao/dca/';

    public static function create(string ...$tables): Connection
    {
        $db = DriverManager::getConnection(['driver' => 'pdo_sqlite', 'memory' => true]);

        foreach ($tables as $table) {
            $db->executeStatement(self::createStatement($table));
        }

        return $db;
    }

    /**
     * The columns of tl_page the bundle reads (Contao's table, not part of this bundle).
     *
     * @param list<array<string, mixed>> $rows
     */
    public static function addPages(Connection $db, array $rows): void
    {
        $db->executeStatement("CREATE TABLE IF NOT EXISTS tl_page (id INTEGER PRIMARY KEY AUTOINCREMENT, pid int NOT NULL DEFAULT 0, sorting int NOT NULL DEFAULT 0, tstamp int NOT NULL DEFAULT 0, title varchar(255) NOT NULL DEFAULT '', type varchar(64) NOT NULL DEFAULT 'regular', language varchar(64) NOT NULL DEFAULT '', dns varchar(255) NOT NULL DEFAULT '', published char(1) NOT NULL DEFAULT '1', protected char(1) NOT NULL DEFAULT '', start varchar(10) NOT NULL DEFAULT '', stop varchar(10) NOT NULL DEFAULT '')");

        foreach ($rows as $row) {
            $db->insert('tl_page', $row);
        }
    }

    private static function createStatement(string $table): string
    {
        $saved = [$GLOBALS['TL_DCA'] ?? null, $GLOBALS['TL_LANG'] ?? null];

        include self::DCA.$table.'.php';
        $fields = $GLOBALS['TL_DCA'][$table]['fields'] ?? [];

        [$GLOBALS['TL_DCA'], $GLOBALS['TL_LANG']] = $saved;

        $columns = [];

        foreach ($fields as $name => $field) {
            if (isset($field['sql'])) {
                $columns[] = '"'.$name.'" '.self::columnType($field['sql']);
            }
        }

        return sprintf('CREATE TABLE "%s" (%s)', $table, implode(', ', $columns));
    }

    /** @param string|array<string, mixed> $sql MySQL column definition or Doctrine column options */
    private static function columnType(string|array $sql): string
    {
        if (\is_array($sql)) {
            $type = match ($sql['type'] ?? 'string') {
                'string' => 'varchar('.($sql['length'] ?? 255).')',
                'integer', 'smallint', 'bigint', 'boolean' => 'int',
                'binary', 'blob' => 'blob',
                default => 'text',
            };
            $null = ($sql['notnull'] ?? true) ? ' NOT NULL' : ' NULL';
            $default = \array_key_exists('default', $sql) && null !== $sql['default'] ? " DEFAULT '".str_replace("'", "''", (string) $sql['default'])."'" : '';

            return $type.$null.$default;
        }

        if (str_contains($sql, 'auto_increment')) {
            return 'INTEGER PRIMARY KEY AUTOINCREMENT';
        }

        return trim((string) preg_replace(['/\bunsigned\b/i', '/\b(COLLATE|CHARACTER SET)\s+\S+/i'], '', $sql));
    }
}
