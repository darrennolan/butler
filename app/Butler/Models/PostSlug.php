<?php namespace Butler\Models;

class PostSlug extends Base
{
    protected $table   = 'post_slugs';
    public $timestamps = true;

    public function post()
    {
        return $this->belongsTo('Butler\Models\Post');
    }

    public function revisions()
    {
        return $this->morphMany('Revision', 'revisionable');
    }

    public static function titleUrl($title)
    {
        /**
         * http://stackoverflow.com/questions/2234169/best-way-to-convert-title-into-url-compatible-mode-in-php
         */

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

    public function save(array $options = array())
    {
        if ( ! $this->exists && ! $this->post_url ) {
            $this->url = $this->post->show_at->format('Y/m/d') . '/' . self::titleUrl($this->post->title);
            unset($this->post);
        }

        return parent::save($options);
    }

}
