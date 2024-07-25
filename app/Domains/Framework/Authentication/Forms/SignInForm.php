<?php

namespace App\Domains\Framework\Authentication\Forms;

use App\Domains\Framework\Authentication\Exceptions\HomepageNotFoundException;
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
use App\Domains\Tenancy\Models\Tenant;
use App\Models\OrganizationUser;
use App\Models\User;
use App\Providers\AppServiceProvider;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Str;

class SignInForm extends ProcessableForm
{
	public function route(): string
	{
		return "/sign-in";
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

					Link::make()
						->setTitle("Forgot your password?")
						->setTextAlign(Align::RIGHT)
						->toPage(ForgotPasswordPage::class),
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
			"sign-in|" . $validated->email . "|" . request()->ip()
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

		$user = User::whereEmail($validated->email)->first();

		$organizationUser = OrganizationUser::whereUserId($user->id)->first();

		$tenant = Tenant::find($organizationUser->organization->tenant_id);

		if (!$tenant) {
			return $this->sendFailedAuthenticationMessage($throttleKey);
		}

		$tenant->run(function () use (
			$organizationUser,
			$validated,
			$throttleKey
		) {
			$isValidAuthenticationAttempt = Auth::attempt(
				[
					"email" => $validated->email,
					"password" => $validated->password,
				],
				$validated->remember_me
			);

			if (!$isValidAuthenticationAttempt) {
				return $this->sendFailedAuthenticationMessage($throttleKey);
			}

			RateLimiter::clear($throttleKey);

			session()->regenerate();

			return redirect()->intended(AppServiceProvider::getHomepage());
		});

		return $this->sendFailedAuthenticationMessage($throttleKey);
	}

	private function sendFailedAuthenticationMessage(string $throttleKey)
	{
		RateLimiter::hit($throttleKey);

		/** @phpstan-ignore-next-line */
		Notification::danger(__("auth.failed"));

		return redirect()->back();
	}
}
