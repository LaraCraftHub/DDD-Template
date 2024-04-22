<?php

declare(strict_types=1);

namespace App\Application\Providers\System;

use Barryvdh\LaravelIdeHelper\IdeHelperServiceProvider;
use Carbon\CarbonImmutable;
use Illuminate\Support\Facades\Date;
use Illuminate\Support\ServiceProvider;
use Override;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    #[Override]
    public function register(): void
    {
        if (! $this->app->isLocal()) {
            return;
        }

        $this->app->register(IdeHelperServiceProvider::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        /**
         * Whenever you use now() helper or the Date facade in your code, you'll always get a CarbonImmutable instance.
         * Likewise, if you were to use the freshTimestamp() method on a model, or have any cast values,
         * these will always be returned as an instance of CarbonImmutable.
         * Be aware Carbon\Carbon or Illuminate\Support\Carbon will still return a mutable instance of carbon,
         * instead use Illuminate\Support\Facades\Date;
         */
        Date::use(CarbonImmutable::class);
    }
}
