<?php namespace Butler\Models;

class Post extends Base
{
    protected $table   = 'posts';
    public $timestamps = true;

    public function user()
    {
        return $this->belongsTo('Butler\Models\User');
    }

    public function comments()
    {
        return $this->hasMany('Butler\Models\Comment');
    }

    public function revisions()
    {
        return $this->morphMany('Butler\Models\Revision', 'revisionable');
    }

    public function category()
    {
        return $this->belongsToMany('Butler\Models\Category', 'category_post')->withTimestamps();
    }

    public function anchorUrl()
    {
        return date("Y/m/d", strtotime($this->post_at)) . '/' . $this->titleUrl();
    }

    public function titleUrl()
    {
        /**
         * http://stackoverflow.com/questions/2234169/best-way-to-convert-title-into-url-compatible-mode-in-php
         */
        $title = $this->title;

        # Prep string with some basic normalization
        $title = strtolower($title);
        $title = strip_tags($title);
        $title = stripslashes($title);
        $title = html_entity_decode($title);

        # Remove quotes (can't, etc.)
        $title = str_replace('\'', '', $title);

        # Replace non-alpha numeric with hyphens
        $match = '/[^a-z0-9]+/';
        $replace = '-';
        $title = preg_replace($match, $replace, $title);

        return trim($title, '-');
    }

}
