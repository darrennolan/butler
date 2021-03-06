<?php namespace Butler\Models;

class PostSlug extends Base
{
    protected $table   = 'post_slugs';
    public $timestamps = true;

    public function post()
    {
        return $this->belongsTo('Butler\Models\Post');
    }

    public function revisions()
    {
        return $this->morphMany('Revision', 'revisionable');
    }

}
