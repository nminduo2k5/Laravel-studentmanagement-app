<?php

namespace App\Providers;

use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\Route;

class RouteServiceProvider extends ServiceProvider
{
    /**
     * Đường dẫn đến trang "home" của ứng dụng.
     * Người dùng thường được chuyển hướng đến đây sau khi xác thực.
     */
    public const HOME = '/';

    /**
     * Định nghĩa các cấu hình route cho ứng dụng.
     */
    public function boot(): void
    {
        // Cấu hình giới hạn tốc độ cho API
        RateLimiter::for('api', function (Request $request) {
            return Limit::perMinute(60)->by($request->user()?->id ?: $request->ip());
        });

        // Đăng ký các nhóm route
        $this->routes(function () {
            // Route cho API
            Route::middleware('api')
                ->prefix('api')
                ->group(base_path('routes/api.php'));

            // Route cho web
            Route::middleware('web')
                ->group(base_path('routes/web.php'));
        });
    }
}