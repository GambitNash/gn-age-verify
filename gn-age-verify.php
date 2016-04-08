<?php
/**
 * The main plugin file.
 *
 * This file loads the main plugin class and gets things running.
 *
 * This plugin is a heavily modified fork of the original Age Verify plugin,
 * written by Chase Wiseman, which can be found on GitHub at the following URL:
 * @see https://github.com/ChaseWiseman/gn-age-verify
 *
 * @since 0.2.6
 *
 * @package GN_Age_Verify
 */

/**
 * Plugin Name: GN Age Verify
 * Plugin URI: https://gambitnash.co.uk/
 * Description: A simple way to ask visitors for their age before viewing your site.
 * Author:      Chase Wiseman
 * Author URI:  http://chasewiseman.com
 * Version:     0.3.1
 * License:     GPL3
 * Text Domain: gn-gn-age-verify
 * Domain Path: /languages
 */

// Don't allow this file to be accessed directly.
if ( ! defined( 'WPINC' ) ) {
	die();
}

/**
 * The main class definition.
 */
require( plugin_dir_path( __FILE__ ) . 'includes/class-gn-gn-age-verify.php' );

// Get the plugin running.
add_action( 'plugins_loaded', array( 'GN_Age_Verify', 'get_instance' ) );

// Check that the admin is loaded.
if ( is_admin() ) {

	/**
	 * The admin class definition.
	 */
	require( plugin_dir_path( __FILE__ ) . 'includes/admin/class-gn-age-verify-admin.php' );

	// Get the plugin's admin running.
	add_action( 'plugins_loaded', array( 'GN_Age_Verify_Admin', 'get_instance' ) );
}
