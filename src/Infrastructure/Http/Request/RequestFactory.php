<?php declare(strict_types = 1);

namespace Pierotto\MiddlewareBundle\Infrastructure\Http\Request;

class RequestFactory
{

	public function __construct(
		private readonly \Symfony\Bridge\PsrHttpMessage\HttpMessageFactoryInterface $httpMessageFactory,
		private readonly \Symfony\Bridge\PsrHttpMessage\HttpFoundationFactoryInterface $httpFoundationFactory,
	)
	{
	}


	public function toPsrRequest(
		\Symfony\Component\HttpFoundation\Request $request
	): \Psr\Http\Message\ServerRequestInterface
	{
		return $this->httpMessageFactory->createRequest($request);
	}


	public function fromPsrRequest(
		\Psr\Http\Message\ServerRequestInterface $request
	): \Symfony\Component\HttpFoundation\Request
	{
		return $this->httpFoundationFactory->createRequest($request);
	}

}
