<?php

declare(strict_types=1);

namespace Tests;

use PHPUnit\Framework\TestCase;

class FirstTest extends TestCase
{
    public function testFirst(): void
    {
        self::assertEquals(1, 1);
    }
}
