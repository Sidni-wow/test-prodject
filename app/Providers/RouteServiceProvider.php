<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Route;

class RouteServiceProvider extends ServiceProvider
{
    /**
     * This namespace is applied to your controller routes.
     *
     * In addition, it is set as the URL generator's root namespace.
     *
     * @var string
     */
    protected $namespace = 'App\Http\Controllers';
    protected $namespaceAdmin = 'App\Http\Controllers\Admin';
    protected $namespaceClient = 'App\Http\Controllers\Client';

    /**
     * The path to the "home" route for your application.
     *
     * @var string
     */
    public const HOME = '/';

    /**
     * Define your route model bindings, pattern filters, etc.
     *
     * @return void
     */
    public function boot()
    {
        //

        parent::boot();
    }

    /**
     * Define the routes for the application.
     *
     * @return void
     */
    public function map()
    {
        $this->mapApiRoutes();

        $this->mapWebRoutes();

        $this->mapAdminRoutes();

        $this->mapClientRoutes();

        //
    }

    /**
     * Define the "web" routes for the application.
     *
     * These routes all receive session state, CSRF protection, etc.
     *
     * @return void
     */
    protected function mapWebRoutes()
    {
        Route::middleware('web')
            ->namespace($this->namespace)
            ->group(function () {
                require base_path('routes/web.php');
            });
    }

    /**
     * @return void
     */
    protected function mapClientRoutes()
    {
        Route::middleware('web')
            ->namespace($this->namespaceClient)
            ->name('client:')
            ->group(function () {
                require base_path('routes/client/main.php');
                require base_path('routes/client/films.php');
            });
    }

    /**
     * @return void
     */
    protected function mapApiRoutes()
    {
        Route::prefix('api')
            ->middleware('api')
            ->namespace($this->namespace)
            ->group(base_path('routes/api.php'));
    }

    /**
     * Define the "admin" routes for the application.
     *
     * These routes are typically stateless.
     *
     * @return void
     */
    protected function mapAdminRoutes()
    {
        Route::prefix('admin')
            ->middleware(['web', 'auth', 'can:admin'])
            ->namespace($this->namespaceAdmin)
            ->name('admin:')
            ->group(function () {
                require base_path('routes/admin/films.php');
                require base_path('routes/admin/main.php');
            });
    }
}
