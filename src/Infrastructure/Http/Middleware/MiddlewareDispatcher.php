<?php declare(strict_types = 1);

namespace Pierotto\MiddlewareBundle\Infrastructure\Http\Middleware;

final class MiddlewareDispatcher
{

	/**
	 * @param \Psr\Http\Server\MiddlewareInterface[] $middlewares
	 */
	public function __construct(
		private readonly array $middlewares,
		private readonly \Psr\Http\Server\RequestHandlerInterface $requestHandler
	)
	{
	}


	public function dispatch(
		\Psr\Http\Message\ServerRequestInterface $serverRequest
	): \Psr\Http\Message\ResponseInterface
	{
		$processor = \array_reduce(
			$this->middlewares,
			static function (\Closure $handler, \Psr\Http\Server\MiddlewareInterface $middleware): \Closure {
				return static function (\Psr\Http\Message\ServerRequestInterface $request) use ($middleware, $handler): \Psr\Http\Message\ResponseInterface {
					return $middleware->process($request, new \Pierotto\MiddlewareBundle\Infrastructure\Http\Request\RequestMiddlewareHandler($handler));
				};
			},
			fn(\Psr\Http\Message\ServerRequestInterface $request): \Psr\Http\Message\ResponseInterface => $this->requestHandler->handle($request),
		);

		return $processor($serverRequest);
	}

}
