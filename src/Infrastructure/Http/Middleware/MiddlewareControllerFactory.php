<?php declare(strict_types = 1);

namespace Pierotto\MiddlewareBundle\Infrastructure\Http\Middleware;

final class MiddlewareControllerFactory
{

	public function __construct(
		private readonly \Pierotto\MiddlewareBundle\Infrastructure\Http\Response\ResponseFactory $responseFactory,
		private readonly \Pierotto\MiddlewareBundle\Infrastructure\Http\Request\RequestFactory $requestFactory,
		private readonly \Pierotto\MiddlewareBundle\Infrastructure\Http\Request\RequestHandlerFactory $requestHandlerFactory
	)
	{
	}


	/**
	 * @param array<object|scalar> $arguments
	 */
	public function create(
		callable $controller,
		array $arguments,
		\Symfony\Component\HttpFoundation\Request $request,
		\Psr\Http\Server\MiddlewareInterface ...$middlewares,
	): \Pierotto\MiddlewareBundle\Infrastructure\Http\Middleware\MiddlewareController
	{
		return new \Pierotto\MiddlewareBundle\Infrastructure\Http\Middleware\MiddlewareController(
			new \Pierotto\MiddlewareBundle\Infrastructure\Http\Middleware\MiddlewareDispatcher(
				\array_reverse($middlewares),
				$this->requestHandlerFactory->create(
					$controller,
					$arguments,
					$request
				),
			),
			$this->requestFactory->toPsrRequest($request),
			$this->responseFactory
		);
	}

}
