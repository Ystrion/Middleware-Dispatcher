<?php

declare(strict_types=1);

namespace Ystrion\MiddlewareDispatcher\Tests;

use Nyholm\Psr7\Factory\Psr17Factory;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;
use Ystrion\MiddlewareDispatcher\QueueMiddlewareDispatcher;
use Ystrion\MiddlewareDispatcher\Tests\Utils\DummyMiddleware;

#[CoversClass(QueueMiddlewareDispatcher::class)]
final class QueueMiddlewareDispatcherTest extends TestCase
{
    public function testHandle(): void
    {
        $psr17Factory = new Psr17Factory();
        $middlewareDispatcher = new QueueMiddlewareDispatcher($psr17Factory);

        $middlewareDispatcher->set([
            new DummyMiddleware('A'),
            new DummyMiddleware('B'),
            new DummyMiddleware('C'),
            new DummyMiddleware('D'),
            new DummyMiddleware('E')
        ]);

        $response = $middlewareDispatcher->handle($psr17Factory->createServerRequest('GET', '/'));

        self::assertSame('EDCBA', (string) $response->getBody());
    }

    public function testMultipleHandle(): void
    {
        $psr17Factory = new Psr17Factory();
        $middlewareDispatcher = new QueueMiddlewareDispatcher($psr17Factory);

        $middlewareDispatcher->set([
            new DummyMiddleware('A'),
            new DummyMiddleware('B'),
            new DummyMiddleware('C'),
            new DummyMiddleware('D'),
            new DummyMiddleware('E')
        ]);

        $response = $middlewareDispatcher->handle($psr17Factory->createServerRequest('GET', '/'));

        self::assertSame('EDCBA', (string) $response->getBody());

        $response = $middlewareDispatcher->handle($psr17Factory->createServerRequest('GET', '/'));

        self::assertSame('EDCBA', (string) $response->getBody());
    }
}
