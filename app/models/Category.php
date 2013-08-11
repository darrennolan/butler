<?php

class Category extends Eloquent
{
    protected $table   = 'categories';
    public $timestamps = true;

    public function post()
    {
        return $this->hasMany('Post');
    }

    public function categories()
    {
        return $this->belongsToMany('Category', 'parent_id');
    }
}
