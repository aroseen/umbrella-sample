<?php

namespace App\Providers;

use App\Components\Api;
use App\Components\EventsLogger;
use App\Components\Table;
use App\Http\Composers\TablesViewComposer;
use App\Models\Url;
use App\Models\User;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Route;
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

        Route::bind('shortUrl', function (string $value) {
            /** @var User $user */
            $user = auth()->user();
            $url  = Url::query()->where('short_url', route('home.redirector', [
                'shortUrl' => $value,
            ]))->first();

            return $user->can('redirect', $url) ? $url : abort(404);
        });

        Event::listen('log:event:*', function ($eventName, array $data) {
            $eventName = str_replace('log:event:', null, $eventName);
            /** @var EventsLogger $eventsLogger */
            $eventsLogger = $this->app[EventsLogger::class];

            if (method_exists($eventsLogger, $eventName)) {
                $eventsLogger->{$eventName}(...array_values($data));
            }
        });

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

        $this->app->singleton(EventsLogger::class);
    }
}
