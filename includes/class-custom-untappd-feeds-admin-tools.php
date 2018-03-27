<?php

/**
 * Handles the html response for admin tool calls
 *
 * @link       https://www.alexjustesen.com
 * @since      1.0.0
 *
 * @package    Custom_Untappd_Feeds
 * @subpackage Custom_Untappd_Feeds/includes
 
 */
class Custom_Untappd_Feeds_Admin_Tools {
    
    /**
	 * The api call object.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $api    The api call object.
	 */
    private $api;
    
    /**
	 * The attributes of the shortcode.
	 *
	 * @since    1.0.0
	 * @access   public
	 * @var      array    $atts    The attributes of the shortcode.
	 */
    public $atts = array();
    
    /**
	 * The HTML returned from the shortcode.
	 *
	 * @since    1.0.0
	 * @access   public
	 * @var      string    $html    The HTML returned from the shortcode.
	 */
    public $html;
    
    
    public function __construct() {
        
        // Load the api class
        require_once PLUGIN_PATH . 'includes/class-custom-untappd-feeds-api.php';
        $this->api = new Custom_Untappd_Feeds_API();
        
    }
    
    /**
     * Displays all cached api calls.
     *
     * @since   1.0.0
     */
    public function view_cache() {
        $this->html = '';
        
        global $wpdb;
        $sql = "SELECT `option_name` as `name`, `option_value` as `value` 
            FROM $wpdb->options 
            WHERE `option_name` LIKE '%api.untappd.com%'";
        
        $results = $wpdb->get_results( $sql );
        
        $transients = array();
        
        $this->html = $results;
        
        return $this->html;
    }
    
}
