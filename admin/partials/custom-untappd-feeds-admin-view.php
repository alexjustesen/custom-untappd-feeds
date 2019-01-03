<?php

/**
 * Provide a admin area view for the plugin
 *
 * This file is used to markup the admin-facing aspects of the plugin.
 *
 * @link       https://www.alexjustesen.com
 * @since      2019.01
 *
 * @package    Custom_Untappd_Feeds
 * @subpackage Custom_Untappd_Feeds/admin/partials
 */

if ( isset( $_GET[ 'tab' ] ) ) {
    $active_tab = $_GET[ 'tab' ];
} else {
    $active_tab = 'settings';
}

?>

<div class="wrap">
    
    <span class="small alignright">Version: <?php echo PLUGIN_VERSION; ?></span>
    <h2>Custom Untappd Feeds </h2>
        
    <div class="nav-tab-wrapper">
        <a href="?page=custom-untappd-feeds&tab=settings" class="nav-tab <?php echo $active_tab == 'settings' ? 'nav-tab-active' : ''; ?>">Settings</a>
        <a href="?page=custom-untappd-feeds&tab=brewery" class="nav-tab <?php echo $active_tab == 'brewery' ? 'nav-tab-active' : ''; ?>">Brewery Options</a>
        <a href="?page=custom-untappd-feeds&tab=cache" class="nav-tab <?php echo $active_tab == 'cache' ? 'nav-tab-active' : ''; ?>">Cache</a>
        <a href="?page=custom-untappd-feeds&tab=documentation" class="nav-tab <?php echo $active_tab == 'documentation' ? 'nav-tab-active' : ''; ?>">Documentation</a>
    </div>
    
    <?php
        switch ( $active_tab ) {
            case 'brewery':
                // require tab partial
                require_once plugin_dir_path( __FILE__ ) . 'custom-untappd-feeds-admin-brewery.php';
                break;
                
            case 'cache':
                // require tab partial
                require_once plugin_dir_path( __FILE__ ) . 'custom-untappd-feeds-admin-cache.php';
                break;
            
            case 'documentation':
                // require tab partial
                require_once plugin_dir_path( __FILE__ ) . 'custom-untappd-feeds-admin-documentation.php';
                break;
                
            case 'settings':
                // require tab partial
                require_once plugin_dir_path( __FILE__ ) . 'custom-untappd-feeds-admin-settings.php';
                break;
        }
    ?>
    
</div>
