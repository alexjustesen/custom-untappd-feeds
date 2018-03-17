<?php

/**
 * The public-facing functionality of the plugin.
 *
 * @link       https://www.alexjustesen.com
 * @since      1.0.0
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
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $plugin_name       The name of the plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;
        
        add_shortcode( 'custom-untappd-feed', array($this, 'cuf_init' ) );
        add_shortcode( 'custom-untappd-feeds', array($this, 'cuf_init' ) );
        
	}
    
    public function cuf_init( $atts ) {
        
        require_once PLUGIN_PATH . 'includes/class-custom-untappd-feeds-shortcodes.php';
        
        $shortcodes = new Custom_Untappd_Feeds_Shortcodes( $atts );
        
        $html = $shortcodes->init( $atts );
                
        return $html;
    }

	/**
	 * Register the stylesheets for the public-facing side of the site.
	 *
	 * @since    1.0.0
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
        wp_enqueue_style( 'fontawesome-free', PLUGIN_URL . 'public/fonts/fontawesome-free-5.0.8/web-fonts-with-css/css/fontawesome-all.min.css', array(), '5.0.8', 'all' );
        wp_enqueue_style( 'purecss', PLUGIN_URL . 'public/css/pure-release-1.0.0/pure-min.css', array(), '1.0.0', 'all' );
		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/custom-untappd-feeds-public.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the public-facing side of the site.
	 *
	 * @since    1.0.0
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
        
        wp_enqueue_script( 'fontawesome-free', PLUGIN_URL . 'public/fonts/fontawesome-free-5.0.8/svg-with-js/js/fontawesome-all.min.js', array( 'jquery' ), '5.0.8', false );
        wp_enqueue_script( 'fontawesome-free-shims', PLUGIN_URL . 'public/fonts/fontawesome-free-5.0.8/svg-with-js/js/fa-v4-shims.min.js', array( 'jquery' ), '5.0.8', false );
		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/custom-untappd-feeds-public.js', array( 'jquery' ), $this->version, false );

	}

}
