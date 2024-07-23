<?php

namespace App\Http\Middleware;

use Illuminate\Http\Request;
use Inertia\Middleware;
use Tighten\Ziggy\Ziggy;

class HandleInertiaRequests extends Middleware
{
    /** @var string */
    protected $rootView = "app";


    public function version(Request $request): string|null
    {
        return parent::version($request);
    }

    /** @return array<string, mixed> */
    public function share(Request $request): array
    {
        return [
            ...parent::share($request),
            "auth" => [
                "user" => $request->user(),
            ],
            "ziggy" => fn() => [
                ...(new Ziggy())->toArray(),
                "location" => $request->url(),
            ],
        ];
    }
}
