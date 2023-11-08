<?php

declare(strict_types=1);

namespace Ystrion\MiddlewareDispatcher\Tests\Utils;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;

class DummyMiddleware implements MiddlewareInterface
{
    private string $message;

    public function __construct(string $message)
    {
        $this->message = $message;
    }

    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        $response = $handler->handle($request);

        $response->getBody()->write($this->message);

        return $response;
    }
}
