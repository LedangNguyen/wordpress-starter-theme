<?php
/**
 * Init ACF Builder, blocks and fields
 */
$files = glob( TEMPLATE_DIR . '/inc/acf/*.php' );

array_map( static function ( $file ) {
	require_once( $file );
}, $files );
