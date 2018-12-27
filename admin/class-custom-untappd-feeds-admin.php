<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       https://www.alexjustesen.com
 * @since      2018.11
 *
 * @package    Custom_Untappd_Feeds
 * @subpackage Custom_Untappd_Feeds/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Custom_Untappd_Feeds
 * @subpackage Custom_Untappd_Feeds/admin
 * @author     Alex Justesen <alex@alexjustesen.com>
 */
class Custom_Untappd_Feeds_Admin {

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
     * Message for the admin area
     *
     * @since   2019.01
     * @access  public
     * @var     array       $message
     */
    public $message;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    2018.11
	 * @param      string    $plugin_name       The name of this plugin.
	 * @param      string    $version    The version of this plugin.
	 */
    public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;
        
        add_action( 'admin_menu', array( $this, 'add_menu' ) );
        add_action( 'admin_init', array( $this, 'process_actions' ) );
        add_action( 'admin_init', array( $this, 'settings_page_init' ) );

	}
    
     public function add_menu() {
         add_menu_page(
            'Options',
            'Untappd Feeds',
            'manage_options',
            'custom-untappd-feeds',
            array( $this, 'create_options_page' ),
            '',
            99
        );

        add_submenu_page(
            'custom-untappd-feeds',
            'Documentation',
            'Documentation',
            'manage_options',
            'custom-untappd-feeds-documentation',
            array( $this, 'create_documentation_page' )
        );
         
        add_submenu_page(
            'custom-untappd-feeds',
            'About',
            'About',
            'manage_options',
            'custom-untappd-feeds-about',
            array( $this, 'create_about_page' )
        );
    }
    
    public function create_options_page() {
        
        require_once plugin_dir_path( __FILE__ ) . 'partials/custom-untappd-feeds-admin-settings.php';
        
    }
    
    public function create_documentation_page() {
        
        require_once plugin_dir_path( __FILE__ ) . 'partials/custom-untappd-feeds-admin-documentation.php';
        
    }
    
    public function create_about_page() {
        
        require_once plugin_dir_path( __FILE__ ) . 'partials/custom-untappd-feeds-admin-about.php';
        
    }
    
    public function process_actions() {
        if ( empty( $_REQUEST['action'] ) ) {
			return;
		}
        
        if ( empty( $_REQUEST['transient'] ) && ( 'suspend_transients' !== $_REQUEST['action'] && 'unsuspend_transients' !== $_REQUEST['action'] ) ) {
			return;
		}

		if ( ! current_user_can( 'manage_options' ) ) {
			return;
		}

		if ( ! wp_verify_nonce( $_REQUEST['_wpnonce'] , 'custom_untappd_feeds' ) ) {
			return;
		}
        
        $transient = $_REQUEST['transient'];
        $site_wide = isset( $_REQUEST['name'] ) && false !== strpos( $_REQUEST['name'], '_site_transient' );
        
        switch ( $_REQUEST['action'] ) {
            
            case 'delete_transient' :
				$this->delete_transient( $transient, $site_wide );
				wp_safe_redirect( admin_url( 'admin.php?page=custom-untappd-feeds-about' ) ); exit;
				break;
                
            case 'delete_all_transients' :
				$this->delete_all_transients();
				wp_safe_redirect( admin_url( 'admin.php?page=custom-untappd-feeds-about' ) ); exit;
				break;
        }
    }
    
	private function delete_transient( $transient = '', $site_wide = false ) {

		if ( empty( $transient ) ) {
			return false;
		}

		if ( false !== $site_wide ) {

			return delete_site_transient( $transient );

		} else {

			return delete_transient( $transient );

		}

	}

	private function delete_all_transients() {

		global $wpdb;

		$count = $wpdb->query( "DELETE FROM $wpdb->options WHERE option_name LIKE '%\_cuf\_response\_%'" );

		return $count;
	}
    
    public function api_section_text()
    {
        ?>
        <p>Before beginning you will need to register a new app with Untappd to get the required <code>Client ID</code> and <code>Client Secret</code> keys. To register a new app visit Untappd's <a href="https://untappd.com/api/register?register=new" target="_blank">API Central</a>.</p>
        <?php
    }
    
    public function blank_section_text()
    {
        // bothing here intentionally
    }
    
    public function settings_page_init() {
        
        register_setting(
            'cuf_api_settings', // name of the option that gets called in "get_option()"
            'cuf_api_settings', // matches the options name
            array( $this, 'validate_cuf_settings' ) // callback function to validate and clean data
        );

        add_settings_section(
            'cuf_api_settings', // matches the section name
            'API Settings',
            array( $this, 'api_section_text' ), // callback function to explain the section
            'cuf_api_settings' // matches the section name
        );
        
        /**
         * Field: Client ID
         */
        $this->create_settings_field( array(
            'name' => 'cuf_client_id',
            'title' => '<label for="cuf_client_id">Client ID</label>', // label for the input field
            'callback'  => 'default_field_text', // name of the function that outputs the html
            'page' => 'cuf_api_settings', // matches the section name
            'section' => 'cuf_api_settings', // matches the section name
            'option' => 'cuf_api_settings', // matches the options name
            'class' => 'cuf-api-settings', // class for the wrapper and input field
            'description' => '<i class="fas fa-exclamation-circle fa-fw"></i> Required field.', // describe the field
            'size' => '60',
        ) );
        
        /**
         * Field: Client Secret
         */
        $this->create_settings_field( array(
            'name' => 'cuf_client_secret',
            'title' => '<label for="cuf_client_secret">Client Secret</label>', // label for the input field
            'callback'  => 'default_field_text', // name of the function that outputs the html
            'page' => 'cuf_api_settings', // matches the section name
            'section' => 'cuf_api_settings', // matches the section name
            'option' => 'cuf_api_settings', // matches the options name
            'class' => 'cuf-api-settings', // class for the wrapper and input field
            'description' => '<i class="fas fa-exclamation-circle fa-fw"></i> Required field.', // describe the field
            'size' => '60',
        ) );
        
        /**
         * Field: API Cache Timeout
         */
        $this->create_settings_field( array(
            'name' => 'cuf_cache_timeout',
            'title' => '<label for="cuf_client_secret">API Cache Timeout</label>', // label for the input field
            'callback'  => 'default_field_text', // name of the function that outputs the html
            'page' => 'cuf_api_settings', // matches the section name
            'section' => 'cuf_api_settings', // matches the section name
            'option' => 'cuf_api_settings', // matches the options name
            'class' => 'cuf-api-settings', // class for the wrapper and input field
            'description' => 'The amount of time in seconds an API call is cached for. Default is 900 seconds or 15 minutes.', // describe the field
            'size' => '10',
            'type' => 'number',
            'default' => '900',
            'step' => '1',
            'min' => '0',
            'max' => '86400',
        ) );
        
    }
    
    public function default_field_text( $args )
    {
        $options = get_option( $args['option'] );
        $default = isset( $args['default'] ) ? $args['default'] : '';
        $option_string = ( isset( $options[ $args['name'] ] ) ) ? esc_attr( $options[ $args['name'] ] ) : $default;
        $type = ( isset( $args['type'] ) ) ? ' type="'. $args['type'].'"' : ' type="text"';
        $size = ( isset( $args['size'] ) ) ? ' size="'. $args['size'].'"' : '';
        $min = ( isset( $args['min'] ) ) ? ' min="'. $args['min'].'"' : '';
        $max = ( isset( $args['max'] ) ) ? ' max="'. $args['max'].'"' : '';
        $step = ( isset( $args['step'] ) ) ? ' step="'. $args['step'].'"' : '';
        ?>
        <input name="<?php echo $args['option'].'['.$args['name'].']'; ?>" id="cuf_<?php echo $args['name']; ?>" class="<?php echo $args['class']; ?>"<?php echo $type; ?><?php echo $size; ?><?php echo $min; ?><?php echo $max; ?><?php echo $step; ?> value="<?php echo $option_string; ?>" />
        <?php if ( isset( $args['example'] ) ) : ?>
            <span><?php echo $args['example']; ?></span>
        <?php endif; ?>
            <?php if ( isset( $args['description'] ) ) : ?>
            <p class="cuf-tooltip cuf-more-info"><?php _e( $args['description'], 'custom-untappd-feeds' ); ?></p>
        <?php endif; ?>
        <?php
    }
    
    public function create_settings_field( $args=array() )
    {
        add_settings_field(
            $args['name'],
            $args['title'],
            array( $this, $args['callback'] ),
            $args['page'],
            $args['section'],
            $args
        );
    }
    
    /**
     * Add a settings link to the plugin details in the plugins list.
     *
     * @since   2018.11
     */
    public function cuf_plugin_documentation_link( $links, $file ) {
        
        if ( $file == 'custom-untappd-feeds/custom-untappd-feeds.php' ) {
            /* Insert the link at the end*/
            $links['documentation'] = sprintf( '<a href="%s"> %s </a>', admin_url( 'admin.php?page=custom-untappd-feeds-documentation' ), __( 'Documentation', 'custom-untappd-feeds' ) );
        }
        return $links;
        
    }
    
    /**
     * Add a settings link to the plugin details in the plugins list.
     *
     * @since   2018.11
     */
    public function cuf_plugin_settings_link( $links, $file ) {
        
        if ( $file == 'custom-untappd-feeds/custom-untappd-feeds.php' ) {
            /* Insert the link at the end*/
            $links['settings'] = sprintf( '<a href="%s"> %s </a>', admin_url( 'admin.php?page=custom-untappd-feeds' ), __( 'Settings', 'custom-untappd-feeds' ) );
        }
        return $links;
        
    }
    
	/**
	 * Register the stylesheets for the admin area.
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
        
        wp_enqueue_style( 'font-awesome', 'https://use.fontawesome.com/releases/v5.6.3/css/all.css', array(), '5.6.3', 'all' );
        wp_enqueue_style( 'purecss', PLUGIN_URL . 'public/css/pure-release-1.0.0/pure-min.css', array(), '1.0.0', 'all' );
		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/custom-untappd-feeds-admin.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the admin area.
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
        
		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/custom-untappd-feeds-admin.js', array( 'jquery' ), $this->version, false );
	}

}
