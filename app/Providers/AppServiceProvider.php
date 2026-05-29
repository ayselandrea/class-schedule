<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\URL;

class AppServiceProvider extends ServiceProvider
{
    public function register()
    {
        //
    }

    public function boot()
    {
        if ($this->app->runningInConsole()) {
            return;
        }

        // Force HTTPS when behind Railway's proxy
        if ($this->app['request']->isSecure() || $this->app['request']->server('HTTP_X_FORWARDED_PROTO') === 'https') {
            URL::forceScheme('https');
        }

        // Use the request's scheme + host for all generated URLs
        // This fixes route() and asset() regardless of APP_URL
        URL::forceRootUrl($this->app['request']->getSchemeAndHttpHost());
    }
}
