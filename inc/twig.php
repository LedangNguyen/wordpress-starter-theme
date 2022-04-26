<?php

use Timber\Menu;

/**
 * Add custom data to Twig context
 *
 * @param $context
 *
 * @return mixed
 */
function add_to_context( $context ) {
	$context['header_menu'] = new Menu( 'header-menu' );

	return $context;
}

add_filter( 'timber/context', 'add_to_context' );
