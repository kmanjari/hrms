<?php namespace TheStringlerLaravel\Manipulator;

use Illuminate\Support\ServiceProvider;
use TheStringler\Manipulator\Manipulator;

class ManipulatorServiceProvider extends ServiceProvider
{
    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind('manipulator', function ($app, $string) {
            return new Manipulator($string);
        });
    }
}
