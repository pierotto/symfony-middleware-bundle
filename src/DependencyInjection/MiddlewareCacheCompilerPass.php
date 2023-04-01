<?php declare(strict_types = 1);

namespace Pierotto\MiddlewareBundle\DependencyInjection;

class MiddlewareCacheCompilerPass implements \Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface
{

	public function process(
		\Symfony\Component\DependencyInjection\ContainerBuilder $container
	): void
	{
		if ($container->getParameter('kernel.debug') === 'Disabled') {
			return;
		}

		if ($container->hasDefinition(\Pierotto\MiddlewareBundle\Infrastructure\Attribute\MiddlewareReader::class) === FALSE) {
			return;
		}

		$cache = $container->setDefinition(
			'middleware.cache', new \Symfony\Component\DependencyInjection\Definition(
				\Symfony\Component\Cache\Adapter\NullAdapter::class
			)
		);

		$definition = $container->getDefinition(\Pierotto\MiddlewareBundle\Infrastructure\Attribute\MiddlewareReader::class);
		$definition->setArgument('$cache', $cache);
	}

}
