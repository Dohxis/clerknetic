<?php

namespace App\Domains\Framework\Authentication\Forms;

use App\Domains\Framework\Authentication\Actions\CreateOrUpdateUserAction;
use App\Domains\Framework\Authentication\Factories\UserFormFactory;
use App\Domains\Framework\Form\Form;
use App\Domains\Framework\Form\Form\FormButton;
use App\Domains\Framework\Form\ProcessableForm;
use App\Providers\AppServiceProvider;
use Domain\Team\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Auth;

class RegisterForm extends ProcessableForm
{
    public function route(): string
    {
        return "/auth/register";
    }

    protected function form(Form $form): Form
    {
        return $form
            ->withoutPanel()
            ->setNodes([
                ...UserFormFactory::fields(user: null),
                FormButton::make()->setTitle("Register"),
            ]);
    }

    public function handle(object $validated)
    {
        $user = app(CreateOrUpdateUserAction::class)->execute(
            validated: $validated,
            user: null
        );

        /** @phpstan-ignore-next-line */
        Auth::login($user);

        /** @phpstan-ignore-next-line */
        event(new Registered($user));

        return redirect(redirect(AppServiceProvider::getHomepage()));
    }
}
