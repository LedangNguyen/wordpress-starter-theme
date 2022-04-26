<?php

use StoutLogic\AcfBuilder\FieldsBuilder;
use Timber\Timber;

if ( ! function_exists( 'mix' ) ) {
	/**
	 * Parse mix-manifest and return an url of the asset with version (for cache busting)
	 *
	 * @param $path
	 * @param string $manifest_directory
	 *
	 * @return string
	 * @throws JsonException
	 */
	function mix( $path, string $manifest_directory = 'assets' ): string {
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
			$manifest = json_decode( file_get_contents( $manifest_path ), true, 512, JSON_THROW_ON_ERROR );
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

if ( ! function_exists( 'get_attachment_image' ) ) {
	/**
	 * Get attachment image with srcset and sizes attributes
	 *
	 * @param number $attachment_id
	 * @param string $size
	 * @param string|null $title
	 * @param string|null $alt
	 * @param string|null $className
	 * @param number $width
	 * @param number $height
	 *
	 * @return string|bool
	 */
	function get_attachment_image( $attachment_id, string $size = 'full', string $title = null, string $alt = null, string $className = null, $width = null, $height = null ) {
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

		if ( ! empty( $width ) ) {
			$attrs['width'] = wp_strip_all_tags( $width );
		}

		if ( ! empty( $height ) ) {
			$attrs['height'] = wp_strip_all_tags( $height );
		}

		return wp_get_attachment_image( $attachment_id, $size, false, $attrs );
	}
}

if ( ! function_exists( 'is_login_page' ) ) {
	/**
	 * Check if the current page is the login page
	 *
	 * @return bool
	 */
	function is_login_page(): bool {
		return in_array(
			$GLOBALS['pagenow'],
			array( 'wp-login.php', 'wp-register.php' ),
			true
		);
	}
}

if ( ! function_exists( 'acf_generate_block' ) ) {
	/**
	 * ACF Block Generator
	 *
	 * @param string $name
	 * @param string $title
	 * @param string $category
	 * @param string $render_template
	 * @param bool $multiple
	 *
	 * @return array
	 */
	function acf_generate_block( string $name, string $title, string $category, string $render_template, bool $multiple = true ): array {
		return [
			'name'            => $name,
			'title'           => ! empty( BLOCKS[ $category ] ) ? BLOCKS[ $category ] . ': ' . $title : $title,
			'category'        => $category,
			'mode'            => 'edit',
			'align'           => 'wide',
			'render_callback' => function ( $block, $content = '', $is_preview = false ) use ( $render_template ) {
				$context = Timber::context();

				$context['block']      = $block;
				$context['fields']     = get_fields();
				$context['is_preview'] = $is_preview;

				Timber::render( $render_template, $context );
			},
			'supports'        => [
				'align'    => true,
				'mode'     => false,
				'multiple' => $multiple,
				'anchor'   => true,
			],
		];
	}
}

if ( ! function_exists( 'fields_builder' ) ) {
	function fields_builder( string $name, string $title ): FieldsBuilder {
		$builder = new FieldsBuilder( $name );
		$builder->addMessage( null, '<h2>' . $title . '</h2>' );

		return $builder;
	}
}
