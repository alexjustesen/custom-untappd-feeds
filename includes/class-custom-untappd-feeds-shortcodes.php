<?php

/**
 * Handles the HTML of the shortcode
 *
 * @link       https://www.alexjustesen.com
 * @since      2018.11
 *
 * @package    Custom_Untappd_Feeds
 * @subpackage Custom_Untappd_Feeds/includes
 */

class Custom_Untappd_Feeds_Shortcodes {
    
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
    
    /** __construct()
     * Entry point for shortcode view
     *
	 * @since    2018.11
	 * @access   public
	 * @var      array     $atts
	 */
    public function __construct( $atts ) {
        
        // Load the api class
        require_once PLUGIN_PATH . 'includes/class-custom-untappd-feeds-api.php';
        $this->api = new Custom_Untappd_Feeds_API();
        
        // Set shortcode attributes
        $this->atts = $atts;
        
    }
    
    /** view()
     * Processes which shortcode to render
     *
     * @since   2018.11
     * @access  public
     * @var     array       $atts
     */
    public function view() {
        
        if ( isset( $this->atts['view'] ) ) {
            
            switch ( $this->atts['view'] ) {
                    
                case 'user-activity':
                    
                    // Set activity limit if not set
                    $this->atts['limit'] = ( ! isset( $this->atts['limit'] ) || empty( $this->atts['limit'] ) ) ? '5' : $this->atts['limit'];
                    
                    // Get shortcode html
                    $this->html = $this->user_activity();
                    break;
                
                case 'user-badges':
                    // Set badge limit if not set
                    $this->atts['limit'] = ( ! isset( $this->atts['limit'] ) || empty( $this->atts['limit'] ) ) ? '12' : $this->atts['limit'];
                    
                    // Get shortcode html
                    $this->html = $this->user_badges();
                    break;
                
                case 'user-info':
                    
                    // Get shortcode html
                    $this->html = $this->user_info();
                    break;
                    
                case 'user-overview':
                    
                    // Set activity limit if not set
                    $this->atts['activity-limit'] = ( ! isset( $this->atts['activity-limit'] ) || empty( $this->atts['activity-limit'] ) ) ? '5' : $this->atts['activity-limit'];
                    
                    // Set badge limit if not set
                    $this->atts['badge-limit'] = ( ! isset( $this->atts['badge-limit'] ) || empty( $this->atts['badge-limit'] ) ) ? '12' : $this->atts['badge-limit'];
                    
                    // Get shortcode html
                    $this->html = $this->user_overview();
                    break;
                
                default:
                    
                    // Set error html
                    $this->html = '<i class="fas fa-exclamation-triangle fa-sm"></i> You loaded the Custom Untappd Feeds plugin but didn\'t provide a valid view, see the documentation to setup the shortcode.';
                    break;
            }
        
        } 
        else {
            
            // Set error html
            $this->html = '<i class="fas fa-exclamation-triangle fa-sm"></i> You loaded the Custom Untappd Feeds plugin but didn\'t provide a view attribute, see the documentation to setup the shortcode.';
        }
        
        // Return $this->html
        return $this->html;
    }
    
