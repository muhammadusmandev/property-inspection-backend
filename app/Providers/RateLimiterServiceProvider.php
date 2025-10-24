<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Http\Request;

class RateLimiterServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Login (email + IP)
        RateLimiter::for('login', function (Request $request) {
            return Limit::perHour(5)->by(
                'login|' . (string) strtolower($request->email) . ':' . $request->ip()
            );
        });

        // Register (email + IP)
        RateLimiter::for('register', function (Request $request) {
            return Limit::perDay(5)->by($request->ip());
        });

        // Request OTP (email + IP)
        RateLimiter::for('request-otp', function (Request $request) {
            $key = (string) strtolower($request->email).'|'.$request->ip();
            return Limit::perMinute(1)->by($key);
        });

        // OTP send (email + IP)
        RateLimiter::for('send-otp', function (Request $request) {
            $key = (string) strtolower($request->email).'|'.$request->ip();
            return Limit::perMinute(1)->by($key);
        });

        // OTP verify (email + IP)
        RateLimiter::for('verify-otp', function (Request $request) {
            $key = (string) strtolower($request->email).'|'.$request->ip();
            return Limit::perHour(5)->by($key);
        });

        // Reset Password (email + IP)
        RateLimiter::for('reset-password', function (Request $request) {
            $key = (string) strtolower($request->email).'|'.$request->ip();
            return Limit::perDay(2)->by($key);
        });
    }
}