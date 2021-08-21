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

    /**
     * The path to the "home" route for your application.
     *
     * @var string
     */
    public const HOME = '/knitter/dashboard';

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

        $this->mapConnectRoutes();

		$this->mapDesignerRoutes();

        $this->mapKnitterRoutes();
		
		$this->mapTestRoutes();
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
             ->group(base_path('routes/web.php'));
    }

    /**
     * Define the "api" routes for the application.
     *
     * These routes are typically stateless.
     *
     * @return void
     */
    protected function mapApiRoutes()
    {
        Route::prefix('api')
             ->middleware('api')
             ->namespace($this->namespace)
             ->group(base_path('routes/api.php'));
    }

	protected function mapAdminRoutes()
    {
        Route::namespace($this->namespace)
             ->group(base_path('routes/admin.php'));
    }

	protected function mapDesignerRoutes()
    {
        Route::namespace($this->namespace)
             ->group(base_path('routes/designer.php'));
    }

    protected function mapKnitterRoutes(){
        Route::namespace($this->namespace)
             ->group(base_path('routes/knitter.php'));
    }

    protected function mapConnectRoutes() {
        Route::namespace($this->namespace)
                               ->group(base_path('routes/connect.php'));
    }
	
	protected function mapTestRoutes() {
        Route::namespace($this->namespace)
                               ->group(base_path('routes/test.php'));
    }
}
