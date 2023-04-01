<?php declare(strict_types = 1);

namespace Pierotto\MiddlewareBundle;

class MiddlewareBundle extends \Symfony\Component\HttpKernel\Bundle\Bundle
{

	public function build(\Symfony\Component\DependencyInjection\ContainerBuilder $container): void
	{
		$container->addCompilerPass(new \Pierotto\MiddlewareBundle\DependencyInjection\MiddlewareCompilerPass());
		$container->addCompilerPass(new \Pierotto\MiddlewareBundle\DependencyInjection\MiddlewareCacheCompilerPass());
	}

}
