<?php

/**
 * Parse mix-manifest and return an url of the asset with version (for cache busting)
 *
 * @param $path
 * @param string $manifest_directory
 *
 * @return string
 */
if ( ! function_exists('mix') ) {
	function mix( $path, $manifest_directory = 'assets' ): string {
		static $manifest;
		static $manifest_path;

		if ( ! $manifest_path ) {
			$manifest_path = get_theme_file_path( $manifest_directory . '/mix-manifest.json' );
		}

		// Bailout if manifest couldn’t be found
		if ( ! file_exists( $manifest_path ) ) {
			return get_theme_file_uri( $path );
		}

		if ( ! $manifest ) {
			// @codingStandardsIgnoreLine
			$manifest = json_decode( file_get_contents( $manifest_path ), true );
		}

		// Remove manifest directory from path
		$path = str_replace( $manifest_directory, '', $path );
		// Make sure there’s a leading slash
		$path = '/' . ltrim( $path, '/' );

		// Bailout with default theme path if file could not be found in manifest
		if ( ! array_key_exists( $path, $manifest ) ) {
			return get_theme_file_uri( $path );
		}

		// Get file URL from manifest file
		$path = $manifest[ $path ];
		// Make sure there’s no leading slash
		$path = ltrim( $path, '/' );

		return get_theme_file_uri( trailingslashit( $manifest_directory ) . $path );
	}
}

/**
 * Get attachment image with srcset and sizes attributes
 *
 * @param number $attachment_id
 * @param string $size
 * @param string $title
 * @param string $alt
 * @param string $className
 *
 * @return string|bool
 */
if ( ! function_exists( 'get_attachment_image' ) ) {
	function get_attachment_image( $attachment_id, $size = 'full', $title = null, $alt = null, $className = null ): bool|string {
		if ( empty( $attachment_id ) ) {
			return false;
		}

		$attrs = [
			'srcset'  => wp_get_attachment_image_srcset( $attachment_id, $size ),
			'sizes'   => wp_get_attachment_image_sizes( $attachment_id, $size ),
			'loading' => 'lazy',
		];

		if ( ! empty( $title ) ) {
			$attrs['title'] = wp_strip_all_tags( $title );
		}

		if ( ! empty( $alt ) ) {
			$attrs['alt'] = wp_strip_all_tags( $alt );
		}

		if ( ! empty( $className ) ) {
			$attrs['class'] .= wp_strip_all_tags( $className );
		}

		return wp_get_attachment_image( $attachment_id, $size, false, $attrs );
	}
}

/**
 * Check if the current page is the login page
 */
if ( ! function_exists( 'is_login_page' ) ) {
	function is_login_page(): bool
	{
		return in_array(
			$GLOBALS['pagenow'],
			array( 'wp-login.php', 'wp-register.php' ),
			true
		);
	}
}
