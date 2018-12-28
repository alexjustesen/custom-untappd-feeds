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
?>

<div class="tab-wrapper">
    
    <form method="post" action="options.php">
        <?php settings_fields('cuf_api_settings'); // matches the options name ?>
        <?php do_settings_sections('cuf_api_settings'); // matches the section name ?>
        
        <p class="submit">
            <button type="submit" name="submit" id="submit" class="button-primary"><?php _e( 'Save Settings', 'custom-untappd-feeds' ); ?></button>
        </p>
        
    </form>
    
</div>
