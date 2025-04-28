<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Route;

class RouteServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->routes(function () {
            // /api プレフィックス付きで api.php をグループ化
            Route::prefix('api')
                ->middleware('api')
                ->group(base_path('routes/api.php'));

            // /web プレフィックス付きで web.php をグループ化
            Route::middleware('web')
                ->group(base_path('routes/web.php'));
        });
    }
}
