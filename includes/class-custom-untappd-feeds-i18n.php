<?php

/**
 * Define the internationalization functionality
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @link       https://www.alexjustesen.com
 * @since      2018.11
 *
 * @package    Custom_Untappd_Feeds
 * @subpackage Custom_Untappd_Feeds/includes
 */

/**
 * Define the internationalization functionality.
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @since      2018.11
 * @package    Custom_Untappd_Feeds
 * @subpackage Custom_Untappd_Feeds/includes
 * @author     Alex Justesen <alex@alexjustesen.com>
 */
class Custom_Untappd_Feeds_i18n {


	/**
	 * Load the plugin text domain for translation.
	 *
	 * @since    2018.11
	 */
	public function load_plugin_textdomain() {

		load_plugin_textdomain(
			'custom-untappd-feeds',
			false,
			dirname( dirname( plugin_basename( __FILE__ ) ) ) . '/languages/'
		);

	}



}
