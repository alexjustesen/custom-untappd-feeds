<?php

/**
 * Fired when the plugin is uninstalled.
 *
 * When populating this file, consider the following flow
 * of control:
 *
 * - This method should be static
 * - Check if the $_REQUEST content actually is the plugin name
 * - Run an admin referrer check to make sure it goes through authentication
 * - Verify the output of $_GET makes sense
 * - Repeat with other user roles. Best directly by using the links/query string parameters.
 * - Repeat things for multisite. Once for a single site in the network, once sitewide.
 *
 * This file may be updated more in future version of the Boilerplate; however, this is the
 * general skeleton and outline for how the file should work.
 *
 * For more information, see the following discussion:
 * https://github.com/tommcfarlin/WordPress-Plugin-Boilerplate/pull/123#issuecomment-28541913
 *
 * @link       https://www.alexjustesen.com
 * @since      1.0.0
 *
 * @package    Custom_Untappd_Feeds
 */

// If uninstall not called from WordPress, then exit.
if ( ! defined( 'WP_UNINSTALL_PLUGIN' ) ) {
	exit;
}

//If the user is preserving the settings then don't delete them
/*$options = get_option( 'cuf_options' );
$cuf_preserve_settings = isset( $options[ 'preserve_settings' ] ) ? $options[ 'preserve_settings' ] : false;

// allow the user to preserve their settings in case they are upgrading
if ( ! $cuf_preserve_settings ) {
    // clean up options from the database
    delete_option( 'cuf_configure' );
    delete_option( 'cuf_customize' );
    delete_option( 'cuf_style' );
    delete_option( 'cuf_options' );
    delete_option( 'cuf_version' );
    delete_option( 'cuf_rating_notice' );
    delete_transient( 'custom_twitter_feeds_rating_notice_waiting' );

    // delete tweet cache in transients
    global $wpdb;
    $table_name = $wpdb->prefix . "options";
    $wpdb->query( "
        DELETE
        FROM $table_name
        WHERE `option_name` LIKE ('%\_transient\_cuf\_%')
        " );
    $wpdb->query( "
        DELETE
        FROM $table_name
        WHERE `option_name` LIKE ('%\_transient\_timeout\_cuf\_%')
        " );

	//Delete all persistent caches (start with cuf_!)
	global $wpdb;
	$table_name = $wpdb->prefix . "options";
	$result = $wpdb->query("
        DELETE
        FROM $table_name
        WHERE `option_name` LIKE ('%cuf\_\!%')
        ");
	delete_option( 'cuf_cache_list' );

    // remove any scheduled cron jobs
    wp_clear_scheduled_hook( 'cuf_cron_job' );
}*/
