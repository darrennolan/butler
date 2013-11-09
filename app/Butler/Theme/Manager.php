<?php namespace Butler\Theme;

class Manager
{
    private $theme;

    public function __construct()
    {
        $this->theme = new \Butler\Theme\Theme('default');
    }

    public function loadTheme(\Butler\Theme\Theme $theme)
    {
        $this->theme = $theme;
    }

    public function getThemes()
    {
        return array(
            'default',
            'butler',
        );
    }

    public function __call($name, $arguments)
    {
        if (method_exists($this->theme, $name)) {

            return call_user_func_array(array($this->theme, $name), $arguments);

        } else {

            throw new \Exception('Method ' . $name . ' not found in Butler\Theme\Manager or ' . get_class($this->theme));

        }
    }
}
