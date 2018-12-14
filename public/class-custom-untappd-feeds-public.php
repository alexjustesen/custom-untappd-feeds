<?php

/**
 * The public-facing functionality of the plugin.
 *
 * @link       https://www.alexjustesen.com
 * @since      2018.11
 *
 * @package    Custom_Untappd_Feeds
 * @subpackage Custom_Untappd_Feeds/public
 */

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the public-facing stylesheet and JavaScript.
 *
 * @package    Custom_Untappd_Feeds
 * @subpackage Custom_Untappd_Feeds/public
 * @author     Alex Justesen <alex@alexjustesen.com>
 */
class Custom_Untappd_Feeds_Public {

	/**
	 * The ID of this plugin.
	 *
	 * @since    2018.11
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    2018.11
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;
    
    /**
	 * The shortcode object call.
	 *
	 * @since    2018.11
	 * @access   private
	 * @var      object    $shortcode    The shortcode object call.
	 */
	private $shortcode;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    2018.11
	 * @param      string    $plugin_name       The name of the plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;
        
	}
    
    /**
     * Register the shortcodes for the public-facing side of the site
     *
     * @since   2018.11
     */
    public function register_shortcodes() {
        
        add_shortcode( 'custom-untappd-feed', array($this, 'cuf_shortcode_init' ) );
        add_shortcode( 'custom-untappd-feeds', array($this, 'cuf_shortcode_init' ) );
        
    }
    
    /**
     * Initialize the shortcode html for the public-facing side of the site
     *
     * @since   2018.11
     */
    public function cuf_shortcode_init( $atts ) {
        
        // Set the shortcode object
        require_once PLUGIN_PATH . 'includes/class-custom-untappd-feeds-shortcodes.php';
        $this->shortcode = new Custom_Untappd_Feeds_Shortcodes( $atts );
        
        // Get the shortcode result
        $result = $this->shortcode->view( $atts );
        
        // Return the result
        return $result;
    }

	/**
	 * Register the stylesheets for the public-facing side of the site.
	 *
	 * @since    2018.11
	 */
	public function enqueue_styles() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Custom_Untappd_Feeds_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Custom_Untappd_Feeds_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */
        
        wp_enqueue_style( 'roboto', 'https://fonts.googleapis.com/css?family=Roboto:300,300i,400,400i,700,700i', array(), '1.0.0', 'all' );
        wp_enqueue_style( 'font-awesome', 'https://use.fontawesome.com/releases/v5.6.1/css/all.css', array(), '5.6.1', 'all' );
        wp_enqueue_style( 'purecss', PLUGIN_URL . 'public/css/pure-release-1.0.0/pure-min.css', array(), '1.0.0', 'all' );
		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/custom-untappd-feeds-public.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the public-facing side of the site.
	 *
	 * @since    2018.11
	 */
	public function enqueue_scripts() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Custom_Untappd_Feeds_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Custom_Untappd_Feeds_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */
        
		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/custom-untappd-feeds-public.js', array( 'jquery' ), $this->version, false );

	}

}
