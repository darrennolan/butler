<?php namespace Butler\Controller;

use DateTime;
use Butler\Model;
use Illuminate\Support\Facades\Event;

class Flow
{
    private $posts = null;

    private $is_page = false;

    private $page = 0;

    /**
     * Works out what the home page is.
     * @return [type] [description]
     */
    public function homeDirective()
    {
        return $this->thePosts();
    }

    /**
     * Returns a collection of posts.
     * @return [type] [description]
     */
    public function thePosts()
    {
        $this->posts = Event::fire('butler.flow.thePosts.makeBuilder', $this->posts);
        $this->posts = Event::fire('butler.flow.thePosts', $this->posts);
        $this->posts = Event::fire('butler.flow.thePosts.makeCollection', $this->posts);

        return $this->posts;
    }

    public function getPageNumber()
    {
        $this->page = Event::fire('butler.flow.getPageNumber', $this->page);

        return $this->page;
    }

    public function isPage()
    {
        $this->is_page = Event::fire('butler.flow.getPageNumber', $this->is_page);

        return $this->is_page;
    }

    public function isPost()
    {
        $this->is_page = Event::fire('butler.flow.getPageNumber', $this->is_page);

        return ! $this->is_page;
    }
}