    /** user_activity()
     * Shortcode view to show the users recent checkins.
     *
     * @since   2018.11
     * @access  public
     */
    public function user_activity() {
        
        // Set html string variable
        $html = '';
        
        // Get user data
        $user = json_decode( $this->api->get_body( '/user/info/' . $this->atts['user'], array( 'compact' => 'true') ), true );
        $user = $user['response'];
        
        // Get checkin data
        $checkins = json_decode( $this->api->get_body( '/user/checkins/' . $this->atts['user'], array( 'limit' => $this->atts['limit'] ) ), true );
        $checkins = $checkins['response'];
        
        $html .= '<div class="cuf-shortcode-container">';
            $html .= $this->shortcode_header( $user );

            foreach( $checkins['checkins']['items'] as $checkin ) {
                $html .= '<hr class="faded">';
                $html .= '<div class="pure-g cuf-checkin">';
                    $html .= '<div class="pure-u-1-6"><img class="cuf-beer-label" src="' . $checkin['beer']['beer_label'] . '"></div>';
                    $html .= '<div class="pure-u-5-6">';
                        $html .= '<div class="pure-g cuf-checkin-info">';
                            $html .= '<div class="pure-u-1-1"><i class="fas fa-calendar fa-fw fa-sm"></i> <date>' . date('F j, Y', strtotime( $checkin['created_at'] ) ) . '</date></div>';
                        $html .= '</div>';
                        
                        $html .= '<p>';
                        if ( !empty( $checkin['checkin_comment'] ) ) {
                            $html .= $checkin['checkin_comment'] . ' - ';
                        }
                
                        $html .= 'Drank a ' . $checkin['beer']['beer_name'] . ' by <a href="' . $checkin['brewery']['contact']['url'] . '" target="_blank">' . $checkin['brewery']['brewery_name'] . '</a>.';
                        $html .= '</p>';
                        
                        if ( $checkin['badges']['count'] > 0 ) {
                            
                            $html .= '<div class="cuf-checkin-badges">';
                            
                            foreach( $checkin['badges']['items'] as $badge ) {
                                $html .= '<img class="cuf-checkin-badge" src="' . $badge['badge_image']['sm'] . '" title="' . $badge['badge_name'] . '">';
                            }
                            
                            $html .= '</div>';
                        }
                        
                        $html .= '<div class="pure-g cuf-checkin-info">';
                            $html .= '<div class="pure-u-1-3 text-center"><i class="fas fa-star fa-fw fa-sm"></i> ' . $checkin['rating_score'] . '</div>';
                            $html .= '<div class="pure-u-1-3 text-center"><i class="fas fa-comment fa-fw fa-sm"></i> ' . $checkin['comments']['count'] . '</div>';
                            $html .= '<div class="pure-u-1-3 text-center"><i class="fas fa-thumbs-up fa-fw fa-sm"></i> ' . $checkin['toasts']['count'] . '</div>';
                        $html .= '</div>';
                        
                    $html .= '</div>';
                $html .= '</div>';
            }
            
            $html .= '<hr class="faded">';
            $html .= $this->shortcode_footer( $user );
        $html .= '</div>';
        
        // Return $html
        return $html;
    }
    
    /** user_badges()
     * Shortcode view to show recent badges earned by the user.
     *
     * @since   2018.11
     * @access  public
     */
    public function user_badges() {
        
        // Set html string variable
        $html = '';
        
        // Get user data
        $user = json_decode( $this->api->get_body( '/user/info/' . $this->atts['user'], array( 'compact' => 'true') ), true );
        $user = $user['response'];
        
        // Get badges data
        $badges = json_decode( $this->api->get_body( '/user/badges/' . $this->atts['user'], array( 'limit' => $this->atts['limit'] ) ), true );
        $badges = $badges['response'];
        
        $html .= '<div class="cuf-shortcode-container">';
            $html .= $this->shortcode_header( $user );
            $html .= '<hr class="faded">';
            $html .= '<div class="pure-g text-center">';
                $html .= '<div class="pure-u-1 cuf-badges">';
                    foreach( $badges['items'] as $badge ){
                        $html .= '<img class="cuf-checkin-badge" src="' . $badge['media']['badge_image_sm'] . '" title="' . $badge['badge_name'] . '">';
                    }
                $html .= '</div>';
            $html .= '</div>';
            $html .= '<hr class="faded">';
            $html .= $this->shortcode_footer( $user );
        $html .= '</div>';
        
        // Return $html
        return $html;
    }
    
