<?php

/**
 * Theme Specific Settings, Event Hooks and Functions
 */
Butler\Events\Paginate::setPerPage(5);

ButlerTheme::setSettings(
    array(
        'Name'         => 'Default Butler Theme',
        'Author'       => 'Darren Nolan',
        'Copyright'    => '2013(c) All Rights Reserved',

        'default_page' => 'index',
    )
);
