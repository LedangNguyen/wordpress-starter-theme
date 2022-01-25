<?php
/**
 * Theme Support
 */
function theme_support() {
	add_theme_support( 'html5', [
		'comment-list',
		'comment-form',
		'search-form',
		'gallery',
		'caption',
		'style',
		'script',
		'navigation-widgets',
	] );
	add_theme_support( 'title-tag' );
	add_theme_support( 'post-thumbnails' );
	add_theme_support( 'custom-logo' );
	add_theme_support( 'customize-selective-refresh-widgets' );

	add_theme_support( 'wp-block-styles' );
	add_theme_support( 'align-wide' );
	add_theme_support( 'custom-line-height' );
	add_theme_support( 'responsive-embeds' );
	add_theme_support( 'custom-spacing' );

//	Uncomment two lines below if you want to add custom styles for Gutenberg editor
//	add_theme_support( 'editor-styles' );
//	add_editor_style( mix( 'css/editor-style.css' ) );
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
 * Defer CSS loading
 */
function add_rel_preload( $html, $handle, $href, $media ) {
	if ( is_admin() ) {
		return $html;
	}

	$html = <<<EOT
<link rel='preload' as='style' onload="this.onload=null;this.rel='stylesheet'" id='$handle' href='$href' media='$media' />
EOT;

	return $html;
}

add_filter( 'style_loader_tag', 'add_rel_preload', 10, 4 );


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

/**
 * Add SVG Support
 */
function check_filetype_and_extension( $data, $file, $filename, $mimes ) {
	global $wp_version;

	if ( $wp_version !== '4.7.1' ) {
		return $data;
	}

	$filetype = wp_check_filetype( $filename, $mimes );

	return [
		'ext'             => $filetype['ext'],
		'type'            => $filetype['type'],
		'proper_filename' => $data['proper_filename']
	];
}

function cc_mime_types( $mimes ) {
	$mimes['svg'] = 'image/svg+xml';

	return $mimes;
}

function fix_svg() {
	echo '<style type="text/css">
        .attachment-266x266, .thumbnail img {
             width: 100% !important;
             height: auto !important;
        }
        </style>';
}

add_filter( 'wp_check_filetype_and_ext', 'check_filetype_and_extension', 10, 4 );
add_filter( 'upload_mimes', 'cc_mime_types' );
add_action( 'admin_head', 'fix_svg' );
