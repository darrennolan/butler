<?php

class Comment extends Eloquent
{
    protected $table   = 'comments';
    public $timestamps = true;

    public function post()
    {
        return $this->belongsTo('Post');
    }

    public function comments()
    {
        return $this->belongsToMany('Comment', 'parent_id');
    }

}
