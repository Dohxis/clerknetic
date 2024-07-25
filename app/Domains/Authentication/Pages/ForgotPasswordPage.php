<?php

namespace App\Domains\Authentication\Pages;

use App\Domains\Authentication\Forms\ForgotPasswordForm;
use App\Domains\Framework\Layout\Layout;
use App\Domains\Framework\Layout\Layouts\UnauthorizedLayout\UnauthorizedLayout;
use App\Domains\Framework\Page\Page;

class ForgotPasswordPage extends Page
{
    public function title(): string
    {
        return "Reset password";
    }

    public function route(): string
    {
        return "/password/reset";
    }

    public function layout(): Layout
    {
        return UnauthorizedLayout::make();
    }

    public function nodes(): array
    {
        return [
            ForgotPasswordForm::make()
        ];
    }

    public function operations(): array
    {
        return [ForgotPasswordForm::class];
    }
}
