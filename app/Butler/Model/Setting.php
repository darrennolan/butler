<?php namespace Butler\Model;

class Setting extends Base
{
    protected $table   = 'settings';
    public $timestamps = true;

    public function revisions()
    {
        return $this->morphMany('Revision', 'revisionable');
    }

}
