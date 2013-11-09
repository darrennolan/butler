<?php namespace Butler\ServiceProvider;

use Butler\Event as ButlerEvent;
use Illuminate\Foundation\AliasLoader;
use Illuminate\Support\Facades\Event;

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
        Event::subscribe( new ButlerEvent\Post );
        Event::subscribe( new ButlerEvent\Paginate );
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        AliasLoader::getInstance()->alias('ButlerFlow', 'Butler\Facades\Flow');
        AliasLoader::getInstance()->alias('ButlerHTML', 'Butler\Facades\HTML');
        /*
        $this->app['butler'] = $this->app->share(function($app)
        {
            return new something;
        });
        */
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
