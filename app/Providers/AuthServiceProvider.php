<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * Ánh xạ các model với policy tương ứng trong ứng dụng.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        //
    ];

    /**
     * Đăng ký các dịch vụ xác thực và phân quyền.
     */
    public function boot(): void
    {
        $this->registerPolicies();

        //
    }
}