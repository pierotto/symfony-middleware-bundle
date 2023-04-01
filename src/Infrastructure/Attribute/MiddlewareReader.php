<?php declare(strict_types = 1);

namespace Pierotto\MiddlewareBundle\Infrastructure\Attribute;

final class MiddlewareReader
{

	public function __construct(
		private readonly \Symfony\Contracts\Cache\CacheInterface $cache
	)
	{
	}


	/**
	 * @throws \Psr\Cache\InvalidArgumentException
	 * @throws \ReflectionException
	 */
	public function getMiddlewareAttributes(
		string $controllerName,
		string $methodName
	): array
	{
		return $this->cache->get($this->getCacheKey($controllerName, $methodName), static function () use ($controllerName, $methodName) {
			$class = new \ReflectionClass($controllerName);
			$rm = $class->getMethod($methodName);
			$attributes = $rm->getAttributes(\Pierotto\MiddlewareBundle\Infrastructure\Attribute\Middleware::class);

			return \array_map(static function (\ReflectionAttribute $attribute): \Pierotto\MiddlewareBundle\Infrastructure\Attribute\Middleware {
				return $attribute->newInstance();
			}, $attributes);
		});
	}


	private function getCacheKey(
		string $controllerName,
		string $methodName
	): string
	{
		$controllerName = \str_replace('\\', '', $controllerName);

		return \sprintf('middleware.attributes.%s.%s', $controllerName, $methodName);
	}

}
