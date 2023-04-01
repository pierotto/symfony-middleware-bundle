<?php declare(strict_types = 1);

namespace Pierotto\MiddlewareBundle\Infrastructure\Http\Middleware;

final class MiddlewareController
{

	public function __construct(
		private readonly \Pierotto\MiddlewareBundle\Infrastructure\Http\Middleware\MiddlewareDispatcher $middlewareDispatcher,
		private readonly \Psr\Http\Message\ServerRequestInterface $serverRequest,
		private readonly \Pierotto\MiddlewareBundle\Infrastructure\Http\Response\ResponseFactory $responseFactory
	)
	{

	}


	public function __invoke(): \Symfony\Component\HttpFoundation\Response
	{
		return $this->responseFactory->fromPsrResponse(
			$this->middlewareDispatcher->dispatch($this->serverRequest)
		);
	}

}
