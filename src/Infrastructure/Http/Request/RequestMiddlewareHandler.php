<?php declare(strict_types = 1);

namespace Pierotto\MiddlewareBundle\Infrastructure\Http\Request;

final class RequestMiddlewareHandler implements \Psr\Http\Server\RequestHandlerInterface
{

	/**
	 * @var \Closure(\Psr\Http\Message\ServerRequestInterface): \Psr\Http\Message\ResponseInterface
	 */
	private \Closure $stack;


	/**
	 * @param \Closure(\Psr\Http\Message\ServerRequestInterface): \Psr\Http\Message\ResponseInterface $stack
	 */
	public function __construct(\Closure $stack)
	{
		$this->stack = $stack;
	}


	public function handle(\Psr\Http\Message\ServerRequestInterface $request): \Psr\Http\Message\ResponseInterface
	{
		return ($this->stack)($request);
	}

}
