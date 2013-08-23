<?php namespace Butler\Model;

class Comment extends Base
{
    protected $table   = 'comments';
    public $timestamps = true;

    public function post()
    {
        return $this->belongsTo('Butler\Model\Post');
    }

    public function comments()
    {
        return $this->belongsToMany('Butler\Model\Comment', 'parent_id');
    }

}
