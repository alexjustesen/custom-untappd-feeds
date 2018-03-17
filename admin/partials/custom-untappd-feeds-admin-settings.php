<?php

/**
 * Provide a admin area view for the plugin
 *
 * This file is used to markup the admin-facing aspects of the plugin.
 *
 * @link       https://www.alexjustesen.com
 * @since      1.0.0
 *
 * @package    Custom_Untappd_Feeds
 * @subpackage Custom_Untappd_Feeds/admin/partials
 */
?>

<!-- This file should primarily consist of HTML with a little bit of PHP. -->

<div class="wrap">
   
    <h1><i class="fab fa-untappd fa-fw"></i> Custom Untappd Feeds <small>- Settings</small></h1>
    
    <form method="post" action="options.php">
        <?php settings_fields('cuf_api_settings'); // matches the options name ?>
        <?php do_settings_sections('cuf_api_settings'); // matches the section name ?>
        
        <p class="submit">
            <input type="submit" name="submit" id="submit" class="button button-primary" value="Save Changes">
        </p>
        
    </form>
    
</div>
