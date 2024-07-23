<?php

use App\Http\Controllers\Authentication\AuthenticatedSessionController;
use App\Http\Controllers\Authentication\ConfirmablePasswordController;
use App\Http\Controllers\Authentication\EmailVerificationNotificationController;
use App\Http\Controllers\Authentication\EmailVerificationPromptController;
use App\Http\Controllers\Authentication\NewPasswordController;
use App\Http\Controllers\Authentication\PasswordController;
use App\Http\Controllers\Authentication\PasswordResetLinkController;
use App\Http\Controllers\Authentication\RegisteredUserController;
use App\Http\Controllers\Authentication\VerifyEmailController;
use Illuminate\Support\Facades\Route;

foreach (config("tenancy.central_domains") as $domain) {
	Route::domain($domain)->group(function () {
		Route::middleware("guest")->group(function () {
			Route::get("sign-in", [
				AuthenticatedSessionController::class,
				"create",
			])->name("login");

			Route::post("sign-in", [
				AuthenticatedSessionController::class,
				"store",
			]);

			Route::get("sign-up", [
				RegisteredUserController::class,
				"create",
			])->name("register");

			Route::post("sign-up", [RegisteredUserController::class, "store"]);

			Route::get("forgot-password", [
				PasswordResetLinkController::class,
				"create",
			])->name("password.request");

			Route::post("forgot-password", [
				PasswordResetLinkController::class,
				"store",
			])->name("password.email");

			Route::get("reset-password/{token}", [
				NewPasswordController::class,
				"create",
			])->name("password.reset");

			Route::post("reset-password", [
				NewPasswordController::class,
				"store",
			])->name("password.store");
		});

		Route::middleware("auth")->group(function () {
			Route::get(
				"verify-email",
				EmailVerificationPromptController::class
			)->name("verification.notice");

			Route::get("verify-email/{id}/{hash}", VerifyEmailController::class)
				->middleware(["signed", "throttle:6,1"])
				->name("verification.verify");

			Route::post("email/verification-notification", [
				EmailVerificationNotificationController::class,
				"store",
			])
				->middleware("throttle:6,1")
				->name("verification.send");

			Route::get("confirm-password", [
				ConfirmablePasswordController::class,
				"show",
			])->name("password.confirm");

			Route::post("confirm-password", [
				ConfirmablePasswordController::class,
				"store",
			]);

			Route::put("password", [PasswordController::class, "update"])->name(
				"password.update"
			);

			Route::post("logout", [
				AuthenticatedSessionController::class,
				"destroy",
			])->name("logout");
		});
	});
}
