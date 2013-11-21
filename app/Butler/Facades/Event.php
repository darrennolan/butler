<?php namespace Butler\Facades;

use Illuminate\Support\Facades\Facade;

class Event extends Facade {

    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor() { return 'Butler\Events\Dispatcher'; }

}
