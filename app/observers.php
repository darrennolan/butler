<?php

use Butler\Model;
use Butler\Observer\RevisionObserver;

// Butler model observers
Model\Post::observe(new RevisionObserver);
