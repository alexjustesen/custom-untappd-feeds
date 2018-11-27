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
    
    /**
     * Transient prefix used to store cached data
     *
     * @since   2018.12
     * @access  protected
     * @var     string
     */
    protected $transient_prefix;
        
    public function __construct() {
        
        // Set API endpoint, current public api is version 4 - https required
        $this->api_endpoint = 'https://api.untappd.com/v4';
        
        // Set transient namespace
        $this->$transient_prefix = 'cuf_response_';
        
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
    
    /** api_url()
     * Build the api url string
     *
     * @since   2018.11
     * @access  private
     *
     * @param   $api_method string
     * @param   $api_params array
     *
     * @return  $url        string
     * @author  alexjustesen
     */
    private function api_url( $api_method, $api_params ) {
        
        // Merge query args into single array
        $args = array_merge( array( 'client_id' => $this->client_id, 'client_secret' => $this->client_secret ), $api_params );
        
        // Create api url with endpoint and method
        $url = $this->api_endpoint . $api_method;
        
        // Add api args to the api url
        $url = add_query_arg( $args, $url );
        
        // Return url
        return $url;
    }
    
    /** hash_name()
     *
     * @since   2018.11
     * @access  private
     * 
     * @param   $url    string
     *
     * @return  $hash   string
     * @author  alexjustesen
     */
    private function transient_name( $url ) {
        
        // Build a unique transient name
        $hash = $this->$transient_prefix . md5( $url );
                
        // Return name
        return $hash;
    }
    
    /**
     * Delete the transient cache record
     *
     * @since   2018.11
     */
    public function del_cache( $url ) {
        
        // Get transient name from url string
        $name = $this->transient_name( $url );
        
        // delete the cache
        $transient = delete_transient( $name ); // https://codex.wordpress.org/Function_Reference/delete_transient
        
        // Return transient
        return $transient;
    }
    
    /**
     * Set the transient cache record, Untappd requires the cache be cleared at least every 24h
     *
     * @since   2018.11
     */
    public function set_cache( $url, $value, $expiration=60*15 ) {
        
        // Get api cache timeout
        $api_settings = get_option( 'cuf_api_settings');
        
        if ( isset( $api_settings['cuf_cache_timeout'] ) ) {
            // Check if the value is numeric
            if ( is_numeric( $api_settings['cuf_cache_timeout'] ) ) {
                $expiration = $api_settings['cuf_cache_timeout'];
            }
            else {
                throw new Exception( 'CUF Cache Timeout is not a valid numeric value.' );
            }
        }
        
        // Get transient name from url string
        $name = $this->transient_name( $url );
        
        // set the cache value and expiration
        $transient = set_transient( $name, $value, $expiration ); // https://codex.wordpress.org/Function_Reference/set_transient
        
        // Return transient
        return $transient;
    }
    
    /**
     * Get the transient cache record
     *
     * @since   2018.11
     */
    public function get_cache( $url ) {
        
        // Get transient name from url string
        $name = $this->transient_name( $url );
        
        // get the cache name
        $transient = get_transient( $name ); // https://codex.wordpress.org/Function_Reference/get_transient
        
        // Return transient
        return $transient;
    }
    
    /**
     * Returns the http response from the api get call
     *
     * @since   2018.11
     * @access  public
     */
    public function get( $api_method, $api_params ) {
        
        // Get api url string
        $url = $this->api_url( $api_method, $api_params );
                
        // Search cache for a stored call
        $response = $this->get_cache( $url );
        
        // If cache is empty make a remote get call
        if ( $response === false ) {
            
            // Set API reponse to json var
            $response = wp_remote_request( $url );
            
            # TODO check response code, only cache successful calls
                        
            // Set cache of the API response
            $cache = $this->set_cache( $url, $response );
            
            # TODO capture any set cache errors
        }
        
        // Return response
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
        
        $url = $this->api_url( $api_method, $api_params );
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
