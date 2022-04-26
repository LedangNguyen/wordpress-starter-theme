<?php
define( 'TEMPLATE_DIR', get_template_directory() );
define( 'TEMPLATE_DIR_URI', get_template_directory_uri() );

require_once( TEMPLATE_DIR . '/vendor/autoload.php' );

$func_error = static function ( $message, $subtitle = '', $title = '' ) {
	$title   = $title ?: __( 'Error' );
	$message = "<h1>{$title}<br><small>{$subtitle}</small></h1><p>{$message}</p>";

	if ( ! is_admin() ) {
		wp_die( wp_kses_post( $message ), wp_kses_post( $title ) );
	}
};

$includes = [
	'helpers',
	'bundle',
	'custom',
	'utils',
	'twig',
	'acf',
];

array_map( static function ( $file ) use ( $func_error ) {
	$file = "inc/{$file}.php";

	if ( ! locate_template( $file, true, true ) ) {
		$func_error( sprintf( __( 'Error locating <code>%s</code> for inclusion.' ), $file ), 'File not found' );
	}
}, $includes );
