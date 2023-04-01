<?php declare(strict_types = 1);

namespace Pierotto\MiddlewareBundle\Infrastructure\Http\Request;

final class RequestHandlerFactory
{

	public function __construct(
		private readonly \Pierotto\MiddlewareBundle\Infrastructure\Http\Response\ResponseFactory $responseFactory
	)
	{
	}


	/**
	 * @param array<object|scalar> $arguments
	 */
	public function create(
		callable $controller,
		array $arguments,
		\Symfony\Component\HttpFoundation\Request $request
	): \Pierotto\MiddlewareBundle\Infrastructure\Http\Request\RequestHandler
	{
		return new \Pierotto\MiddlewareBundle\Infrastructure\Http\Request\RequestHandler(
			function (\Symfony\Component\HttpFoundation\Request $request) use ($controller, $arguments): \Symfony\Component\HttpFoundation\Response {
				return $controller(...$this->withReplacedRequest($request, $arguments));
			},
			$request,
			$this->responseFactory
		);
	}


	/**
	 * @param array<object|scalar> $arguments
	 *
	 * @return array<object|scalar>
	 */
	private function withReplacedRequest(
		\Symfony\Component\HttpFoundation\Request $request,
		array $arguments
	): array
	{
		return \array_map(static fn($arg) => $arg instanceof \Symfony\Component\HttpFoundation\Request ? $request : $arg, $arguments);
	}

}