    /** user_info()
     * Shortcode view to show the users basic profile stats
     *
     * @since   2018.11
     * @access  public
     */
    public function user_info() {
        
        // Set html string variable
        $html = '';
        
        // Get user data
        $user = json_decode( $this->api->get_body( '/user/info/' . $this->atts['user'], array( 'compact' => 'true') ), true );
        $user = $user['response'];
        
        $html .= '<div class="cuf-shortcode-container">';
            $html .= $this->shortcode_header( $user );
            $html .= '<hr class="faded">';
            $html .= '<div class="pure-g cuf-user-stats text-center">';
                $html .= '<div class="pure-u-1-4"><label>Total</label><span class="stat">' . number_format( $user['user']['stats']['total_checkins'], 0, '', ',' ) . '</span></div>';
                $html .= '<div class="pure-u-1-4"><label>Unique</label><span class="stat">' . number_format( $user['user']['stats']['total_beers'], 0, '', ',' ) . '</span></div>';
                $html .= '<div class="pure-u-1-4"><label>Badges</label><span class="stat">' . number_format( $user['user']['stats']['total_badges'], 0, '', ',' ) . '</span></div>';
                $html .= '<div class="pure-u-1-4"><label>Friends</label><span class="stat">' . number_format( $user['user']['stats']['total_friends'], 0, '', ',' ) . '</span></div>';
            $html .= '</div>';
            $html .= '<hr class="faded">';
            $html .= $this->shortcode_footer( $user );
        $html .= '</div>';
        
        // Return $html
        return $html;
    }
    
    /** user_overview()
     * Shortcode view to show the users basic profile stats, recent activity and recently earned badges.
     *
     * @since   2018.12
     * @access  public
     */
    public function user_overview() {
        
        // Set html string variable
        $html = '';
        
        // Get user data
        $user = json_decode( $this->api->get_body( '/user/info/' . $this->atts['user'], array( 'compact' => 'true') ), true );
        $user = $user['response'];
        
        // Get badges data
        $badges = json_decode( $this->api->get_body( '/user/badges/' . $this->atts['user'], array( 'limit' => $this->atts['badge-limit'] ) ), true );
        $badges = $badges['response'];
        
        // Get checkin data
        $checkins = json_decode( $this->api->get_body( '/user/checkins/' . $this->atts['user'], array( 'limit' => $this->atts['activity-limit'] ) ), true );
        $checkins = $checkins['response'];
        
        $html .= '<div class="cuf-shortcode-container">';
        
            // Shortcode header
            $html .= $this->shortcode_header( $user );
            
            // User info
            $html .= '<hr class="faded">';
            $html .= '<div class="pure-g cuf-user-stats text-center">';
                $html .= '<div class="pure-u-1-4"><label>Total</label><span class="stat">' . number_format( $user['user']['stats']['total_checkins'], 0, '', ',' ) . '</span></div>';
                $html .= '<div class="pure-u-1-4"><label>Unique</label><span class="stat">' . number_format( $user['user']['stats']['total_beers'], 0, '', ',' ) . '</span></div>';
                $html .= '<div class="pure-u-1-4"><label>Badges</label><span class="stat">' . number_format( $user['user']['stats']['total_badges'], 0, '', ',' ) . '</span></div>';
                $html .= '<div class="pure-u-1-4"><label>Friends</label><span class="stat">' . number_format( $user['user']['stats']['total_friends'], 0, '', ',' ) . '</span></div>';
            $html .= '</div>';
            
            // User badges
            $html .= '<hr class="faded">';
            $html .= '<div class="pure-g text-center">';
                $html .= '<div class="pure-u-1 cuf-badges">';
                    foreach( $badges['items'] as $badge ){
                        $html .= '<img class="cuf-checkin-badge" src="' . $badge['media']['badge_image_sm'] . '" title="' . $badge['badge_name'] . '">';
                    }
                $html .= '</div>';
            $html .= '</div>';
            
            // User activity
            foreach( $checkins['checkins']['items'] as $checkin ) {
                $html .= '<hr class="faded">';
                $html .= '<div class="pure-g cuf-checkin">';
                    $html .= '<div class="pure-u-1-6"><img class="cuf-beer-label" src="' . $checkin['beer']['beer_label'] . '"></div>';
                    $html .= '<div class="pure-u-5-6">';
                        $html .= '<div class="pure-g cuf-checkin-info">';
                            $html .= '<div class="pure-u-1-1"><i class="fas fa-calendar fa-fw fa-sm"></i> <date>' . date('F j, Y', strtotime( $checkin['created_at'] ) ) . '</date></div>';
                        $html .= '</div>';
                        
                        $html .= '<p>';
                        if ( !empty( $checkin['checkin_comment'] ) ) {
                            $html .= $checkin['checkin_comment'] . ' - ';
                        }
                
                        $html .= 'Drank a ' . $checkin['beer']['beer_name'] . ' by <a href="' . $checkin['brewery']['contact']['url'] . '" target="_blank">' . $checkin['brewery']['brewery_name'] . '</a>.';
                        $html .= '</p>';
                        
                        if ( $checkin['badges']['count'] > 0 ) {
                            
                            $html .= '<div class="cuf-checkin-badges">';
                            
                            foreach( $checkin['badges']['items'] as $badge ) {
                                $html .= '<img class="cuf-checkin-badge" src="' . $badge['badge_image']['sm'] . '" title="' . $badge['badge_name'] . '">';
                            }
                            
                            $html .= '</div>';
                        }
                        
                        $html .= '<div class="pure-g cuf-checkin-info">';
                            $html .= '<div class="pure-u-1-3 text-center"><i class="fas fa-star fa-fw fa-sm"></i> ' . $checkin['rating_score'] . '</div>';
                            $html .= '<div class="pure-u-1-3 text-center"><i class="fas fa-comment fa-fw fa-sm"></i> ' . $checkin['comments']['count'] . '</div>';
                            $html .= '<div class="pure-u-1-3 text-center"><i class="fas fa-thumbs-up fa-fw fa-sm"></i> ' . $checkin['toasts']['count'] . '</div>';
                        $html .= '</div>';
                        
                    $html .= '</div>';
                $html .= '</div>';
            }
        
            // Shortcode footer
            $html .= '<hr class="faded">';
            $html .= $this->shortcode_footer( $user );
        
        $html .= '</div>';
        
        // Return $html
        return $html;
        
        // Return $html
        return $html;
    }
    
