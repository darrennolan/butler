<?php namespace Butler\Model;

use Illuminate\Database\Eloquent\Model as Eloquent;
use Illuminate\Support\Facades\Validator;

abstract class Base extends Eloquent
{
    protected static $rules = array();

    public $valid;
    public static $validator;

    public function validate()
    {
        $v = Validator::make($this->attributes, static::$rules);

        if ($v->passes()) {
            return true;
        }

        $this->validator = $v;
        return false;
    }

    static public function validator(array $input = array(), array $use_rules = array())
    {
        if (count($input) && count($use_rules)) {
            // Use given input, and only on selected rules
            $v = Validator::make($input, array_only(static::$rules, $use_rules));

        } elseif (count($input)) {
            // Use given input on all rules
            $v = Validator::make($input, static::$rules);

        } else {
            return false; // We have no input to validate. Assume failed.
        }

        if ($v->passes()) {
            return true;
        }

        static::$validator = $v;
        return false;
    }
}
