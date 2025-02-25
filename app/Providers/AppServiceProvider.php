<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Repositories\ClientRepositoryInterface;
use App\Repositories\ClientRepository;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        
        $this->app->bind(ClientRepositoryInterface::class, ClientRepository::class);
       
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Gate::define('loans', function (User $user) {
            
            return $user->id === Auth::user()->id;
        });
    }
}
