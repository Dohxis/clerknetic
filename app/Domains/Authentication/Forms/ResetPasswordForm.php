<?php

namespace App\Domains\Authentication\Forms;

use App\Domains\Framework\Core\Utilities\Notification;
use App\Domains\Framework\Form\Fields\TextField;
use App\Domains\Framework\Form\Form;
use App\Domains\Framework\Form\Form\FormButton;
use App\Domains\Framework\Form\ProcessableForm;
use Exception;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;
use Throwable;

class ResetPasswordForm extends ProcessableForm
{
	public function route(): string
	{
		return "/auth/password/reset/{token}/{email}";
	}

	/**
	 * @throws Exception
	 */
	protected function form(Form $form): Form
	{
		/** @var string $email */
		$email = $this->resolve(null, "email");

		return $form
			->withoutPanel()
			->setNodes([
				TextField::make("Email")
					->setDefaultValue($email)
					->setDisabled(),
				TextField::make("New password")->presetPassword(),
				FormButton::make()->setTitle("Update password"),
			]);
	}

	/**
	 * @throws Throwable
	 */
	public function handle(object $validated)
	{
		/** @var string $token */
		$token = $this->resolve(null, "token");

		$status = Password::reset(
			[
				"token" => $token,
				"email" => $validated->email,
				"password" => $validated->new_password,
			],
			function ($user) use ($validated) {
				$user
					->forceFill([
						"password" => Hash::make($validated->new_password),
						"remember_token" => Str::random(60),
					])
					->save();
			}
		);

		if ($status !== Password::PASSWORD_RESET) {
			/** @phpstan-ignore-next-line */
			Notification::danger(__($status));

			return redirect()->back();
		}

		/** @phpstan-ignore-next-line */
		Notification::success(__($status));

		return redirect()->route("login");
	}
}
