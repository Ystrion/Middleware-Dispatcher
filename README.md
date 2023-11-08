<div align="center">
  <h3>Middleware Dispatcher</h3>

  <p align="center">Two middleware dispatchers (PSR-15).</p>

  [![Latest Stable Version](http://poser.pugx.org/ystrion/middleware-dispatcher/v)](https://packagist.org/packages/ystrion/middleware-dispatcher)
  [![Latest Unstable Version](http://poser.pugx.org/ystrion/middleware-dispatcher/v/unstable)](https://packagist.org/packages/ystrion/middleware-dispatcher)
  [![License](http://poser.pugx.org/ystrion/middleware-dispatcher/license)](https://packagist.org/packages/ystrion/middleware-dispatcher)
</div>

## Getting Started

### Prerequisites

- PHP (>= 8.2)
- Composer
- [PSR-7](https://www.php-fig.org/psr/psr-7/) and [PSR-17](https://www.php-fig.org/psr/psr-17/) implementation
- [PSR-11](https://www.php-fig.org/psr/psr-11/) implementation (optional)

### Installation

This package can be installed with Composer using this command:

```sh
composer require ystrion/middleware-dispatcher
```

## Usage

There are two middleware dispatchers:

- `QueueMiddlewareDispatcher` (FIFO)
- `StackMiddlewareDispatcher` (LIFO)

The examples below use `StackMiddlewareDispatcher`, but both are used the same way.

### Basic

```php
use Ystrion\MiddlewareDispatcher\StackMiddlewareDispatcher;

$responseFactory = new ResponseFactory(); // Your PSR-17 implementation
$request = new ServerRequest(); // Your PSR-7 implementation

// Create the middleware dispatcher
$middlewareDispatcher = new StackMiddlewareDispatcher($responseFactory);

// Add multiple middleware to dispatcher
$middlewareDispatcher->add([
  new FirstMiddleware(),
  new SecondMiddleware()
]);

// Produce a response
$response = $middlewareDispatcher->handle($request);
```

### Advanced (with container)

```php
use Ystrion\MiddlewareDispatcher\StackMiddlewareDispatcher;

$responseFactory = new ResponseFactory(); // Your PSR-17 implementation
$request = new ServerRequest(); // Your PSR-7 implementation
$container = new Container(); // Your PSR-11 implementation

// Create the middleware dispatcher
$middlewareDispatcher = new StackMiddlewareDispatcher($responseFactory, $container);

// Add multiple middleware to dispatcher
$middlewareDispatcher->add([
  new FirstMiddleware(),
  new SecondMiddleware(),
  ThirdMiddleware::class
]);

// Produce a response
$response = $middlewareDispatcher->handle($request);
```

## License

This package is distributed under the [MIT license](https://github.com/Ystrion/Middleware-Dispatcher/blob/main/LICENSE).

## Contact

- To report a security or related issue: [GitHub Security](https://github.com/Ystrion/Middleware-Dispatcher/security)
- To report a problem or post a feature idea: [GitHub Issues](https://github.com/Ystrion/Middleware-Dispatcher/issues)
- If you encounter any problem while installing or using: [GitHub Discussions](https://github.com/Ystrion/Middleware-Dispatcher/discussions)
- For any other reason: [ystrion@deville.dev](mailto:ystrion@deville.dev)
