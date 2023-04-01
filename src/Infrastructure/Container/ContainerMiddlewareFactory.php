<?php declare(strict_types = 1);

namespace Pierotto\MiddlewareBundle\Infrastructure\Container;

class ContainerMiddlewareFactory
{

	/**
	 * @var \Psr\Http\Server\MiddlewareInterface[]
	 */
	private array $middlewares;


	public function __construct(
		\Psr\Http\Server\MiddlewareInterface ...$middlewares
	)
	{
		$this->middlewares = $middlewares;
	}


	/**
	 * @throws \Pierotto\MiddlewareBundle\Domain\Exception\MiddlewareNotConfiguredException
	 * @return \Psr\Http\Server\MiddlewareInterface[]
	 *
	 * @param \Pierotto\MiddlewareBundle\Infrastructure\Attribute\Middleware[] $middlewares
	 */
	public function get(
		array $middlewares
	): array
	{
		$services = [];
		foreach ($middlewares as $attribute) {
			$found = FALSE;
			foreach ($this->middlewares as $middleware) {
				if ($middleware instanceof ($attribute->getMiddleware())) {
					$services[] = $middleware;
					$found = TRUE;
					break;
				}
			}
			if ($found === FALSE) {
				throw new \Pierotto\MiddlewareBundle\Domain\Exception\MiddlewareNotConfiguredException($attribute);
			}
		}

		return $services;
	}

}
