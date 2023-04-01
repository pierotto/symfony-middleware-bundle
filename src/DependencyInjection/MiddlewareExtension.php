<?php declare(strict_types = 1);

namespace Pierotto\MiddlewareBundle\DependencyInjection;

class MiddlewareExtension extends \Symfony\Component\DependencyInjection\Extension\Extension
{

	/**
	 * @throws \Exception
	 */
	public function load(
		array $configs,
		\Symfony\Component\DependencyInjection\ContainerBuilder $container
	): void
	{
		$loader = new \Symfony\Component\DependencyInjection\Loader\YamlFileLoader(
			$container,
			new \Symfony\Component\Config\FileLocator([__DIR__ . '/../Resources/config'])
		);
		$loader->load('services.yml');
	}

}
