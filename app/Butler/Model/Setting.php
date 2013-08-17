<?php namespace Butler\Model;

use Illuminate\Database\Eloquent\Model as Eloquent;

class Setting extends Eloquent
{
    protected $table   = 'settings';
    public $timestamps = true;
}
