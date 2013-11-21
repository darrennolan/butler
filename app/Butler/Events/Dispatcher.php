<?php namespace Butler\Events;



class Dispatcher extends \Illuminate\Events\Dispatcher
{
    /**
     * Fire an event and call the listeners, chaining the responses.
     *  Instead of returning an array of response, we're going to keep passing on the responses
     *
     * @param  string  $event
     * @param  mixed   $object
     * @return mixed
     */
    public function chain($event, $object)
    {
        if (count($this->getListeners($event)) == 0) return $object;

        foreach ($this->getListeners($event) as $listener)
        {
            $object = call_user_func_array($listener, array($object));
        }

        return $object;
    }
}
