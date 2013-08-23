<?php namespace Butler\Model;

use Illuminate\Database\Eloquent\Model as Eloquent;
use Illuminate\Support\Facades\Validator;

abstract class Base extends Eloquent
{
    protected static $rules = array();

    public $validation_errors;

    public function validate()
    {
        $v = Validator::make($this->attributes, static::$rules);

        if ($v->passes()) {
            return true;
        }

        $this->validation_errors = $v->messages();
        return false;
    }
}
