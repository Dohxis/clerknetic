<?php

use App\Domains\Framework\Authentication\Operations\LogoutOperation;
use App\Domains\Framework\Authentication\Pages\SignInPage;
use App\Providers\AppServiceProvider;
use Illuminate\Support\Facades\Route;

Route::middleware(["guest"])->group(function () {
	SignInPage::register();
});

LogoutOperation::register();

Route::get("/", fn() => redirect(AppServiceProvider::getHomepage()));
