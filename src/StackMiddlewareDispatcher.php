<?php

declare(strict_types=1);

namespace Ystrion\MiddlewareDispatcher;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class StackMiddlewareDispatcher extends AbstractMiddlewareDispatcher
{
    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        if ($this->currentMiddleware === null) {
            $this->currentMiddleware = count($this->middleware) - 1;
        } else {
            $this->currentMiddleware -= 1;
        }

        if ($this->currentMiddleware === -1) {
            $this->currentMiddleware = null;

            return $this->responseFactory->createResponse(200);
        }

        return $this->resolve($this->middleware[$this->currentMiddleware])->process($request, $this);
    }
}
