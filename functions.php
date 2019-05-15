<?php

add_theme_support( 'post-thumbnails', array( 'post','crtdiu_association' ) );
add_theme_support( 'post-thumbnails', array( 'post','crtdiu_event' ) );

function filter_rest_allow_anonymous_comments() {
    return true;
}
add_filter('rest_allow_anonymous_comments','filter_rest_allow_anonymous_comments');


require_once __DIR__ . '/functions/customizer.php';

require_once __DIR__ . '/functions/shortcodes.php';

require_once __DIR__ . '/functions/filters.php';

require_once __DIR__ . '/functions/sidebars.php';

require_once __DIR__ . '/widgets/widgets.php';

require_once __DIR__ . '/functions/menu.php';

require_once __DIR__ . '/functions/enqueue.php';

require_once __DIR__ . '/functions/breadcrumbs.php';

require_once __DIR__ . '/functions/comments.php';

