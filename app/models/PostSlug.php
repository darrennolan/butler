<?php

class PostSlug extends Eloquent
{
    protected $table   = 'post_slugs';
    public $timestamps = true;

    public function post ()
    {
        return $this->belongsTo('Post');
    }
}
