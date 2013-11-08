<?php namespace Butler\Controller;

use DateTime;
use Butler\Model;
use Illuminate\Support\Facades\Event;

class Flow
{
    private $posts = null;

    private $is_page = false;

    private $page;

    /**
     * Works out what the home page is.
     * @return [type] [description]
     */
    public function homeDirective()
    {
        //return $this->thePosts();
    }

    /**
     * Returns a collection of posts.
     * @return [type] [description]
     */
    public function thePosts(Boolean $reset = null)
    {
        if ($this->posts === null || $reset == true) {
            $this->posts = Event::until('butler.flow.thePosts.makeBuilder', $this->posts);
            $this->posts = Event::until('butler.flow.thePosts', $this->posts);
            $this->posts = Event::until('butler.flow.thePosts.makeCollection', $this->posts);
        }

        return $this->posts;
    }

    public function getPage()
    {
        $this->page = Event::until('butler.flow.getPage', $this->page);

        return $this->page;
    }
}
