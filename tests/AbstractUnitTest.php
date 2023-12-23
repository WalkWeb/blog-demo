<?php

declare(strict_types=1);

namespace Tests;

use NW\App\App;
use PHPUnit\Framework\TestCase;

abstract class AbstractUnitTest extends TestCase
{
    protected function createApp(): App
    {
        require __DIR__ . '/../config.php';
        $router = require __DIR__ . '/../Routes/web.php';
        return new App($router);
    }
}
