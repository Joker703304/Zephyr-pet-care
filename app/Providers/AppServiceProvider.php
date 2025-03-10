<?php

namespace App\Providers;

use Illuminate\Support\Facades\Gate;
use App\Models\User;
use Illuminate\Support\ServiceProvider;
use App\Http\Middleware\RoleMiddleware;
use Illuminate\Support\Facades\Route;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Support\Facades\RateLimiter;

use function PHPUnit\Framework\callback;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Registrasikan middleware
        Route::aliasMiddleware('role', RoleMiddleware::class);

        Gate::define('admin', function (User $user): bool {
            return $user->role === 'admin';
        });

        Gate::define('dokter', function (User $user): bool {
            return $user->role === 'dokter';
        });

        Gate::define('apoteker', function (User $user): bool {
            return $user->role === 'apoteker';
        });

        Gate::define('pemilik_hewan', function (User $user): bool {
            return $user->role === 'pemilik_hewan';
        });

        Gate::define('kasir', function (User $user): bool {
            return $user->role === 'kasir';
        });
        
        Gate::define('security', function (User $user): bool {
            return $user->role === 'security';
        });

        $this->configureRateLimiting(); // <---- Tambahkan baris ini
    }

    protected function configureRateLimiting()
    {
        RateLimiter::for('api', function ($request) {
            return Limit::perMinute(60)->by(optional($request->user())->id ?: $request->ip());
        });

        // Tambahkan rate limiter untuk 'send-otp'
        RateLimiter::for('send-otp', function ($request) {
            return Limit::perMinute(5)->by($request->ip()); // Batasi 5 request per menit per IP
        });
    }

}
