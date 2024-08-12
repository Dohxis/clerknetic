<?php

namespace App\Domains\Authentication\Pages;

use App\Domains\Framework\Component\Components\Panel;
use App\Domains\Framework\Component\Components\Text;
use App\Domains\Framework\Layout\Layout;
use App\Domains\Framework\Layout\Layouts\UnauthorizedLayout\UnauthorizedLayout;
use App\Domains\Framework\Page\Page;

class ForgotPasswordEmailSentPage extends Page
{
	public function title(): string
	{
		return "Reset password";
	}

	public function route(): string
	{
		return "/password/sent";
	}

	public function layout(): Layout
	{
		return UnauthorizedLayout::make();
	}

	public function nodes(): array
	{
		return [
			Panel::make()
				->setPadding(10)
				->setNodes([Text::make("passwords.sent")]),
		];
	}
}
