<?php namespace Butler\Model;

class Revision extends Base
{
    protected $table = 'revisions';
    public $timestamps = true;

    public function user()
    {
        return $this->belongsTo('Butler\Model\User');
    }
}
