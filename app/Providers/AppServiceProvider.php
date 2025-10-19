<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

use Illuminate\Support\Facades\View;
use App\Models\Notification;
use Illuminate\Support\Facades\Auth;


class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
         View::composer('*', function ($view) {
            // if (Auth::check()) {
                $unreadNotifications = Notification::where('user_id', Auth::id())
                    ->where('status', 'unread')
                    ->orderBy('created_at', 'desc')
                    ->limit(50)
                    ->get();
                    
                $view->with('unreadNotifications', $unreadNotifications);
           // }
        });
    }
}
