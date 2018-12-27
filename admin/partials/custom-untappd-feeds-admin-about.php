<?php

/**
 * Provide a admin area view for the plugin
 *
 * This file is used to markup the admin-facing aspects of the plugin.
 *
 * @link       https://www.alexjustesen.com
 * @since      2018.11
 *
 * @package    Custom_Untappd_Feeds
 * @subpackage Custom_Untappd_Feeds/admin/partials
 */

require_once PLUGIN_PATH . 'includes/class-custom-untappd-feeds-api.php';
require_once PLUGIN_PATH . 'includes/class-custom-untappd-feeds-admin-tools.php';

$api = new Custom_Untappd_Feeds_API();
$tools = new Custom_Untappd_Feeds_Admin_Tools();

$cache_results = $tools->get_cache();

?>

<div class="wrap">
    
    <h1><i class="fab fa-untappd fa-fw"></i> Custom Untappd Feeds <small>- About This Plugin</small></h1>
    
    <h2>About</h2>
    <p>This is an unofficial Untappd WordPress plugin and released under the GNU GENERAL PUBLIC LICENSE with NO WARRANTEE.</p>
    
    <p>With <strong>Custom Untappd Feeds</strong> you can display your <a href="https://www.untappd.com" rel="nofollow" target="_blank">Untappd</a> user information, user activity feed and badges earned. To use this plugin check out the <a href="admin.php?page=custom-untappd-feeds-documentation" target="_self">documentation</a> for how to configure the sortcodes.</p>
    
    <h2>Cached API Calls</h2>
    
    <?php if ( $cache_results ) : ?>
    
        <table class="wp-list-table widefat fixed posts">
            <thead>
                <tr>
                    <th style="width: 40px"><?php _e( 'ID', 'custom-untappd-feeds' ); ?></th>
                    <th><?php _e( 'Cache Name', 'custom-untappd-feeds' ); ?></th>
                    <th><?php _e( 'Cache Code', 'custom-untappd-feeds' ); ?></th>
                    <th><?php _e( 'Cache Expires', 'custom-untappd-feeds' ); ?></th>
                    <th><?php _e( 'Actions', 'custom-untappd-feeds' ); ?></th>
                </tr>
            </thead>

            <tbody>
                <?php foreach( $cache_results as $row ) : ?>
                    
                    <?php
                        $transient_name = $tools->get_transient_name( $row );
                        $transient_value = get_transient( $transient_name );
                        $delete_url = wp_nonce_url( add_query_arg( array( 'action' => 'delete_transient', 'transient' => $transient_name , 'name' => $row->option_name ) ), 'custom_untappd_feeds' );
            
                        $body = json_decode( $transient_value['body'], true );
                    ?>
                    
                    <tr>
                        <td><?php echo $row->option_id; ?></td>
                        <td><?php echo $transient_name; ?></td>
                        <td><?php echo $body['meta']['code']; ?></td>
                        <td><?php echo $tools->get_transient_expiration( $row ); ?></td>
                        <td>
                            <a href="<?php echo esc_url( $delete_url ); ?>" class="delete" style="color:#a00;"><?php _e( 'Delete', 'pw-transients-manager' ); ?></a>
                        </td>
                    </tr>
                
                <?php endforeach; ?>
            </tbody>
        </table>
        
        <div style="margin-top: 5px;">
            <form method="post">
                <input type="hidden" name="action" value="delete_all_transients" />
                <input type="hidden" name="transient" value="all" />
                <?php wp_nonce_field( 'custom_untappd_feeds' ); ?>
                <input type="submit" class="button danger" value="<?php _e( 'Delete All', 'custom-untappd-feeds' ); ?>" />
            </form>
        </div>
        
    <?php else : ?>
      
        <p>No cached API calls.</p>
       
    <?php endif; ?>
        
    <h2>Change log, bugs and feature requests</h2>
    <p>Visit the Github repo for the latest builds, change logs, request features and report bugs. <a href="https://github.com/alexjustesen/custom-untappd-feeds" rel="nofollow" target="_blank">Github</a></p>
    
</div>
