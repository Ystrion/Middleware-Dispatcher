<?php

declare(strict_types=1);

namespace Ystrion\MiddlewareDispatcher;

use InvalidArgumentException;
use Psr\Container\ContainerInterface;
use Psr\Http\Message\ResponseFactoryInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;

abstract class AbstractMiddlewareDispatcher implements RequestHandlerInterface
{
    /** @var array<string|MiddlewareInterface> */
    protected array $middleware = [];

    protected ?int $currentMiddleware = null;

    public function __construct(
        protected ResponseFactoryInterface $responseFactory,
        protected ?ContainerInterface $container = null
    ) {
    }

    /**
     * @return array<string|MiddlewareInterface>
     */
    public function get(): array
    {
        return $this->middleware;
    }

    /**
     * @param array<string|MiddlewareInterface> $middleware
     */
    public function set(array $middleware): self
    {
        $this->middleware = $middleware;

        return $this;
    }

    /**
     * @param array<string|MiddlewareInterface>|string|MiddlewareInterface $middleware
     */
    public function add(array|string|MiddlewareInterface $middleware): self
    {
        if (is_array($middleware)) {
            $this->middleware = array_merge($this->middleware, $middleware);
        } else {
            $this->middleware[] = $middleware;
        }

        return $this;
    }

    public function clear(MiddlewareInterface $middleware): self
    {
        $this->middleware = [];

        return $this;
    }

    public function resolve(string|MiddlewareInterface $middleware): MiddlewareInterface
    {
        if ($this->container !== null && is_string($middleware)) {
            $middleware = $this->container->get($middleware);

            if ($middleware === null) {
                throw new InvalidArgumentException('The middleware was not found in the container.');
            }
        }

        if (!$middleware instanceof MiddlewareInterface) {
            throw new InvalidArgumentException('Your middleware must implement MiddlewareInterface.');
        }

        return $middleware;
    }

    abstract public function handle(ServerRequestInterface $request): ResponseInterface;
}
