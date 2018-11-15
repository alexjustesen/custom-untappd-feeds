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

<div class="wrap">
    
    <h1><i class="fab fa-untappd fa-fw"></i> Custom Untappd Feeds <small>- Documentation</small></h1>
           
    <h2>How to Use</h2>
    <p>This plugin uses shortcodes, the base shortcode is <code>[custom-untappd-feeds]</code> and attributes are added to the shortcode for different views and settings. See the documenation below for configuration examples.</p>
        
    <h2>Views and Attributes</h2>
    <table class="pure-table pure-table-bordered">
        
        <thead>
            <tr>
                <th>View</th>
                <th>Description</th>
                <th>Attributes</th>
                <th>Example</th>
            </tr>
        </thead>
        
        <tbody>
           
            <tr>
                <td>
                    <code>user-activity</code>
                </td>
                <td>
                    <p>Shows a list of recent checkins for the specified username.</p>
                </td>
                <td>
                    <ul class="fa-ul">
                        <li><span class="fa-li"><i class="fas fa-check-square"></i></span><strong><code>user='USERNAME'</code> - the username to get the user information for.</strong></li>
                        <li><span class="fa-li"><i class="far fa-square"></i></span><code>limit='#'</code> - returns the number of check-ins set. Default = 5 Max = 50</li>
                    </ul>
                </td>
                <td>
                    <code>[custom-untappd-feeds view='user-activity' user='USERNAME' limit='5']</code>
                </td>
            </tr>
            
            <tr>
                <td>
                    <code>user-badges</code>
                </td>
                <td>
                    <p>Shows a list of badges for the specified username.</p>
                </td>
                <td>
                    <ul class="fa-ul">
                        <li><span class="fa-li"><i class="fas fa-check-square"></i></span><strong><code>user='USERNAME'</code> - the username to get the user information for.</strong></li>
                        <li><span class="fa-li"><i class="far fa-square"></i></span><code>limit='#'</code> - returns the number of badges set, Default = 12 Max = 50</li>
                    </ul>
                </td>
                <td>
                    <code>[custom-untappd-feeds view='user-badges' user='USERNAME' limit='12']</code>
                </td>
            </tr>
            
            <tr>
                <td>
                    <code>user-info</code>
                </td>
                <td>
                    <p>Shows the specified username's profile information.</p>
                </td>
                <td>
                    <ul class="fa-ul">
                        <li><span class="fa-li"><i class="fas fa-check-square"></i></span><strong><code>user='USERNAME'</code> - the username to get the user information for.</strong></li>
                    </ul>
                </td>
                <td>
                    <code>[custom-untappd-feeds view='user-info' user='USERNAME']</code>
                </td>
            </tr>
            
        </tbody>
        
    </table>
    
    <ul class="fa-ul">
        <li><span class="fa-li"><i class="fas fa-check-square"></i></span><strong>Required attribute</strong></li>
        <li><span class="fa-li"><i class="far fa-square"></i></span>Optional attribute</li>
    </ul>
    
    <h2>API Caching</h2>
    <p>Untappd limits the amount of API requests to a maximum of 100 per rolling hour. To help avoid hitting this limit and to improve plugin performance we cache all API call results for 15 minutes.</p>
    
    <p><a href="https://untappd.com/api/docs" target="_blank">Untappd API Documentation</a> </p>
    
</div>
