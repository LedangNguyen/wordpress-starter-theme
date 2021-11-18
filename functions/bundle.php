<?php
/**
 * Enqueue assets (styles and scripts)
 */
function enqueue_scripts_and_styles() {
	wp_enqueue_style( 'app', mix( 'css/app.css' ), [], wp_get_theme()->get( 'Version' ) );
	wp_enqueue_script( 'app', mix( 'js/app.js' ), [], wp_get_theme()->get( 'Version' ), true );
}

/**
 * Enqueue Critical CSS
 */
function enqueue_critical_css() {
	echo '<style type="text/css" media="all" id="critical-css">' . file_get_contents( TEMPLATE_DIR . '/assets/css/critical.css' ) . '</style>';
}

add_action( 'wp_enqueue_scripts', 'enqueue_scripts_and_styles' );
add_action( 'wp_head', 'enqueue_critical_css' );
