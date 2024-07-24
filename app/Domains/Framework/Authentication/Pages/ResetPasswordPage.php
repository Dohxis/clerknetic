<?php

namespace App\Domains\Framework\Authentication\Pages;

use App\Domains\Framework\Authentication\Forms\ResetPasswordForm;
use App\Domains\Framework\Component\Components\Panel;
use App\Domains\Framework\Layout\Layout;
use App\Domains\Framework\Layout\Layouts\CentralLayout;
use App\Domains\Framework\Layout\Layouts\UnauthorizedLayout\UnauthorizedLayout;
use App\Domains\Framework\Page\Page;

class ResetPasswordPage extends Page
{
	public function title(): string
	{
		return "Change account password";
	}

	public function route(): string
	{
		return "/auth/password/reset/{token}/{email}";
	}

	public function routeName(): ?string
	{
		/**
		 * This is used by Laravel when it is generating
		 * letter for user.
		 */
		return "password.reset";
	}

	public function layout(): Layout
	{
		return CentralLayout::make()->setTitle($this->title());
	}

	public function nodes(): array
	{
		return [
			Panel::make()
				->setPadding(10)
				->setNodes([ResetPasswordForm::make()]),
		];
	}

	public function operations(): array
	{
		return [ResetPasswordForm::class];
	}
}
