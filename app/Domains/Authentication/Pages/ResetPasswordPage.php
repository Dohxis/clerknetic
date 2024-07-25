<?php

namespace App\Domains\Authentication\Pages;

use App\Domains\Authentication\Forms\ResetPasswordForm;
use App\Domains\Framework\Authentication\Pages\CentralLayout;
use App\Domains\Framework\Layout\Layout;
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
        // This is used by Laravel when it is generating letter for user
        return "password.reset";
    }

    public function layout(): Layout
    {
        return CentralLayout::make()->setTitle($this->title());
    }

    public function nodes(): array
    {
        return [
            ResetPasswordForm::make()
        ];
    }

    public function operations(): array
    {
        return [ResetPasswordForm::class];
    }
}
