<?php namespace Butler\Model;

use Illuminate\Database\Eloquent\Model as Eloquent;

class PostSlug extends Eloquent
{
    protected $table   = 'post_slugs';
    public $timestamps = true;

    public function post ()
    {
        return $this->belongsTo('Butler\Model\Post');
    }
}
