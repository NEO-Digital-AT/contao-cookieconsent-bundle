<?php

declare(strict_types=1);

namespace Neo\CookieconsentBundle\Scan;

/** Outcome of one scan, kept with the settings and shown in the back end. */
final class ScanResult
{
    public int $pages = 0;
    public int $found = 0;

    /** @var list<string> names of services added */
    public array $added = [];

    /** @var list<string> hosts found for the first time */
    public array $unknown = [];

    /** @var list<string> pages that could not be read */
    public array $errors = [];

    /** @return array<string, mixed> */
    public function toArray(): array
    {
        return [
            'time' => time(),
            'pages' => $this->pages,
            'found' => $this->found,
            'added' => $this->added,
            'unknown' => $this->unknown,
            'errors' => \array_slice($this->errors, 0, 10),
        ];
    }
}
