<?php

declare(strict_types=1);

namespace Neo\CookieconsentBundle\Tests\Controller;

use Doctrine\DBAL\Connection;
use Neo\CookieconsentBundle\Consent\Settings;
use Neo\CookieconsentBundle\Controller\LogController;
use Neo\CookieconsentBundle\Tests\Support\TestDatabase;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Cache\Adapter\ArrayAdapter;
use Symfony\Component\HttpFoundation\Request;

#[CoversClass(LogController::class)]
final class LogControllerTest extends TestCase
{
    private const ID = '0f8fad5b-d9cb-469f-a165-70867728950e';

    private Connection $db;

    private LogController $controller;

    protected function setUp(): void
    {
        $this->db = TestDatabase::create(LogController::TABLE, Settings::TABLE);
        $this->controller = new LogController($this->db, new Settings($this->db), new ArrayAdapter());
    }

    public function testAChoiceIsStoredWithoutTheAddress(): void
    {
        $response = ($this->controller)($this->request(['id' => self::ID, 'action' => 'save', 'v' => 3, 'root' => 2, 'cats' => ['statistics', 'marketing', 'unknown'], 'svc' => ['ga4', 'c12', 'Bad Key', '<script>']]));

        $this->assertSame(200, $response->getStatusCode());
        $this->assertSame('{"ok":true}', $response->getContent());

        $row = $this->db->fetchAssociative('SELECT * FROM '.LogController::TABLE);
        $this->assertSame([self::ID, 3, 2, 'save', 'statistics,marketing', 'ga4,c12'], [$row['consent_id'], (int) $row['version'], (int) $row['root'], $row['action'], $row['categories'], $row['services']]);
        $this->assertNotContains('203.0.113.7', array_map('strval', $row));
    }

    public function testNothingIsStoredWhenTheProofIsSwitchedOff(): void
    {
        $this->db->insert(Settings::TABLE, ['tstamp' => 1, 'log' => '']);
        $controller = new LogController($this->db, new Settings($this->db), new ArrayAdapter());

        $this->assertSame(404, $controller($this->request(['id' => self::ID, 'action' => 'accept']))->getStatusCode());
        $this->assertSame(0, $this->storedRows());
    }

    public function testOnlyTheOwnOriginMayReport(): void
    {
        $this->assertSame(403, ($this->controller)($this->request(['id' => self::ID, 'action' => 'accept'], 'https://other.example.org'))->getStatusCode());
        $this->assertSame(200, ($this->controller)($this->request(['id' => self::ID, 'action' => 'accept'], 'https://www.example.com'))->getStatusCode());
        $this->assertSame(1, $this->storedRows());
    }

    public function testInvalidReportsAreRejected(): void
    {
        $this->assertSame(400, ($this->controller)($this->request('not json'))->getStatusCode());
        $this->assertSame(400, ($this->controller)($this->request(['id' => 'abc', 'action' => 'accept']))->getStatusCode());
        $this->assertSame(400, ($this->controller)($this->request(['id' => strtoupper(self::ID), 'action' => 'accept']))->getStatusCode());
        $this->assertSame(400, ($this->controller)($this->request(['id' => self::ID, 'action' => 'delete']))->getStatusCode());
        $this->assertSame(0, $this->storedRows());
    }

    public function testThirtyReportsPerMinuteAndAddress(): void
    {
        for ($i = 0; $i < 30; ++$i) {
            $this->assertSame(200, ($this->controller)($this->request(['id' => self::ID, 'action' => 'accept']))->getStatusCode());
        }

        $this->assertSame(429, ($this->controller)($this->request(['id' => self::ID, 'action' => 'accept']))->getStatusCode());
        $this->assertSame(200, ($this->controller)($this->request(['id' => self::ID, 'action' => 'accept'], '', '198.51.100.4'))->getStatusCode(), 'another address');
        $this->assertSame(31, $this->storedRows());
    }

    /** @param array<string, mixed>|string $body */
    private function request(array|string $body, string $origin = '', string $ip = '203.0.113.7'): Request
    {
        $request = Request::create('https://www.example.com/api/cookieconsent/log', 'POST', [], [], [], ['REMOTE_ADDR' => $ip], \is_array($body) ? json_encode($body) : $body);

        if ('' !== $origin) {
            $request->headers->set('Origin', $origin);
        }

        return $request;
    }

    private function storedRows(): int
    {
        return (int) $this->db->fetchOne('SELECT COUNT(*) FROM '.LogController::TABLE);
    }
}
