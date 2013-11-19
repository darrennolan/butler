<?php namespace Butler\Theme;

class HTML
{
    private $theme_manager;

    public function __construct(\Butler\Theme\Manager $theme_manager)
    {
        $this->theme_manager = $theme_manager;
    }

    public function pageClasses()
    {
        return 'home to-do';
    }

    public function siteName()
    {
        return 'Butler';
    }

    public function siteHome()
    {
        return \URL::to('/');
    }

    public function __call($name, $arguments)
    {
        return call_user_func_array(array($this->theme_manager, $name), $arguments);
    }
}
