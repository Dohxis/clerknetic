<?php

namespace App\Domains\Framework\Authentication\Forms;

use App\Domains\Framework\Authentication\Actions\GetHomepageUrlAction;
use App\Domains\Framework\Authentication\Exceptions\HomepageNotFoundException;
use App\Domains\Framework\Authentication\Pages\AuthenticationPages;
use App\Domains\Framework\Authentication\Pages\ForgotPasswordPage;
use App\Domains\Framework\Component\Components\Flex\Enums\Justify;
use App\Domains\Framework\Component\Components\Flex\Flex;
use App\Domains\Framework\Component\Components\Link\Link;
use App\Domains\Framework\Component\Enums\Align;
use App\Domains\Framework\Core\Utilities\Notification;
use App\Domains\Framework\Form\Fields\CheckboxField;
use App\Domains\Framework\Form\Fields\TextField;
use App\Domains\Framework\Form\Form;
use App\Domains\Framework\Form\Form\FormButton;
use App\Domains\Framework\Form\ProcessableForm;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Str;

class LoginForm extends ProcessableForm
{
	public function route(): string
	{
		return "/auth/login";
	}

	protected function form(Form $form): Form
	{
		return $form->withoutPanel()->setNodes([
			TextField::make("Email")->setType("email"),
			TextField::make("Password")->setType("password"),
			Flex::make()
				->setJustify(Justify::BETWEEN)
				->setNodes([
					CheckboxField::make("Remember me"),

					AuthenticationPages::isPasswordResetEnabled()
						? Link::make()
							->setTitle("Forgot your password?")
							->setTextAlign(Align::RIGHT)
							->toPage(ForgotPasswordPage::class)
						: null,
				]),
			FormButton::make()->setTitle("Login"),
		]);
	}

	/**
	 * @throws HomepageNotFoundException
	 */
	public function handle(object $validated)
	{
		$throttleKey = Str::lower(
			"login|" . $validated->email . "|" . request()->ip()
		);

		$isRateLimitReached = RateLimiter::tooManyAttempts($throttleKey, 5);
		if ($isRateLimitReached) {
			Notification::danger(
				trans("auth.throttle", [
					"seconds" => RateLimiter::availableIn($throttleKey),
				])
			);

			return redirect()->back();
		}

		if (
			!Auth::attempt(
				[
					"email" => $validated->email,
					"password" => $validated->password,
				],
				$validated->remember_me
			)
		) {
			RateLimiter::hit($throttleKey);

			/** @phpstan-ignore-next-line */
			Notification::danger(__("auth.failed"));

			return redirect()->back();
		}

		RateLimiter::clear($throttleKey);

		session()->regenerate();

		/** @var GetHomepageUrlAction $getHomepageUrl */
		$getHomepageUrl = app(GetHomepageUrlAction::class);

		return redirect()->intended($getHomepageUrl->execute());
	}
}
