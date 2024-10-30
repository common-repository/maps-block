<?php
/**
 * Create and render "welcome" page
 *
 * @package maps-block
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( defined( 'WDP_SUMMARY_PAGE' ) ) {
	return;
}

// phpcs:disable WordPress.NamingConventions.PrefixAllGlobals.NonPrefixedConstantFound

define( 'WDP_SUMMARY_PAGE', true ); // Tell the other plugins that summary page is already rendered.
define( 'WDP_BSP_MAIN_FILE', WDPMB_MAIN_FILE );
define( 'WDP_BSP_VERSION', '1.0.11' );

// phpcs:enable WordPress.NamingConventions.PrefixAllGlobals.NonPrefixedConstantFound

add_action( 'admin_menu', array( 'WDPMB_BlocksSummaryPage', 'register_blocks_summary_page' ) );
add_action( 'admin_enqueue_scripts', array( 'WDPMB_BlocksSummaryPage', 'enqueue_scripts' ) );

/**
 * Blocks summary page class
 */
abstract class WDPMB_BlocksSummaryPage {

	/**
	 * Register blocks summary page
	 */
	public static function register_blocks_summary_page() {

		add_options_page(
			esc_html( __( 'Blocks by We Do Plugins', 'maps-block' ) ),
			esc_html( __( 'Blocks by We Do Plugins', 'maps-block' ) ),
			'manage_options',
			'wdp-blocks-summary',
			array( get_class(), 'render_blocks_summary_page' )
		);
	}

	/**
	 * Enqueue admin scripts
	 */
	public static function enqueue_scripts() {

		if ( 'settings_page_wdp-blocks-summary' === get_current_screen()->id ) {

			wp_enqueue_style( 'wdp-blocks-summary', plugins_url( 'build/blocks-summary.css', WDP_BSP_MAIN_FILE ), array(), WDP_BSP_VERSION );
			wp_enqueue_script( 'wdp-blocks-summary-plugins-table', plugins_url( 'build/plugins-table.min.js', WDP_BSP_MAIN_FILE ), array( 'wp-i18n', 'wp-element' ), WDP_BSP_VERSION, true );

			wp_localize_script(
				'wdp-blocks-summary-plugins-table',
				'wdpBlocksSummaryPluginsTable',
				array(
					'usedPlugins' => self::get_used_plugins_data(),
				)
			);
		}
	}

	/**
	 * Get data of used plugins by We Do Plugins
	 */
	private static function get_used_plugins_data() {

		if ( ! function_exists( 'get_plugins' ) ) {
			require_once ABSPATH . 'wp-admin/includes/plugin.php';
		}

		$plugins = get_plugins();
		$result  = array(
			'installed' => array(),
			'active'    => array(),
		);

		foreach ( $plugins as $plugin_path => $plugin_data ) {

			if ( 'We Do Plugins' !== $plugin_data['AuthorName'] ) {
				continue;
			}

			$slug = explode( '/', $plugin_path );
			$slug = isset( $slug[0] ) ? $slug[0] : null;

			if ( null !== $slug ) {

				if ( is_plugin_active( "$slug/$slug.php" ) ) {
					$result['active'][] = $slug;
				} else {
					$result['installed'][] = $slug;
				}
			}
		}

		return $result;
	}

	/**
	 * Render blocks summary page
	 */
	public static function render_blocks_summary_page() {

		?>
		<div class="wrap wdp-blocks-summary">
			<div class="wdp-blocks-summary__heading">
				<img src="<?php echo esc_url( plugins_url( 'img/wedoplugins.png', WDP_BSP_MAIN_FILE ) ); ?>" alt="<?php echo esc_html( __( 'We Do Plugins', 'maps-block' ) ); ?>" class="wdp-blocks-summary__heading__icon" />
				<h1><?php echo esc_html( __( 'Blocks by We Do Plugins', 'maps-block' ) ); ?></h1>
				<p>
					<?php echo esc_html( __( 'We offer plugins that helps you to build and maintain your website.', 'maps-block' ) ); ?><br>
					<?php echo esc_html( __( 'Check our plugins portfolio and improve your website today.', 'maps-block' ) ); ?>
				</p>
				<p>
					<a href="https://wedoplugins.com" target="_blank" rel="noopener noreferrer"><?php echo esc_html( __( 'Visit our website', 'maps-block' ) ); ?></a>
					<?php echo esc_html( __( 'or', 'maps-block' ) ); ?>
					<a href="https://twitter.com/wedoplugins" target="_blank" rel="noopener noreferrer"><?php echo esc_html( __( 'follow us on Twitter', 'maps-block' ) ); ?></a>
				</p>
			</div>
			<div class="wdp-blocks-summary__container">
				<div class="wdp-blocks-summary__container__content">
					<?php

					// Display plugins settings, only if any exists.
					if ( true === apply_filters( 'wdp_blocks_summary_has_settings', false ) ) {

						?>
						<div class="wdp-blocks-summary__settings">
							<h2><?php echo esc_html( __( 'Blocks settings', 'maps-block' ) ); ?></h2>
							<?php do_action( 'wdp_blocks_summary_settings' ); // phpcs:ignore WordPress.NamingConventions.PrefixAllGlobals ?>
						</div>
						<?php
					}

					?>
					<h2><?php echo esc_html( __( 'Check other our plugins (not only blocks!)', 'maps-block' ) ); ?></h2>
					<div id="wdp-blocks-summary__plugins-table__container"></div>
				</div>
			</div>
		</div>
		<?php
	}
}
