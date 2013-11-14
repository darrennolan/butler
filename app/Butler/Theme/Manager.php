<?php namespace Butler\Theme;

use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\File;

class Manager
{
    private $theme_name;

    private $themes_location = 'themes';

    private $theme_settings = array(
        'default_page' => 'index'
    );

    public function __construct($theme_name = 'default')
    {
        $this->registerThemeLocation();

        $this->loadTheme($theme_name);
    }

    public function registerThemeLocation()
    {
        View::addLocation(public_path() . '/' . $this->themes_location);
    }

    public function loadTheme($theme_name)
    {
        $this->theme_name = $theme_name;

        $functions_file_path = public_path() . '/' . $this->themes_location . '/' . $this->theme_name . '/functions.php';

        if (File::exists($functions_file_path)) {
            require_once($functions_file_path);
        }
    }

    public function getThemes()
    {
        return array(
            'default',
            'butler',
        );
    }

    public function setSettings($theme_settings = array())
    {
        $this->theme_settings = array_merge($this->theme_settings, $theme_settings);
    }

    public function make($view = false, $data = array(), $mergeData = array())
    {
        if (!$view) {
            $view = $this->theme_settings['default_page'];
        }
        return View::make($this->theme_name . '.' . $view, $data, $mergeData);
    }
}
