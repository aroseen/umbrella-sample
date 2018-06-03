<?php

namespace App\Providers;

use App\Components\Api;
use App\Components\Table;
use App\Http\Composers\HomeViewComposer;
use App\Http\Composers\TablesViewComposer;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

/**
 * Class AppServiceProvider.
 *
 * @package App\Providers
 */
class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot(): void
    {
        View::composer('elements.table', TablesViewComposer::class);
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register(): void
    {
        $this->app->bind(Api::class, function (Application $app) {
            return new Api(config('api.api_url'));
        });

        $this->app->bind(Table::class, function (Application $app) {
            return new Table(auth()->user());
        });
    }
}
