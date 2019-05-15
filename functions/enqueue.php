<?php


define( 'CRTDIU_VERSION', wp_get_theme()->version );
define( 'CRTDIU_DIR', __DIR__ );
define( 'CRTDIU_URL', get_template_directory_uri() );

/**
 * Enqueue scripts and styles
 */
add_action( 'wp_enqueue_scripts', function() {

	// JS 
	wp_enqueue_script( 
		'app_js',
		//HEISENBERG_URL . "/dist/build{$min_ext}.js",
		CRTDIU_URL . "/dist/build.js",
		null,
        rand(111,9999),
		true

	);

    // Hooper
//    wp_enqueue_style(
//        'hooper',
//	    CRTDIU_URL . '/libs/hooper/hooper.css'
//    );

	// CSS
	wp_enqueue_style(
		'app_css',
		CRTDIU_URL . '/dist/main.css',
		null,
        rand(111,9999)
	);

} );
