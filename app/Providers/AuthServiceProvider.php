<?php

namespace App\Providers;

use Laravel\Passport\Passport;
use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        // 'App\Models\Model' => 'App\Policies\ModelPolicy',
        'App\Models\User' => 'App\Policies\UserPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        // 當調用 auth()->user()->can()的時候會進入該hook
        Gate::before(function ($user, $ability) {
            return $user->hasRole('ActivityAdmin') ? true : null;
        });

        if (! $this->app->routesAreCached()) {
            Passport::routes();
        }

         // access_token 設定核發後1天後過期
        Passport::tokensExpireIn(now()->addDays(1));

        // refresh_token 設定核發後1天後過期
        Passport::refreshTokensExpireIn(now()->addDays(1));
    }
}
