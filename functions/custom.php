<?php
/**
 * Theme Support
 */
function theme_support() {
	add_theme_support( 'html5' );
	add_theme_support( 'title-tag' );
	add_theme_support( 'post-thumbnails' );
}

add_action( 'after_setup_theme', 'theme_support' );

/**
 * Menus
 */
register_nav_menus( [
	'header_menu' => 'Header Menu',
	'footer_menu' => 'Footer Menu'
] );

/**
 * Defer loading of JavaScript assets
 */
function defer_loading_of_scripts( $tag, $handle ) {
	$excluded = [
		'jquery',
	];

	if ( in_array( $handle, $excluded ) ) {
		return $tag;
	}

	return str_replace( 'src', 'defer src', $tag );
}

if ( ! is_admin() && ! is_login_page() ) {
	add_filter( 'script_loader_tag', 'defer_loading_of_scripts', 10, 2 );
}

/**
 * Cleanup <head> from unneeded stuff
 */
remove_action( 'wp_head', 'wp_generator' );
remove_action( 'wp_head', 'feed_links_extra', 3 );
remove_action( 'wp_head', 'feed_links', 2 );
remove_action( 'wp_head', 'rsd_link' );
remove_action( 'wp_head', 'wlwmanifest_link' );
remove_action( 'wp_head', 'wp_shortlink_wp_head' );
remove_action( 'wp_head', 'adjacent_posts_rel_link_wp_head' );
remove_action( 'wp_head', 'start_post_rel_link', 10, 0 );
remove_action( 'wp_head', 'adjacent_post_rel_link_wp_head', 10, 0 );

// Remove Emoji icons (If needed – remove/comment two lines below)
remove_action( 'wp_head', 'print_emoji_detection_script', 7 );
remove_action( 'wp_print_styles', 'print_emoji_styles' );

// Removes oembed discovery links (If you are planning on adding Youtube videos, tweets embeds, etc. – remove/comment 3 lines below)
remove_action( 'wp_head', 'rest_output_link_wp_head' );
remove_action( 'wp_head', 'wp_oembed_add_discovery_links', 10 );
remove_action( 'wp_head', 'wp_oembed_add_host_js' );

// Remove meta rel=dns-prefetch href=//s.w.org
remove_action( 'wp_head', 'wp_resource_hints', 2 );
