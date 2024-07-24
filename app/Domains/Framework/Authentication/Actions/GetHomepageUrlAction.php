<?php

namespace App\Domains\Framework\Authentication\Actions;

use App\Domains\Framework\Authentication\Exceptions\HomepageNotFoundException;

class GetHomepageUrlAction
{
	/**
	 * @throws HomepageNotFoundException
	 */
	public function execute(): string
	{
		/** @var class-string<mixed> $routeServiceProviderClass */
		$routeServiceProviderClass = "App\Providers\RouteServiceProvider";

		if (
			class_exists($routeServiceProviderClass) &&
			method_exists($routeServiceProviderClass, "getHomepage")
		) {
			return $routeServiceProviderClass::getHomepage();
		}

		if (defined($routeServiceProviderClass . "::HOME")) {
			return $routeServiceProviderClass::HOME;
		}

		throw new HomepageNotFoundException();
	}
}
