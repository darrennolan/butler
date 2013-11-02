<?php

// Butler model observers
Butler\Model\Category::observe(new Butler\Observer\RevisionObserver);
Butler\Model\Comment::observe(new Butler\Observer\RevisionObserver);
Butler\Model\Post::observe(new Butler\Observer\RevisionObserver);
Butler\Model\PostSlug::observe(new Butler\Observer\RevisionObserver);
Butler\Model\Setting::observe(new Butler\Observer\RevisionObserver);
