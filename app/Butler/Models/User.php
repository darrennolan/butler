<?php namespace Butler\Models;

use Illuminate\Auth\UserInterface;
use Illuminate\Auth\Reminders\RemindableInterface;

use Illuminate\Support\Facades\Hash;

class User extends Base implements UserInterface, RemindableInterface
{
    protected $table = 'users';
    protected $hidden = array('password');

    protected static $rules = array(
        'email'        => 'required|email|unique:users',
        'password'     => 'required|min:5',
        'first_name'   => 'min:1|max:255',
        'last_name'    => 'min:1|max:255',
        'display_name' => 'min:1|max:255',
        'url'          => 'url',
        'status'       => 'in:active,pending,trash,disabled',
    );

    public function posts()
    {
        return $this->hasMany('Butler\Model\Post');
    }

    public function setPasswordAttribute($password)
    {
        $this->attributes['password'] = Hash::make($password);
    }

    /**
     * Get the unique identifier for the user.
     *
     * @return mixed
     */
    public function getAuthIdentifier()
    {
        return $this->getKey();
    }

    /**
     * Get the password for the user.
     *
     * @return string
     */
    public function getAuthPassword()
    {
        return $this->password;
    }

    /**
     * Get the e-mail address where password reminders are sent.
     *
     * @return string
     */
    public function getReminderEmail()
    {
        return $this->email;
    }



}
