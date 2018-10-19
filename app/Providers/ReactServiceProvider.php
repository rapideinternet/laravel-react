<?php

namespace App\Providers;

use App\Facades\React;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;

class ReactServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap services.
     *
     * @return void
     */

    public function boot()
    {
        Blade::directive('reactComponent', function ($expression) {
            return "<?php echo React::build($expression) ?>";
        });
    }

    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        app()->bind('React', function (){
            return new React();
        });
    }
}
