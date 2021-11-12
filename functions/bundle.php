<?php

/**
 * Enqueue assets (styles and scripts)
 */
function enqueue_scripts_and_styles() {
	wp_enqueue_style( 'entry', mix( 'css/entry.css' ), [], wp_get_theme()->get( 'Version' ) );
	wp_enqueue_script( 'entry', mix( 'js/entry.js' ), [], wp_get_theme()->get( 'Version' ), true );
}

add_action( 'wp_enqueue_scripts', 'enqueue_scripts_and_styles' );
