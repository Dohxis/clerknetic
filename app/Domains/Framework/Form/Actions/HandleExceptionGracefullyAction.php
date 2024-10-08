<?php

namespace App\Domains\Framework\Form\Actions;

use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Validation\ValidationException;
use App\Domains\Framework\Core\Utilities\Notification;
use Throwable;

class HandleExceptionGracefullyAction
{
	/**
	 * @throws Throwable
	 */
	public function execute(Throwable $throwable): JsonResponse|RedirectResponse
	{
		/**
		 * We don't want to silents this exception, because
		 * Laravel will handle this appropriately.
		 */
		if ($throwable instanceof HttpResponseException) {
			throw $throwable;
		}

		// TODO: instead of checking if its inertia request,
		//       check if request wants json (header "Accept")
		$isInertiaRequest = app(IsInertiaRequestAction::class)->execute(
			request()
		);

		if ($throwable instanceof ValidationException) {
			if ($isInertiaRequest) {
				/**
				 * Validation exception will be handled
				 * by InertiaJS
				 */
				throw $throwable;
			}

			return response()->json([
				"success" => false,
				"data" => null,
				"errors" => array_map(
					fn($fieldErrors) => $fieldErrors[0],
					$throwable->errors()
				),
				"notification" => Notification::getAndClear(),
			]);
		}

		if (app()->isLocal()) {
			throw $throwable;
		}

		report($throwable);

		Notification::danger(
			"Sorry for inconvenience, please try again later."
		);

		if ($isInertiaRequest) {
			return redirect()->back();
		}

		return response()->json([
			"success" => false,
			"data" => null,
			"errors" => [],
			"notification" => Notification::getAndClear(),
		]);
	}
}
