<?php namespace Butler\Model;

class Category extends Base
{
    protected $table   = 'categories';
    public $timestamps = true;

    public function post()
    {
        return $this->hasMany('Butler\Model\Post');
    }

    public function categories()
    {
        return $this->belongsToMany('Butler\Model\Category', 'parent_id');
    }
}
