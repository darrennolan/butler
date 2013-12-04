<?php namespace Butler\Events;

class Contract
{
    private $expects_returned = array();
    private $arguments        = array();

    public function __construct($expects_returned = array(), $arguments = array())
    {
        if (!is_array($expects_returned)) {
            $expects_returned = array($expects_returned);
        }

        if (!is_array($arguments)) {
            $arguments = array($arguments);
        }

        $this->expects_returned = $expects_returned;

        $this->arguments = $arguments;
    }


}
