<?php namespace Butler\Model;

use Illuminate\Database\Eloquent\Model as Eloquent;

class Comment extends Eloquent
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
