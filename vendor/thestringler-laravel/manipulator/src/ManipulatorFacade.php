<?php namespace TheStringlerLaravel\Manipulator;

use Illuminate\Support\Facades\Facade;

class ManipulatorFacade extends Facade {

    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor() { return 'manipulator'; }
}