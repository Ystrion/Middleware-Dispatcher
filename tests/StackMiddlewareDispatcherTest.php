<?php

declare(strict_types=1);

namespace Ystrion\MiddlewareDispatcher\Tests;

use Nyholm\Psr7\Factory\Psr17Factory;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;
use Ystrion\MiddlewareDispatcher\StackMiddlewareDispatcher;
use Ystrion\MiddlewareDispatcher\Tests\Utils\DummyMiddleware;

#[CoversClass(StackMiddlewareDispatcher::class)]
final class StackMiddlewareDispatcherTest extends TestCase
{
    public function testHandle(): void
    {
        $psr17Factory = new Psr17Factory();
        $middlewareDispatcher = new StackMiddlewareDispatcher($psr17Factory);

        $middlewareDispatcher->set([
            new DummyMiddleware('A'),
            new DummyMiddleware('B'),
            new DummyMiddleware('C'),
            new DummyMiddleware('D'),
            new DummyMiddleware('E')
        ]);

        $response = $middlewareDispatcher->handle($psr17Factory->createServerRequest('GET', '/'));

        self::assertSame('ABCDE', (string) $response->getBody());
    }

    public function testMultipleHandle(): void
    {
        $psr17Factory = new Psr17Factory();
        $middlewareDispatcher = new StackMiddlewareDispatcher($psr17Factory);

        $middlewareDispatcher->set([
            new DummyMiddleware('A'),
            new DummyMiddleware('B'),
            new DummyMiddleware('C'),
            new DummyMiddleware('D'),
            new DummyMiddleware('E')
        ]);

        $response = $middlewareDispatcher->handle($psr17Factory->createServerRequest('GET', '/'));

        self::assertSame('ABCDE', (string) $response->getBody());

        $response = $middlewareDispatcher->handle($psr17Factory->createServerRequest('GET', '/'));

        self::assertSame('ABCDE', (string) $response->getBody());
    }
}
