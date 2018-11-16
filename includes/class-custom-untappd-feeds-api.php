<?php

class Custom_Untappd_Feeds_API {
    
    /**
     * The URL endpoint of the Untappd API
     *
     * @since   2018.11
     * @access  protected
     * @var     string
     */
    protected $api_endpoint;
    
    /**
     * The Client ID of the Untappd API App
     *
     * @since   2018.11
     * @access  protected
     * @var     string
     */
    protected $client_id;
    
    /**
     * The Client Secret of the Untappd API App
     *
     * @since   2018.11
     * @access  protected
     * @var     string
     */
    protected $client_secret;
        
    public function __construct() {
        
        // Set API endpoint, current public api is version 4 - https required
        $this->api_endpoint = 'https://api.untappd.com/v4';
        
        // Get Custom Untappd Feed API option data
        $option = get_option( 'cuf_api_settings' );
                
        // Check that the client id is set and not empty and if so set client_id
        if ( isset( $option['cuf_client_id'] ) && !empty( $option['cuf_client_id'] ) ) {
            $this->client_id = $option['cuf_client_id'];
        } else {
            $this->client_id = FALSE;
        }
        
        // Check that the client secret is set and not empty and if so set client_secret
        if ( isset( $option['cuf_client_secret'] ) && !empty( $option['cuf_client_secret'] ) ) {
            $this->client_secret = $option['cuf_client_secret'];
        } else {
            $this->client_secret = FALSE;
        }
        
    }
    
    /**
     * Build the api url string
     *
     * @since   2018.11
     * @access  public
     */
    public function build_url( $api_method, $api_params ) {
        
        $url = $this->api_endpoint . $api_method . '?client_id=' . $this->client_id . '&client_secret=' . $this->client_secret;
        
        if ( !empty( is_array( $api_params ) ) ) {
            foreach( $api_params as $key => $value ){
                $url .= '&' . $key . '=' . $value;
            }
        }
        
        return $url;
    }
    
    /**
     * Delete the transient cache record
     *
     * @since   2018.11
     */
    public function del_cache( $name ) {
        
        // delete the cache
        $transient = delete_transient( $name ); // https://codex.wordpress.org/Function_Reference/delete_transient
        
        return $transient;
    }
    
    /**
     * Get the transient cache record
     *
     * @since   2018.11
     */
    public function get_cache( $name ) {
        
        // get the cache name
        $transient = get_transient( $name ); // https://codex.wordpress.org/Function_Reference/get_transient
        
        return $transient;
    }
    
    /**
     * Set the transient cache record
     *
     * @since   2018.11
     */
    public function set_cache( $name, $value, $expiration=60*15 ) {
        
        // set the cache value and expiration
        $transient = set_transient( $name, $value, $expiration ); // https://codex.wordpress.org/Function_Reference/set_transient
        
        return $transient;
    }
    
    /**
     * Returns the http response from the api get call
     *
     * @since   2018.11
     * @access  public
     */
    public function get( $api_method, $api_params ) {
        
        // Build API url string
        $url = $this->build_url( $api_method, $api_params );
        
        $response = $this->get_cache( $url );
                
        if ( $response === false ) {
            
            // Set API reponse to json var
            $response = wp_remote_get( $url );
            
            // Set cache of the API response
            $cache = $this->set_cache( $url, $response );
        }
        
        return $response;
    }
    
    public function get_body( $api_method, $api_params ) {
        
        $response = $this->get( $api_method, $api_params );
        
        return $response['body'];
    }
    
    /**
     * Returns the http response code only from the api get call
     *
     * @since   2018.11
     * @access  public
     */
    public function get_code( $api_method, $api_params ) {
        
        $url = $this->build_url( $api_method, $api_params );
        $http_code = wp_remote_retrieve_response_code(  wp_remote_get( $url ) );
        
        return $http_code;
    }
    
    /**
     * Returns the http response headers only from the api get call
     *
     * @since   2018.11
     * @access  public
     */
    public function get_headers( $api_method, $api_params ) {
        
        $response = $this->get( $api_method, $api_params );
        
        return $response['headers'];
    }
    
}
