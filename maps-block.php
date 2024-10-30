<?php
/**
 * Plugin Name: Maps Block
 * Plugin URI: http://wedoplugins.com/plugins/maps-block/
 * Description: This plugin adds a Maps Block to new WordPress Blocks editor.
 * Author: We Do Plugins
 * Author URI: http://wedoplugins.com/
 * Version: 1.2.6
 * License: GPLv3
 * Text Domain: maps-block
 *
 * @package maps-block
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

define( 'WDPMB_MAIN_FILE', __FILE__ );
define( 'WDPMB_VERSION', '1.2.6' );

/**
 * Require plugin classes
 */
require_once dirname( WDPMB_MAIN_FILE ) . '/classes/class-wdpmb-settings.php';
require_once dirname( WDPMB_MAIN_FILE ) . '/classes/class-wdpmb-enqueue.php';
require_once dirname( WDPMB_MAIN_FILE ) . '/classes/class-wdpmb-blockssummarypage.php';
