<?php namespace Butler\Theme;

class HTML
{
    private $theme_manager;

    public function __construct(\Butler\Theme\Manager $theme_manager)
    {
        $this->theme_manager = $theme_manager;
    }

    public function sitename()
    {
        return 'Butler';
    }

    public function homepage()
    {
        return 'homepage';
    }

    public function butlerhome()
    {
        return 'butlerhome';
    }

    public function __call($name, $arguments)
    {
        return call_user_func_array(array($this->theme_manager, $name), $arguments);
    }
}
