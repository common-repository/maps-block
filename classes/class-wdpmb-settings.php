<?php
/**
 * Register custom settings for Maps Block
 *
 * @package maps-block
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

add_action( 'wdp_blocks_summary_settings', array( 'WDPMB_Settings', 'setting_form' ) );
add_action( 'admin_enqueue_scripts', array( 'WDPMB_Settings', 'enqueue_scripts' ) );
add_action( 'rest_api_init', array( 'WDPMB_Settings', 'register_endpoint' ) );

add_filter( 'wdp_blocks_summary_has_settings', '__return_true' );

/**
 * Settings class
 */
abstract class WDPMB_Settings {

	/**
	 * Google maps API key option name
	 *
	 * @var string
	 */
	public static $option_name = 'wdpmb-google-maps-api-key';

	/**
	 * Google Maps API key
	 *
	 * @var mixed
	 */
	public static $api_key = null;

	/**
	 * Register endpoint
	 */
	public static function register_endpoint() {

		register_rest_route(
			'wdpmb/v1',
			'/update-google-maps-api-key',
			array(
				'methods'             => 'POST',
				'callback'            => array( get_class(), 'update_google_maps_api_key' ),
				'args'                => array(
					'nonce' => array(
						'required'          => true,
						'validate_callback' => function( $nonce ) { // phpcs:ignore PHPCompatibility.FunctionDeclarations.NewClosure.Found
							return wp_verify_nonce( $nonce, 'wdpmb_update_google_maps_api_key' );
						},
					),
				),
				'permission_callback' => function() { // phpcs:ignore PHPCompatibility.FunctionDeclarations.NewClosure.Found
					return current_user_can( 'manage_options' );
				},
			)
		);
	}

	/**
	 * Get setting form content
	 */
	public static function setting_form() {

		?>
		<div id="wdp-blocks-summary__setting__google-maps-api-key" class="wdp-blocks-summary__setting">
			<p class="wdp-blocks-summary__setting__loading-notice"><?php echo esc_html( __( 'Loading...', 'maps-block' ) ); ?></p>
		</div>
		<?php
	}

	/**
	 * Enqueue settings JS script
	 */
	public static function enqueue_scripts() {

		$current_screen = get_current_screen();

		if ( 'settings_page_wdp-blocks-summary' === $current_screen->id ) {

			wp_enqueue_style( 'wp-components' );
			wp_enqueue_script( 'wdp-maps-block-settings', plugins_url( 'build/settings.min.js', WDPMB_MAIN_FILE ), array( 'wp-element', 'wp-i18n', 'wp-components', 'wp-api-fetch' ), WDPMB_VERSION, true );

			wp_localize_script(
				'wdp-maps-block-settings',
				'wdpmbSettings',
				array(
					'googleMapsApiKey' => self::get_google_maps_api_key(),
					'nonces'           => array(
						'updateGoogleMapsApiKey' => wp_create_nonce( 'wdpmb_update_google_maps_api_key' ),
						'wpRest'                 => wp_create_nonce( 'wp_rest' ),
					),
				)
			);
		}
	}

	/**
	 * Handle REST request
	 * - update Google Maps API key
	 *
	 * @param object $request Request object.
	 */
	public static function update_google_maps_api_key( $request ) {

		$body = json_decode( $request->get_body(), true );

		if ( ! isset( $body['googleMapsApiKey'] ) ) {
			return new WP_REST_Response(
				array(
					'code'    => 'invalid_google_maps_api_key',
					'message' => __( 'Google Maps API key is invalid.', 'maps-block' ),
					'data'    => array(
						'status' => 400,
					),
				),
				400
			);
		}

		if ( true === update_option( self::$option_name, esc_html( $body['googleMapsApiKey'] ) ) ) {
			return new WP_REST_Response( array( 'status' => 'ok' ), 200 );
		}

		return new WP_REST_Response( array( 'status' => 'error' ), 500 );
	}

	/**
	 * Get Google Maps API key
	 */
	public static function get_google_maps_api_key() {

		if ( null === self::$api_key ) {
			self::$api_key = get_option( self::$option_name );
		}

		if ( in_array( self::$api_key, array( null, false, '' ), true ) ) {
			return null;
		}

		return esc_js( self::$api_key );
	}
}
