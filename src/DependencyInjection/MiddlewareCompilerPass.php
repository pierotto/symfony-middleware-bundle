<?php declare(strict_types = 1);

namespace Pierotto\MiddlewareBundle\DependencyInjection;

class MiddlewareCompilerPass implements \Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface
{

	private const TAG_MIDDLEWARE = 'middleware';


	public function process(
		\Symfony\Component\DependencyInjection\ContainerBuilder $container
	): void
	{
		if ($container->hasDefinition(\Pierotto\MiddlewareBundle\Infrastructure\Container\ContainerMiddlewareFactory::class) === FALSE) {
			return;
		}

		$middlewares = [];

		$definition = $container->getDefinition(\Pierotto\MiddlewareBundle\Infrastructure\Container\ContainerMiddlewareFactory::class);
		foreach ($container->findTaggedServiceIds(self::TAG_MIDDLEWARE) as $middleware => $tags) {
			$middlewares[] = $container->getDefinition($middleware);
		}

		$definition->setArgument('$middlewares', $middlewares);
	}

}
