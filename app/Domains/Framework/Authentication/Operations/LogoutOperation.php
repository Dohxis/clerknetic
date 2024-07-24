<?php

namespace App\Domains\Framework\Authentication\Operations;

use App\Domains\Framework\Authentication\Actions\LogoutUserAction;
use App\Domains\Framework\Form\Operation;

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
