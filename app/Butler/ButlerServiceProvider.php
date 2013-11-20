<?php namespace Butler;

use Illuminate\Foundation\AliasLoader;

class ButlerServiceProvider extends \Illuminate\Support\ServiceProvider {

    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var bool
     */
    protected $defer = false;

    /**
     * Bootstrap the application events.
     *
     * @return void
     */
    public function boot()
    {
        Facades\Event::subscribe( new Events\Post );
        Facades\Event::subscribe( new Events\Paginate );
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        AliasLoader::getInstance()->alias('ButlerEvent', 'Butler\Facades\Event');
        AliasLoader::getInstance()->alias('ButlerFlow', 'Butler\Facades\Flow');
        AliasLoader::getInstance()->alias('ButlerTheme', 'Butler\Facades\Theme');
        AliasLoader::getInstance()->alias('ButlerHTML', 'Butler\Facades\HTML');
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
            return array();
    }

}
