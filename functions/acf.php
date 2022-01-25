<?php
/**
 * Init ACF Builder, blocks and fields
 */
$files = glob( TEMPLATE_DIR . '/functions/acf/*.php' );

array_unshift($files, TEMPLATE_DIR . '/vendor/autoload.php');

array_map( function ( $file ) {
	require_once( $file );
}, $files );
