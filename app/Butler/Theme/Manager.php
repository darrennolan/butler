<?php namespace Butler\Theme;

class Manager
{
    private $theme_name;

    private $themes_location = 'themes';

    private $theme_options;

    public function __construct($theme_name = 'default')
    {
        $this->theme_name = $theme_name;

        $this->registerThemeLocation();
    }

    public function registerThemeLocation()
    {
        \Config::set('view.paths', \Config::get('view.paths') + array(public_path() . '/' . $this->themes_location));
    }

    public function loadTheme($theme_name)
    {
        $this->theme_name = $theme_name;
    }

    public function getThemes()
    {
        return array(
            'default',
            'butler',
        );
    }

    public function viewLocationBase()
    {
        return 'themes.' . $this->theme_name;
    }

    public function viewDefault()
    {
        return $this->viewLocationBase() . '.' . 'index';
    }

    public function urlThemeBase()
    {
        return 'resources/' . $this->theme_name;
    }
}
