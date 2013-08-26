<?php

// Butler model observers
Butler\Model\Category::observe(new Butler\Observer\ModelObserver);
Butler\Model\Comment::observe(new Butler\Observer\ModelObserver);
Butler\Model\Post::observe(new Butler\Observer\ModelObserver);
Butler\Model\PostSlug::observe(new Butler\Observer\ModelObserver);
Butler\Model\Setting::observe(new Butler\Observer\ModelObserver);
