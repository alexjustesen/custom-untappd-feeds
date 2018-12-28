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
              
    <h4>About the Plugin</h4>
    
    <p>With <strong>Custom Untappd Feeds</strong> you can display your <a href="https://www.untappd.com" rel="nofollow" target="_blank">Untappd</a> user information, user activity feed and badges earned. This is an unofficial Untappd WordPress plugin and released under the GNU GENERAL PUBLIC LICENSE with NO WARRANTEE.</p>
               
    <h4>How to Use</h4>
    
    <p>This plugin uses shortcodes so you can place the views in posts, pages or widgets. The base shortcode is <code>[custom-untappd-feeds]</code> and attributes are added to the shortcode for different views and view settings. See the documentation below for view and attribute examples.</p>
        
    <h4>Views and Attributes</h4>
    <table class="pure-table pure-table-bordered">
        
        <thead>
            <tr>
                <th>View</th>
                <th>Description</th>
                <th>Attributes</th>
                <th>Example</th>
                <th>As Of</th>
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
                <td>v2018.11</td>
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
                <td>v2018.11</td>
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
                <td>v2018.11</td>
            </tr>
            
            <tr>
                <td>
                    <code>user-overview</code>
                </td>
                <td>
                    <p>Combines the user info, badges and activity into one shortcode.</p>
                </td>
                <td>
                    <ul class="fa-ul">
                        <li><span class="fa-li"><i class="fas fa-check-square"></i></span><strong><code>user='USERNAME'</code> - the username to get the user information for.</strong></li>
                        <li><span class="fa-li"><i class="far fa-square"></i></span><code>activity-limit='#'</code> - returns the number of check-ins set. Default = 5 Max = 50</li>
                        <li><span class="fa-li"><i class="far fa-square"></i></span><code>badge-limit='#'</code> - returns the number of badges set, Default = 12 Max = 50</li>
                    </ul>
                </td>
                <td>
                    <code>[custom-untappd-feeds view='user-overview' user='USERNAME' activity-limit='5' badge-limit='12']</code>
                </td>
                <td>v2018.12</td>
            </tr>
            
        </tbody>
        
    </table>
    
    <ul class="fa-ul">
        <li><span class="fa-li"><i class="fas fa-check-square"></i></span><strong>Required attribute</strong></li>
        <li><span class="fa-li"><i class="far fa-square"></i></span>Optional attribute</li>
    </ul>
    
    <h4>API Caching</h4>
    <p>Untappd limits the amount of API requests to a maximum of 100 per rolling hour. To help avoid hitting this limit and to improve plugin performance we cache all API call results for a default of 15 minutes. You can change the amount of time data is cached for on the settings page. You can read more about Untappd's API in their <a href="https://untappd.com/api/docs" target="_blank">docs</a> and view and clear the cache on the <a href="?page=custom-untappd-feeds&tab=cache">cache</a> tab.</p>
    
    <h4>Change Log, Bugs and Feature Requests</h4>
    <p>Visit the Github repo for the latest builds, report bugs and request new features. <a href="https://github.com/alexjustesen/custom-untappd-feeds" rel="nofollow" target="_blank">Github</a></p>
    
</div>
