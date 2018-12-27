<?php

/**
 * Handles the html response for admin tool calls
 *
 * @link       https://www.alexjustesen.com
 * @since      2018.11
 *
 * @package    Custom_Untappd_Feeds
 * @subpackage Custom_Untappd_Feeds/includes
 
 */
class Custom_Untappd_Feeds_Admin_Tools {
    
    /**
	 * The api call object.
	 *
	 * @since    2018.11
	 * @access   private
	 * @var      string    $api    The api call object.
	 */
    private $api;
    
    /**
	 * The attributes of the shortcode.
	 *
	 * @since    2018.11
	 * @access   public
	 * @var      array    $atts    The attributes of the shortcode.
	 */
    public $atts = array();
    
    /**
	 * The HTML returned from the shortcode.
	 *
	 * @since    2018.11
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
     * Returns an array of cached API calls
     *
     * @since 2019.01
     */
    public function get_cache() {
        
        $results = array();
        
        // Init WordPress global database
        global $wpdb;
        
        $sql = "SELECT * FROM $wpdb->options WHERE option_name LIKE '%\_transient\_cuf\_%' AND option_name NOT LIKE '%\_transient\_timeout%'";
        
        $results = $wpdb->get_results( $sql );
        
        return $results;
        
    }
    
    public function get_transient_name( $transient ) {
		$length = false !== strpos( $transient->option_name, 'site_transient_' ) ? 16 : 11;
		return substr( $transient->option_name, $length, strlen( $transient->option_name ) );
	}
    
    private function get_transient_expiration_time( $transient ) {

		if( false !== strpos( $transient->option_name, 'site_transient_' ) ) {

			$time = get_option( '_site_transient_timeout_' . $this->get_transient_name( $transient ) );

		} else {

			$time = get_option( '_transient_timeout_' . $this->get_transient_name( $transient ) );

		}

		return $time;

	}
    
	public function get_transient_expiration( $transient ) {

		$time_now   = time();
		$expiration = $this->get_transient_expiration_time( $transient );

		if( empty( $expiration ) ) {
			return __( 'Does not expire', 'custom-untappd-feeds' );
		}

		if( $time_now > $expiration ) {
			return __( 'Expired', 'custom-untappd-feeds' );
		}
        
		return human_time_diff( $time_now, $expiration );

	}
    
}
