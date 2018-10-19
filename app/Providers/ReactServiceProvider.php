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
            return "<?php echo \App\Facades\React::build($expression) ?>";
        });
    }

    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        app()->singleton('React', function (){
            return new \App\Helpers\React();
        });
    }
}
