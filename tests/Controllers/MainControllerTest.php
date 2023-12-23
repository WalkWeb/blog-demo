<?php

declare(strict_types=1);

namespace Tests\Controllers;

use Exception;
use NW\Request\ServerRequestFactory;
use Tests\AbstractUnitTest;

class MainControllerTest extends AbstractUnitTest
{
    /**
     * Тест на отображение главной страницы
     *
     * @throws Exception
     */
    public function testMainController(): void
    {
        $request = ServerRequestFactory::fromGlobals();
        $app = $this->createApp();

        $response = $app->handle($request);

        self::assertEquals(200, $response->getStatusCode());
        self::assertStringContainsString('Главная страница', $response->getBody());
    }
}
