<?php namespace Butler\Models;

class Comment extends Base
{
    protected $table   = 'comments';
    public $timestamps = true;

    public function post()
    {
        return $this->belongsTo('Butler\Models\Post');
    }

    public function comments()
    {
        return $this->belongsToMany('Butler\Models\Comment', 'parent_id');
    }
}
