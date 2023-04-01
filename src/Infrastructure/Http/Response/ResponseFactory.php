<?php declare(strict_types = 1);

namespace Pierotto\MiddlewareBundle\Infrastructure\Http\Response;

class ResponseFactory
{

	public function __construct(
		private readonly \Symfony\Bridge\PsrHttpMessage\HttpMessageFactoryInterface $httpMessageFactory,
		private readonly \Symfony\Bridge\PsrHttpMessage\HttpFoundationFactoryInterface $httpFoundationFactory,
	)
	{
	}


	public function toPsrResponse(
		\Symfony\Component\HttpFoundation\Response $request
	): \Psr\Http\Message\ResponseInterface
	{
		return $this->httpMessageFactory->createResponse($request);
	}


	public function fromPsrResponse(
		\Psr\Http\Message\ResponseInterface $request
	): \Symfony\Component\HttpFoundation\Response
	{
		return $this->httpFoundationFactory->createResponse($request);
	}

}