    /** shortcode_header()
     * Shortcode partial to generate a standard header
     *
     * @since   2018.11
     * @access  protected
     */
    protected function shortcode_header( $user ) {
        $html .= '<div class="pure-g cuf-user-header">';
            $html .= '<div class="pure-u-5-24 cuf-user-avatar-container">';
                $html .= '<img class="pure-img cuf-user-avatar" src="' . $user['user']['user_avatar'] . '">';
                if ( $user['user']['is_supporter'] ) {
                    $html .= '<span class="cuf-user-is-supporter" title="Untappd Supporter"><i class="fas fa-certificate fa-lg"></i></span>';
                }
            $html .= '</div>';
            $html .= '<div class="pure-u-19-24 cuf-user-info-container">';
                $html .= '<span class="cuf-user-name">' . $user['user']['first_name'] . ' ' . $user['user']['last_name'] . '</span>';
                $html .= '<span class="cuf-user-username"><i class="fas fa-user fa-fw fa-sm"></i> ' . $user['user']['user_name'] . '</span>';
                $html .= '<span class="cuf-user-location"><i class="fas fa-map-marker fa-fw fa-sm"></i> ' . $user['user']['location'] . '</span>';
            $html .= '</div>';
        $html .= '</div>';
        
        // Return $html
        return $html;
    }
    
    /** shortcode_footer()
     * Shortcode partial to generate a standard footer
     *
     * @since   2018.11
     * @access  protected
     */
    protected function shortcode_footer( $user ) {
        $html = '<div class="cuf-footer text-center">';
        
            $html .= '<a href="' . $user['user']['untappd_url'] . '" target="_blank" title="Untappd.com"><i class="fab fa-untappd fa-lg"></i></a>';
        
        $html .= '</div>';
        
        // Return $html
        return $html;
    }
    
}
