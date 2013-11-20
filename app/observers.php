<?php

use Butler\Models;
use Butler\Observers;

// Butler model observers
Models\Post::observe(new Observers\Revision);
