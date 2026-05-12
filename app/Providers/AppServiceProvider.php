<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Gate;
use App\Models\pinjaman;
use App\Models\tabungan;
use App\Models\simpanan;
use App\Policies\PinjamanPolicy;
use App\Policies\TabunganPolicy;
use App\Policies\SimpananPolicy;

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
        Gate::policy(pinjaman::class, PinjamanPolicy::class);
        Gate::policy(tabungan::class, TabunganPolicy::class);
        Gate::policy(simpanan::class, SimpananPolicy::class);
    }
}
