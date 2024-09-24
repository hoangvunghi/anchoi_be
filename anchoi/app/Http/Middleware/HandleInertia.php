<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Config;
use Inertia\Middleware;
use Laravel\Nova\Http\Resources\UserResource;
use Laravel\Nova\Http\Middleware\HandleInertiaRequests;
use Laravel\Nova\Nova;

class HandleInertia extends HandleInertiaRequests
{
    
    public function share(Request $request)
    {
        return array_merge(parent::share($request), [
           
            'validLicense' => function () use ($request) {
                return True;
            },
        ]);
    }


}
