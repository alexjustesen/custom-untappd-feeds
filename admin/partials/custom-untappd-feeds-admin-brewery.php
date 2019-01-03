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

require_once PLUGIN_PATH . 'includes/class-custom-untappd-feeds-api.php';
require_once PLUGIN_PATH . 'includes/class-custom-untappd-feeds-admin-tools.php';

$api = new Custom_Untappd_Feeds_API();
$tools = new Custom_Untappd_Feeds_Admin_Tools();

?>

<div class="tab-wrapper">
    
    <h4>Brewery Options</h4>

    <p>This section is coming soon, this is just a placeholder for information and settings.</p>
    
</div>
