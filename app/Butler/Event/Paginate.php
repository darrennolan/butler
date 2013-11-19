<?php namespace Butler\Event;

class Paginate
{
    private static $current_page = 1;
    private static $per_page = 10;

    public function thePostsMakeCollection($query)
    {
        if ($query instanceof \Illuminate\Database\Eloquent\Builder) {
            return $query->paginate( static::$per_page );
        } else {
            return $query;
        }
    }

    public static function setPerPage($per_page)
    {
        static::$per_page = $per_page;
    }

    public static function setPage($current_page)
    {
        static::$current_page = $current_page;
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
