<?php namespace Butler\Events;

class Dispatcher extends \Illuminate\Events\Dispatcher
{
    /**
     * The registered event listenerChains.
     *
     * @var array
     */
    protected $listener_chains = array();

    /**
     * The wildcard listenerChains.
     *
     * @var array
     */
    protected $wildcard_chains = array();

    /**
     * The sortedChains event listenerChains.
     *
     * @var array
     */
    protected $sorted_chains = array();

    /**
     * Register an event listener with the dispatcher.
     *
     * @param  string  $event
     * @param  mixed   $listener
     * @param  int     $priority
     * @return void
     */
    public function listenChain($event, $listener_chain, $priority = 0)
    {
        if (str_contains($event, '*'))
        {
            return $this->setupWildcardListen($event, $listener_chain);
        }

        $this->listener_chains[$event][$priority][] = $this->makeListener($listener_chain);

        unset($this->sorted_chains[$event]);
    }

    /**
     * Setup a wildcard listener callback.
     *
     * @param  string  $event
     * @param  mixed   $listener
     * @return void
     */
    protected function setupWildcardListenChain($event, $listener_chain)
    {
        $this->wildcard_chains[$event][] = $this->makeListenerChain($listener_chain);
    }

    /**
     * Determine if a given event has listenerChains.
     *
     * @param  string  $eventName
     * @return bool
     */
    public function hasListenerChains($eventName)
    {
        return isset($this->listener_chains[$eventName]);
    }

    /**
     * Register a queued event and payload.
     *
     * @param  string  $event
     * @param  array   $payload
     * @return void
     */
    public function queueChain($event, $payload = array())
    {
        $me = $this;

        $this->listenChain($event.'_queue', function() use ($me, $event, $payload)
        {
            $me->fireChain($event, $payload);
        });
    }

    /**
     * Flush a set of queued events.
     *
     * @param  string  $event
     * @return void
     */
    public function flushChain($event)
    {
        $this->fireChain($event.'_queue');
    }

    /**
     * Fire an event and call the listenerChains.
     *
     * @param  string  $event
     * @param  mixed   $payload
     * @param  bool    $halt
     * @return array|null
     */
    public function fireChain($event, $object, $payload = array())
    {
        // If an array is not given to us as the payload, we will turn it into one so
        // we can easily use call_user_func_array on the listenerChains, passing in the
        // payload to each of them so that they receive each of these arguments.
        if ( ! is_array($payload)) $payload = array($payload);

        foreach ($this->getListenerChains($event) as $listener_chain)
        {
            $object  = call_user_func_array($listener_chain, array($object) + $payload);
        }

        return $object;
    }

    /**
     * Get all of the listenerChains for a given event name.
     *
     * @param  string  $eventName
     * @return array
     */
    public function getListenerChains($eventName)
    {
        $wildcard_chains = $this->getWildcardListenerChains($eventName);

        if ( ! isset($this->sorted_chains[$eventName]))
        {
            $this->sortListenerChains($eventName);
        }

        return array_merge($this->sorted_chains[$eventName], $wildcard_chains);
    }

    /**
     * Get the wildcard listenerChains for the event.
     *
     * @param  string  $eventName
     * @return array
     */
    protected function getWildcardListenerChains($eventName)
    {
        $wildcard_chains = array();

        foreach ($this->wildcard_chains as $key => $listener_chains)
        {
            if (str_is($key, $eventName)) $wildcard_chains = array_merge($wildcard_chains, $listener_chains);
        }

        return $wildcard_chains;
    }

    /**
     * Sort the listenerChains for a given event by priority.
     *
     * @param  string  $eventName
     * @return array
     */
    protected function sortListenerChains($eventName)
    {
        $this->sorted_chains[$eventName] = array();

        // If listenerChains exist for the given event, we will sort them by the priority
        // so that we can call them in the correct order. We will cache off these
        // sortedChains event listenerChains so we do not have to re-sort on every events.
        if (isset($this->listener_chains[$eventName]))
        {
            krsort($this->listener_chains[$eventName]);

            $this->sorted_chains[$eventName] = call_user_func_array('array_merge', $this->listener_chains[$eventName]);
        }
    }

    /**
     * Register an event listener with the dispatcher.
     *
     * @param  mixed   $listener
     * @return mixed
     */
    public function makeListenerChain($listener_chain)
    {
        if (is_string($listener_chain))
        {
            $listener = $this->createClassListenerChain($listener_chain);
        }

        return $listener;
    }

    /**
     * Create a class based listener using the IoC container.
     *
     * @param  mixed    $listener
     * @return \Closure
     */
    public function createClassListenerChain($listener_chain)
    {
        $container = $this->container;

        return function() use ($listener, $container)
        {
            // If the listener has an @ sign, we will assume it is being used to delimit
            // the class name from the handle method name. This allows for handlers
            // to run multiple handler methods in a single class for convenience.
            $segments = explode('@', $listener_chain);

            $method = count($segments) == 2 ? $segments[1] : 'handle';

            $callable = array($container->make($segments[0]), $method);

            // We will make a callable of the listener instance and a method that should
            // be called on that instance, then we will pass in the arguments that we
            // received in this method into this listener class instance's methods.
            $data = func_get_args();

            return call_user_func_array($callable, $data);
        };
    }

    /**
     * Remove a set of listenerChains from the dispatcher.
     *
     * @param  string  $event
     * @return void
     */
    public function forgetChain($event)
    {
        unset($this->listener_chains[$event]);

        unset($this->sorted_chains[$event]);
    }
}
