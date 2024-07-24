<?php

declare(strict_types=1);

use App\Domains\Core\Middlewares\HandleInertiaRequestsMiddleware;
use App\Domains\Workflow\Pages\WorkflowsPage\WorkflowsPage;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use Stancl\Tenancy\Middleware\InitializeTenancyByPath;

Route::group(
    [
        "prefix" => "/{tenant}",
        "middleware" => [HandleInertiaRequestsMiddleware::class, InitializeTenancyByPath::class],
    ],
    function () {
        WorkflowsPage::register();

        Route::middleware("auth")->group(function () {
            Route::get("/profile", [ProfileController::class, "edit"])->name(
                "profile.edit"
            );
            Route::patch("/profile", [
                ProfileController::class,
                "update",
            ])->name("profile.update");
            Route::delete("/profile", [
                ProfileController::class,
                "destroy",
            ])->name("profile.destroy");
        });
    }
);
