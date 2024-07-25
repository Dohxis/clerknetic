<?php

namespace App\Domains\Core\Middlewares;

use App\Domains\Framework\Core\Utilities\Notification;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\URL;
use Inertia\Middleware;

class HandleInertiaRequestsMiddleware extends Middleware
{
	/** @var string */
	protected $rootView = "app";

	public function version(Request $request): string|null
	{
		return parent::version($request);
	}

	/** @return array<string, mixed> */
	public function share(Request $request): array
	{
		/** @var User|null $user */
		$user = auth()->check() ? auth()->user() : null;

		return [
			...parent::share($request),
			"baseUrl" => fn() => URL::to("/"),
			"applicationName" => config("app.name"),
			"notification" => Notification::getAndClear(),
			"resetFormIdentifier" => fn() => Session::get(
				"resetFormIdentifier"
			),
			"csrfToken" => fn() => csrf_token(),
			"user" => $user?->only("email", "name"),
			"balance" => null,
			"auth" => [
				"user" => $request->user(),
			],
		];
	}
}
