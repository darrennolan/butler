<?php

/**
 * Theme Specific Settings, Event Hooks and Functions
 */
ButlerTheme::setSettings(
    array(
        'Name'         => 'Default Butler Theme',
        'Author'       => 'Darren Nolan',
        'Copyright'    => '2013(c) All Rights Reserved',

        'default_page' => 'index',
    )
);

Butler\Events\Paginate::setPerPage(5);

ButlerEvent::listen('butler.post.title', function($title) {
    $title = str_replace('Post', 'Rawr', $title);
    return $title;
});
