<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

require __DIR__ . "/auth.php";

Route::get("/", function () {
    if (Auth::check()) {
        return redirect("/acme/dashboard");
    }

    return redirect("/sign-in");
});
