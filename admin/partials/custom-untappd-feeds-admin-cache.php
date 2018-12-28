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

<div class="tab-wrapper">
    
    <h4>Cached API Calls</h4>
    
    <?php if ( isset( $_REQUEST[ 'cache-cleared' ] ) == 'success' ) : ?>
    
        <div class="notice notice-success is-dismissible">
            <h4><?php _e( "The cache was successfully cleared.", 'custom-untappd-feeds' ); ?></h4>
        </div>
    
    <?php endif; ?>
    
    <?php if ( isset( $_REQUEST[ 'cache-removed' ] ) == 'success' ) : ?>
    
        <div class="notice notice-success is-dismissible">
            <h4><?php _e( "The cache item was successfully removed.", 'custom-untappd-feeds' ); ?></h4>
        </div>
    
    <?php endif; ?>
    
    <?php if ( $cache_results ) : ?>
    
        <p>Clear your cache if you have bad API responses or have changed your cache expiration time. WordPress will delete any expired cached items automatically.</p>
    
        <table class="wp-list-table widefat fixed posts">
            <thead>
                <tr>
                    <th style="width: 40px"><?php _e( 'ID', 'custom-untappd-feeds' ); ?></th>
                    <th><?php _e( 'Cache Hash', 'custom-untappd-feeds' ); ?></th>
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
                        <td>
                            <?php if ( $body['meta']['code'] == 200 ) : ?>
                                <i class="far fa-check-circle text-success" title="response code: <?php echo $body['meta']['code']; ?>"></i> good API response
                            <?php else : ?>
                                <i class="far fa-times-circle text-error" title="response code: <?php echo $body['meta']['code']; ?>"></i> bad API response
                            <?php endif; ?>
                        </td>
                        <td><?php echo $tools->get_transient_expiration( $row ); ?></td>
                        <td>
                            <a href="<?php echo esc_url( $delete_url ); ?>" class="delete" style="color:#a00;"><?php _e( 'Delete', 'custom-untappd-feeds' ); ?></a>
                        </td>
                    </tr>
                
                <?php endforeach; ?>
            </tbody>
        </table>
        
        <div style="margin-top: 15px;">
            <form method="post">
                <input type="hidden" name="action" value="delete_all_transients" />
                <input type="hidden" name="transient" value="all" />
                <?php wp_nonce_field( 'custom_untappd_feeds' ); ?>
                <button type="submit" class="button button-secondary button-large delete"><i class="far fa-trash-alt"></i> <?php _e( 'Delete All', 'custom-untappd-feeds' ); ?></button>
            </form>
        </div>
        
    <?php else : ?>
      
        <p>No cached API calls.</p>
       
    <?php endif; ?>
    
</div>
