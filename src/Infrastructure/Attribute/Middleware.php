<?php declare(strict_types = 1);

namespace Pierotto\MiddlewareBundle\Infrastructure\Attribute;

#[\Attribute(\Attribute::TARGET_METHOD | \Attribute::IS_REPEATABLE)]
final class Middleware
{

	public function __construct(
		private readonly string $middleware
	)
	{
	}


	public function getMiddleware(): string
	{
		return $this->middleware;
	}

}
