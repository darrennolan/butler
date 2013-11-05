<?php namespace Butler\Blog;

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
        if ($this->posts === null) {
            $current_date_time = new DateTime();

            $this->posts = Butler\Model\Post::where('visibility', '=', 'public')
                ->where('shown_at', '<=', $current_date_time)
                ->whereNull('shown_until')
                ->orWhere('shown_until', '>=', $current_date_time)
                ->take(10)
                ->get();
        }
    }

    public function getPageNumber()
    {
        return $this->page;
    }

    public function isPage()
    {
        return $this->is_page;
    }

    public function isPost()
    {
        return !$this->is_page;
    }
}
