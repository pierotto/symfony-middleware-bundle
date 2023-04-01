# Middleware bundle
This Symfony extension makes it possible to implement middleware for editing requests and responses within a Symfony application. Middlewares are registered as services in a container and run in the order they are defined in code.

## Installation

The package can be installed using Composer with the command::

`$ composer require pierotto/symfony-middleware-bundle`

After installing the package, it needs to be registered in `AppKernel.php`:

```
public function registerBundles(): array
{
    $bundles = [
        new \Pierotto\MiddlewareBundle\MiddlewareBundle(),
    ];
}
```

## Usage

To use middleware, you need to create your own class that 
implements `\Psr\Http\Server\MiddlewareInterface`. Then this class can be 
registered as a service in the container and set the middleware tag.

For example, request modification middleware can be implemented as follows:
```
namespace Api\Http\Middleware;

class CustomMiddleware implements \Psr\Http\Server\MiddlewareInterface
{

	public function process(
		\Psr\Http\Message\ServerRequestInterface $request,
		\Psr\Http\Server\RequestHandlerInterface $handler
	): \Psr\Http\Message\ResponseInterface
	{
		return $handler->handle($request->withAttribute('test', 'test'));
	}

}
```

The response editing middleware could look like this:

```
namespace Api\Http\Middleware;

class NotFoundMiddleware implements \Psr\Http\Server\MiddlewareInterface
{

	public function process(
		\Psr\Http\Message\ServerRequestInterface $request,
		\Psr\Http\Server\RequestHandlerInterface $handler
	): \Psr\Http\Message\ResponseInterface
	{
		return new \Nyholm\Psr7\Response\Response(404);
	}

}
```

Then you need to register the created middleware as services in `services.yml` and set the `middleware` tag to them:

```
Api\Http\Middleware\CustomMiddleware:
        tags: [ 'middleware' ]
```

Middleware can then be used when calling controller 
methods by adding the `\Application\MiddlewareBundle\Infrastructure\Attribute\Middleware` attribute with the value of the middleware class name. The middleware is started in the order in which the attributes are defined.

```
#[\Application\MiddlewareBundle\Infrastructure\Attribute\Middleware(Api\Http\Middleware\CustomMiddleware::class)]
	public function defaultAction(
		\Symfony\Component\HttpFoundation\Request $request
	): \Symfony\Component\HttpFoundation\Response
```
