<?php namespace Butler\Events;

use DateTime;
use Butler\Models;

class Post
{
    public function thePostsBuilder($builder)
    {
        if ( ! $builder) {
            $builder = Models\Post::query();
        }

        return $builder;
    }

    public function thePosts($query)
    {

        if ($query instanceof \Illuminate\Database\Eloquent\Builder) {
            $current_date_time = new DateTime();

            $query->where('visibility', '=', 'public')
                ->where('show_at', '<=', $current_date_time)
                ->whereNull('show_until')
                ->orWhere('show_until', '>=', $current_date_time)
                ->orderBy('show_at', 'DESC');
        }

        return $query;
    }

    /**
     * Register the listeners for the subscriber.
     *
     * @param  Illuminate\Events\Dispatcher  $events
     * @return array
     */
    public function subscribe($events)
    {
        $events->listen('butler.flow.thePosts.makeBuilder', 'Butler\Events\Post@thePostsBuilder', 5);
        $events->listen('butler.flow.thePosts', 'Butler\Events\Post@thePosts', 5);
    }
}
