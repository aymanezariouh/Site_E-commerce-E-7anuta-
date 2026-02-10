<?php

namespace App\Providers;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

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
        View::composer('components.admin.navbar', function ($view) {
            $user = Auth::user();
            $notificationCount = 0;
            $adminNotifications = collect();

            if ($user instanceof User && $user->hasRole('admin')) {
                $notificationCount = $user->unreadNotifications()->count();
                $adminNotifications = $user->notifications()
                    ->latest()
                    ->take(5)
                    ->get();
            }

            $view->with(compact('notificationCount', 'adminNotifications'));
        });
    }
}
