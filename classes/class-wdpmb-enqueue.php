<?php
/**
 * Enqueue block scripts and styles
 *
 * @package maps-block
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

add_action( 'enqueue_block_editor_assets', array( 'WDPMB_Enqueue', 'editor_enqueue' ) );
add_action( 'wp_enqueue_scripts', array( 'WDPMB_Enqueue', 'enqueue_block' ) );

/**
 * Enqueue class
 */
class WDPMB_Enqueue {

	/**
	 * Enqueue scripts and styles on editor
	 */
	public static function editor_enqueue() {

		wp_enqueue_script(
			'wdp/maps-block',
			plugins_url( 'build/block.min.js', WDPMB_MAIN_FILE ),
			array(
				'wp-i18n',
				'wp-blocks',
				'wp-editor',
				'wp-components',
				'wp-element',
			),
			WDPMB_VERSION,
			true
		);

		self::enqueue_block( true );
	}

	/**
	 * Enqueue maps block styles on front-end
	 *
	 * @param bool $is_editor Are styles for editor or not.
	 */
	public static function enqueue_block( $is_editor = false ) {

		if ( empty( $is_editor ) ) {
			$is_editor = false;
		}

		wp_enqueue_style(
			'wdp/maps-block',
			plugins_url( 'build/block' . esc_attr( true === $is_editor ? '-editor' : '' ) . '.css', WDPMB_MAIN_FILE ),
			array(),
			WDPMB_VERSION
		);

		self::enqueue_google_maps_api();

		if ( false === $is_editor ) {
			wp_enqueue_script( 'wdp/maps-block-front', plugins_url( 'build/front.min.js', WDPMB_MAIN_FILE ), array(), WDPMB_VERSION, true );
		}
	}

	/**
	 * Enqueue Google Maps API script
	 */
	private static function enqueue_google_maps_api() {

		$api_key = WDPMB_Settings::get_google_maps_api_key();
		wp_enqueue_script( 'google-maps', ( is_ssl() ? 'https' : 'http' ) . '://maps.googleapis.com/maps/api/js' . esc_attr( null !== $api_key ? '?key=' . $api_key : '' ), array(), null, true ); // phpcs:ignore WordPress.WP.EnqueuedResourceParameters
	}
}
