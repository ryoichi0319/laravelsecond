<?php

namespace App\Providers;

use Illuminate\Support\Facades\Gate;
use App\Models\User;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        \App\Models\Post::class => \App\Policies\PostPolicy::class,
        \App\Models\Item::class => \App\Policies\ItemPolicy::class,
        \App\Models\Order::class => \App\Policies\ItemPolicy::class,


    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        Gate::define('test', function (User $user){
            if($user->role === 'admin'){
                return true;
            }
            return false;
        });
        //
    }
}
