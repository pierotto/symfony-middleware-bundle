<?php declare(strict_types = 1);

namespace Pierotto\MiddlewareBundle\Domain\Exception;

class MiddlewareNotConfiguredException extends \Exception
{

	public function __construct(
		\Pierotto\MiddlewareBundle\Infrastructure\Attribute\Middleware $middleware
	)
	{
		parent::__construct(
			\sprintf('Middleware "%s" not found. Middleware must be a registered service in the container and have the "middleware" tag.', $middleware->getMiddleware())
		);
	}

}
