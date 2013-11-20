<?php namespace Butler\Models;

class Revision extends Base
{
    protected $table = 'revisions';
    public $timestamps = true;

    public function user()
    {
        return $this->belongsTo('Butler\Model\User');
    }

    public function revisionable()
    {
        return $this->morphTo();
    }
}
