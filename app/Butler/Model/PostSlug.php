<?php namespace Butler\Model;

class PostSlug extends Base
{
    protected $table   = 'post_slugs';
    public $timestamps = true;

    public function post ()
    {
        return $this->belongsTo('Butler\Model\Post');
    }
}
