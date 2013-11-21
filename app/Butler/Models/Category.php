<?php namespace Butler\Models;

class Category extends Base
{
    protected $table   = 'categories';
    public $timestamps = true;

    public function posts()
    {
        return $this->hasMany('Butler\Models\Post');
    }

    public function categories()
    {
        return $this->belongsToMany('Butler\Models\Category', 'parent_id');
    }

}
