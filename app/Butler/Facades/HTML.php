<?php namespace Butler\Facades;

use Illuminate\Support\Facades\Facade;

class HTML extends Facade {

    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor() { return 'Butler\Theme\HTML'; }

}
