<?php namespace Butler\Event;

class Paginate
{
    private $currentPage = 0;
    private static $per_page = 10;

    public function thePostsMakeCollection($query)
    {
        if ($query instanceof \Illuminate\Database\Eloquent\Builder) {
            return $query->paginate( static::getPerPage() );
        } else {
            return $query;
        }
    }

    public function getPerPage()
    {
        return static::$per_page;
    }

    public static function setPerPage($per_page)
    {
        static::$per_page = $per_page;
    }

    /**
     * Register the listeners for the subscriber.
     *
     * @param  Illuminate\Events\Dispatcher  $events
     * @return array
     */
    public function subscribe($events)
    {
        $events->listen('butler.flow.thePosts.makeCollection', 'Butler\Event\Paginate@thePostsMakeCollection', 5);
    }
}
