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

require_once PLUGIN_PATH . 'includes/class-custom-untappd-feeds-admin-tools.php';
$tools = new Custom_Untappd_Feeds_Admin_Tools();

?>

<div class="wrap">
    
    <h1><i class="fab fa-untappd fa-fw"></i> Custom Untappd Feeds <small>- About This Plugin</small></h1>
    
    <h2>About</h2>
    <p>This is an unofficial Untappd WordPress plugin and released under the GNU GENERAL PUBLIC LICENSE with NO WARRANTEE.</p>
    
    <p>With <strong>Custom Untappd Feeds</strong> you can display your <a href="https://www.untappd.com" target="_blank">Untappd</a> user information, user activity feed and badges earned. To use this plugin check out the <a href="admin.php?page=custom-untappd-feeds-documentation" target="_self">documentation</a> for how to configure the sortcodes.</p>
    
    <h2>Cache results</h2>
    <p>
        <?php //print_r( $tools->view_cache() ); ?>
        hidden for now...
    </p>
    
    <h2>Change log</h2>
    <p>That'll come when v1 is "done", I'll use a .md to php plugin because I don't want to write it more than once.</p>
    
    
    
</div>
