<?php namespace Butler\Events;

use Butler\Facades\Flow as ButlerFlow;

class Paginate
{
    private static $per_page = 10;

    public function thePostsMakeCollection($query)
    {
        if ($query instanceof \Illuminate\Database\Eloquent\Builder) {

            if ( ButlerFlow::currentRouteName() ) {
                return $query->paginate( static::$per_page )->route( ButlerFlow::currentRouteName() );
            } else {
                return $query->paginate( static::$per_page );
            }

        }

        return $query;
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
        $events->listenChain('butler.flow.thePosts.makeCollection', 'Butler\Events\Paginate@thePostsMakeCollection', 5);
    }
}
