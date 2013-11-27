<?php namespace Butler\Controllers;

use DateTime;
use Butler\Model;
use Butler\Facades\Event;

class Flow
{
    private $posts = null;

    private $is_page = false;

    private $is_homepage = false;

    /**
     * Works out what the home page is.
     * @return [type] [description]
     */
    public function homeRoute()
    {
       return '/';
    }

    public function currentRouteName()
    {
        return \Route::currentRouteName();
    }

    /**
     * Returns a collection of posts.
     * @return [type] [description]
     */
    public function thePosts($reset = null)
    {
        if ($this->posts === null || $reset == true) {
            $this->posts = Event::chain('butler.flow.thePosts.makeBuilder', $this->posts);
            $this->posts = Event::chain('butler.flow.thePosts', $this->posts);
            $this->posts = Event::chain('butler.flow.thePosts.makeCollection', $this->posts);
        }

        if ( ! $this->is_page ) {
            Event::listen('butler.post.the_content', function($the_post) {
                if ($the_post->excerpt) {
                    return $the_post->excerpt;
                } else {
                    return $the_post->content;
                }
            }, 10);
        } else {
            Event::listen('butler.post.the_content', function($the_post) {
                return $the_post->content;
            });
        }

        return $this->posts;
    }

    public function isHomepage($is_homepage = null)
    {
        if ($is_homepage !== null) {

            $this->is_homepage = $is_homepage ? true : false;

        } else {

            return $this->is_homepage;

        }
    }

    public function isPage($is_page = null)
    {
        if ($is_page !== null) {

            $this->is_page = $is_page ? true : false;

        } else {

            return $this->is_page;

        }
    }

}
