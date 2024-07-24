<?php

namespace App\Domains\Framework\Authentication\Forms;

use App\Domains\Framework\Authentication\Actions\CreateOrUpdateUserAction;
use App\Domains\Framework\Authentication\Factories\UserFormFactory;
use App\Domains\Framework\Core\Utilities\Notification;
use App\Domains\Framework\Form\Form;
use App\Domains\Framework\Form\ProcessableForm;
use Domain\Team\Models\User;

class UserEditForm extends ProcessableForm
{
	protected bool $resetAfterSubmit = true;

	public function route(): string
	{
		return "/user/edit";
	}

	protected function form(Form $form): Form
	{
		/** @var User $user */
		$user = auth()->user();

		return $form
			->setTitle("Edit profile")
			->setSubmitButtonText("Update")
			->setPreserveScroll()
			->setValues([
				"full_name" => $user->name,
				"email" => $user->email,
			])
			->setNodes(UserFormFactory::fields(user: $user));
	}

	public function handle(object $validated)
	{
		/** @var User $user */
		$user = auth()->user();

		app(CreateOrUpdateUserAction::class)->execute(
			validated: $validated,
			user: $user
		);

		Notification::success("User has been updated.");

		return redirect()->back();
	}
}
