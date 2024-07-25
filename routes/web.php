<?php

use App\Domains\Framework\Authentication\Operations\LogoutOperation;
use App\Domains\Framework\Authentication\Pages\SignInPage;
use App\Domains\Framework\Authentication\Pages\SignUpPage;
use App\Providers\AppServiceProvider;
use Illuminate\Support\Facades\Route;

Route::middleware(["guest"])->group(function () {
	SignInPage::register();
	SignUpPage::register();
});

LogoutOperation::register();

Route::get("/", fn() => redirect(AppServiceProvider::getHomepage()));
