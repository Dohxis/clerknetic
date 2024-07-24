<?php

namespace App\Domains\Framework\Authentication\Operations;

use Arpite\Authentication\Actions\LogoutUserAction;
use Arpite\Form\Operation;

class LogoutOperation extends Operation
{
	public function route(): string
	{
		return "/auth/logout";
	}

	public function handle(object $validated)
	{
		app(LogoutUserAction::class)->execute();

		return redirect()->to("/");
	}
}
