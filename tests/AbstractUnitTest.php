<?php

declare(strict_types=1);

namespace Tests;

use NW\App\App;
use NW\Request\Request;
use PHPUnit\Framework\TestCase;

abstract class AbstractUnitTest extends TestCase
{
    protected bool $loadConfig = false;

    protected function createApp(): App
    {
        require_once __DIR__ . '/../config.test.php';
        $router = require __DIR__ . '/../Routes/web.php';
        return new App($router);
    }

    protected function createRequest(string $uri, string $method, string $hash = ''): Request
    {
        // TODO Временный костыль из-за старого класса Cookie
        if ($hash) {
            $_COOKIE['hash'] = $hash;
        }

        return new Request(['REQUEST_URI' => $uri, 'REQUEST_METHOD' => $method], [], $_COOKIE);
    }
}
