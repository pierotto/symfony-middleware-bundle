<?php declare(strict_types = 1);

namespace Pierotto\MiddlewareBundle\Infrastructure\Http\Request;

final class RequestHandler implements \Psr\Http\Server\RequestHandlerInterface
{

	/**
	 * @var callable
	 */
	private $response;


	public function __construct(
		callable $response,
		readonly private \Symfony\Component\HttpFoundation\Request $request,
		readonly private \Pierotto\MiddlewareBundle\Infrastructure\Http\Response\ResponseFactory $responseFactory
	)
	{
		$this->response = $response;
	}


	public function handle(
		\Psr\Http\Message\ServerRequestInterface $request
	): \Psr\Http\Message\ResponseInterface
	{
		$this->request->attributes->replace($request->getAttributes());
		$this->request->headers->replace($request->getHeaders());
		$this->request->query->replace($request->getQueryParams());

		$parsedBody = $request->getParsedBody();
		if (\is_array($parsedBody)) {
			$this->request->request->replace($parsedBody);
		}

		return $this->responseFactory->toPsrResponse(($this->response)($this->request));
	}

}
