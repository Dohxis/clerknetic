<?php

namespace App\Domains\Authentication\Operations;

use App\Domains\Framework\Form\Operation;

class LogoutOperation extends Operation
{
    public function route(): string
    {
        return "/logout";
    }

    public function handle(object $validated)
    {
        if (auth()->check()) {
            auth()->logout();

            request()->session()->invalidate();

            request()->session()->regenerateToken();
        }


        return redirect()->to("/");
    }
}
