<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              https://www.alexjustesen.com
 * @since             2018.11
 * @package           Custom_Untappd_Feeds
 *
 * @wordpress-plugin
 * Plugin Name:       Custom Untappd Feeds
 * Plugin URI:        https://www.alexjustesen.com
 * Description:       Unofficial Untappd plugin. Display your recent checkins, user profile and wishlist.
 * Version:           2018.12-beta
 * Author:            Alex Justesen
 * Author URI:        https://www.alexjustesen.com
 * License:           MIT
 * Text Domain:       custom-untappd-feeds
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/** Define plugin constants
 * Versioning by Calendar standard (https://calver.org/) year.month.patch
 */
define( 'PLUGIN_NAME_VERSION', '2018.12-beta' );
define( 'PLUGIN_PATH', plugin_dir_path( __FILE__ ) );
define( 'PLUGIN_URL', plugin_dir_url( __FILE__ ) );

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-custom-untappd-feeds-activator.php
 */
function activate_custom_untappd_feeds() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-custom-untappd-feeds-activator.php';
	Custom_Untappd_Feeds_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-custom-untappd-feeds-deactivator.php
 */
function deactivate_custom_untappd_feeds() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-custom-untappd-feeds-deactivator.php';
	Custom_Untappd_Feeds_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_custom_untappd_feeds' );
register_deactivation_hook( __FILE__, 'deactivate_custom_untappd_feeds' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-custom-untappd-feeds.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_custom_untappd_feeds() {

	$plugin = new Custom_Untappd_Feeds();
	$plugin->run();

}
run_custom_untappd_feeds();
