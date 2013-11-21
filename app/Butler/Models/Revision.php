<?php namespace Butler\Models;

class Revision extends Base
{
    protected $table = 'revisions';
    public $timestamps = true;

    public function user()
    {
        return $this->belongsTo('Butler\Models\User');
    }

    public function revisionable()
    {
        return $this->morphTo();
    }
}
