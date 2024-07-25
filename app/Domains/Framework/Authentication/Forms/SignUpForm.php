<?php

namespace App\Domains\Framework\Authentication\Forms;

use App\Domains\Framework\Form\Fields\TextField;
use App\Domains\Framework\Form\Form;
use App\Domains\Framework\Form\Form\FormButton;
use App\Domains\Framework\Form\ProcessableForm;
use Illuminate\Validation\Rule;

class SignUpForm extends ProcessableForm
{
    public function route(): string
    {
        return "/sign-up";
    }

    protected function form(Form $form): Form
    {
        return $form
            ->withoutPanel()
            ->setNodes([
                TextField::make("Organization"),
                TextField::make("Full name"),
                TextField::make("Email")
                    ->presetEmail()
                    ->addValidationRule(Rule::unique("users")),
                TextField::make("Password")
                    ->presetPassword(),
                FormButton::make()->setTitle("Sign up"),
            ]);
    }

    public function handle(object $validated)
    {
        ray($validated);

        return redirect()->back();
    }
}
