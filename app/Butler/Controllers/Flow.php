<?php namespace Butler\Controllers;

use DateTime;
use Illuminate\Support\Collection;
use Butler\Models;
use Butler\Facades\Event;
use Butler\Facades\HTML;

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
            $this->posts = Event::fireChain('butler.flow.thePosts.makeBuilder', $this->posts);
            $this->posts = Event::fireChain('butler.flow.thePosts', $this->posts);
            $this->posts = Event::fireChain('butler.flow.thePosts.makeCollection', $this->posts);
        }

        if ( ! $this->is_page ) {
            Event::listenChain('butler.post.the_content', function($the_post) {
                if ($the_post->excerpt) {
                    return $the_post->excerpt;
                } else {
                    return $the_post->content;
                }
            }, 10);
        } else {
            Event::listenChain('butler.post.the_content', function($the_post) {
                return $the_post->content;
            });
        }

        return $this->posts;
    }

    public function trySlug($url)
    {
        // $this->posts = Event::chain('butler.flow.findslug', $this->posts);
        $post_slug = Models\PostSlug::whereUrl($url)->first();

        // Let this event continue on as 404 if we can't find a slug.
        if ( ! $post_slug ) return;

        $latest_post_slug = Models\PostSlug::wherePostId($post_slug->post_id)->orderBy('created_at', 'DESC')->first();

        if ($url != $latest_post_slug->url) {
            // Find the latest post slug to redirect to if it doesn't match our current URL.
            return Redirect::to( $latest_post_slug->url );
        } else {
            $this->posts = new Collection(array( $post_slug->post ));
            $this->isPage(true);
            return HTML::make();
        }

    }

    public function hasLinks()
    {
        $is_pagination = $this->posts instanceof \DeSmart\Pagination\Paginator || $this->posts instanceof \Illuminate\Pagination;

        return $is_pagination;
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
