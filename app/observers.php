<?php

use Butler\Model;
use Butler\Observer;

// Butler model observers
Model\Post::observe(new Observer\Revision);
