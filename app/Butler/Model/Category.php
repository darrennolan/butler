<?php namespace Butler\Model;

use Illuminate\Database\Eloquent\Model as Eloquent;

class Category extends Eloquent
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
