<?php

use App\Domains\Authentication\Operations\LogoutOperation;
use App\Domains\Authentication\Pages\SignInPage;
use App\Domains\Authentication\Pages\SignUpPage;
use App\Providers\AppServiceProvider;
use Illuminate\Support\Facades\Route;

Route::middleware(["guest"])->group(function () {
	SignInPage::register();
	SignUpPage::register();
});

LogoutOperation::register();

Route::get("/", fn() => redirect(AppServiceProvider::getHomepage()));
