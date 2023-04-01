<?php declare(strict_types = 1);

namespace Pierotto\MiddlewareBundle\Domain\Event\Listener;

class ControllerListener
{

	public function __construct(
		private readonly \Pierotto\MiddlewareBundle\Infrastructure\Http\Middleware\MiddlewareControllerFactory $middlewareControllerFactory,
		private readonly \Pierotto\MiddlewareBundle\Infrastructure\Attribute\MiddlewareReader $middlewareReader,
		private readonly \Pierotto\MiddlewareBundle\Infrastructure\Container\ContainerMiddlewareFactory $containerMiddlewareFactory
	)
	{
	}


	/**
	 * @throws \Psr\Cache\InvalidArgumentException
	 * @throws \Pierotto\MiddlewareBundle\Domain\Exception\MiddlewareNotConfiguredException
	 */
	public function onControllerArguments(
		\Symfony\Component\HttpKernel\Event\ControllerArgumentsEvent $event
	): void
	{
		$eventController = $event->getController();

		if (\is_array($eventController) === FALSE) {
			return;
		}

		[$controller, $method] = $eventController;

		$middlewares = $this->middlewareReader->getMiddlewareAttributes(
			\get_class($controller),
			$method
		);

		if (\count($middlewares) === 0) {
			return;
		}

		$event->setController(
			$this->middlewareControllerFactory->create(
				$eventController,
				$event->getArguments(),
				$event->getRequest(),
				... $this->containerMiddlewareFactory->get($middlewares)
			)
		);
	}

}

