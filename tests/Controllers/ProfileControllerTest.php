<?php

declare(strict_types=1);

namespace Tests\Controllers;

use Exception;
use Tests\AbstractUnitTest;

class ProfileControllerTest extends AbstractUnitTest
{
    /**
     * @throws Exception
     */
    public function testProfileIndexSuccess(): void
    {
        $request = $this->createRequest('/profile', 'GET', 'hash1');
        $app = $this->createApp();

        $response = $app->handle($request);

        self::assertEquals(200, $response->getStatusCode());
        self::assertStringContainsString('Ваш профиль', $response->getBody());
        self::assertStringContainsString('<b>ID</b>: 1095762b-41d5-4f48-a510-284a90fa9e58', $response->getBody());
        self::assertStringContainsString('<b>Имя</b>: User1', $response->getBody());
        self::assertStringContainsString('<b>Статус</b>: Active', $response->getBody());
        self::assertStringContainsString('<b>Аватар</b>: ava.jpg', $response->getBody());
        self::assertStringContainsString('<b>Уровень</b>: 1', $response->getBody());
    }

    /**
     * @throws Exception
     */
    public function testProfileIndexFail(): void
    {
        $request = $this->createRequest('/profile', 'GET', 'unknown_hash');
        $app = $this->createApp();

        $response = $app->handle($request);

        self::assertEquals(302, $response->getStatusCode());
        self::assertEquals(['Location' => '/'], $response->getHeaders());
    }
}
