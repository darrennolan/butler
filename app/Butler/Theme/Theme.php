<?php namespace Butler\Theme;

class Theme
{
    public function getThemeName()
    {
        return 'default';
    }

    public function themeLocation()
    {
        return 'themes.default';
    }

    public function themeView()
    {
        return $this->themeLocation() . '.' . 'index';
    }

    public function themeURL()
    {
        return 'theme/default';
    }

}
