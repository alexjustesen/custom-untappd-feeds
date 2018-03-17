<?php

class Custom_Untappd_Feeds_Shortcodes {
    
    protected $api;
    protected $atts = array();
    protected $html;
    protected $params = array();
    
    public function __construct( $atts ) {
        require_once PLUGIN_PATH . 'includes/class-custom-untappd-feeds-api.php';
        
        $this->atts = $atts;
        $this->api = new Custom_Untappd_Feeds_API();
    }
    
    public function init() {
        
        if ( isset( $this->atts['view'] ) ) {
            
            switch ( $this->atts['view'] ) {
                    
                case 'user-activity':
                    $this->atts['limit'] = ( !isset( $this->atts['limit'] ) || empty( $this->atts['limit'] ) ) ? '5' : $this->atts['limit'];
                    $this->html = $this->user_activity();
                    break;
                
                case 'user-badges':
                    $this->atts['limit'] = ( !isset( $this->atts['limit'] ) || empty( $this->atts['limit'] ) ) ? '12' : $this->atts['limit'];
                    $this->html = $this->user_badges();
                    break;
                
                case 'user-info':
                    $this->html = $this->user_info();
                    break;
                
                default:
                    $this->html = '<i class="fas fa-exclamation-triangle fa-sm"></i> You loaded the Custom Untappd Feeds plugin but didn\'t provide a valid view, see the documentation to setup the shortcode.';
                    break;
            }
        
        } else {
            $this->html = '<i class="fas fa-exclamation-triangle fa-sm"></i> You loaded the Custom Untappd Feeds plugin but didn\'t provide a view attribute, see the documentation to setup the shortcode.';
        }
        
        return $this->html;
    }
    
    protected function cuf_header( $user ) {
        $html .= '<div class="pure-g cuf-user-header">';
            $html .= '<div class="pure-u-1-6 cuf-user-avatar-container">';
                $html .= '<img class="pure-img cuf-user-avatar" src="' . $user['user']['user_avatar'] . '">';
                if ( $user['user']['is_supporter'] ) {
                    $html .= '<span class="cuf-user-is-supporter" title="Untappd Supporter"><i class="fas fa-certificate fa-lg"></i></span>';
                }
            $html .= '</div>';
            $html .= '<div class="pure-u-5-6">';
                $html .= '<span class="cuf-user-first-last">' . $user['user']['first_name'] . ' ' . $user['user']['last_name'] . '</span>';
                $html .= '<span class="cuf-user-username"><i class="fas fa-user fa-fw fa-sm"></i> ' . $user['user']['user_name'] . '</span>';
                $html .= '<span class="cuf-user-location"><i class="fas fa-map-marker fa-fw fa-sm"></i> ' . $user['user']['location'] . '</span>';
            $html .= '</div>';
        $html .= '</div>';
        
        return $html;
    }
    
    protected function user_activity() {
        $html = '';
        $user = json_decode( $this->api->get_body( '/user/info/' . $this->atts['user'], array( 'compact' => 'true') ), true );
        $user = $user['response'];
        $checkins = json_decode( $this->api->get_body( '/user/checkins/' . $this->atts['user'], array( 'limit' => $this->atts['limit'] ) ), true );
        $checkins = $checkins['response'];
        
        $html .= '<div class="cuf-shortcode-container">';
            $html .= $this->cuf_header( $user );

            foreach( $checkins['checkins']['items'] as $checkin ) {
                $html .= '<hr class="faded">';
                $html .= '<div class="pure-g cuf-checkin">';
                    $html .= '<div class="pure-u-1-6"><img class="cuf-beer-label" src="' . $checkin['beer']['beer_label'] . '"></div>';
                    $html .= '<div class="pure-u-5-6">';
                        $html .= '<div class="pure-g cuf-checkin-info">';
                            $html .= '<div class="pure-u-10-24"><i class="fas fa-calendar fa-fw fa-sm"></i> <date>' . date('M j, Y', strtotime( $checkin['created_at'] ) ) . '</date></div>';
                            $html .= '<div class="pure-u-6-24 text-center"><i class="fas fa-star fa-fw fa-sm"></i> ' . $checkin['rating_score'] . '</div>';
                            $html .= '<div class="pure-u-4-24 text-center"><i class="fas fa-comment fa-fw fa-sm"></i> ' . $checkin['comments']['count'] . '</div>';
                            $html .= '<div class="pure-u-4-24 text-center"><i class="fas fa-thumbs-up fa-fw fa-sm"></i> ' . $checkin['toasts']['count'] . '</div>';
                        $html .= '</div>';
                        
                        $html .= '<p>';
                        if ( !empty( $checkin['checkin_comment'] ) ) {
                            $html .= $checkin['checkin_comment'] . ' - ';
                        }
                
                        $html .= 'Drank a ' . $checkin['beer']['beer_name'] . ' by <a href="' . $checkin['brewery']['contact']['url'] . '" target="_blank">' . $checkin['brewery']['brewery_name'] . '</a>';
                        $html .= '</p>';
                        
                        foreach( $checkin['badges']['items'] as $badge ) {
                            $html .= '<img class="cuf-checkin-badge" src="' . $badge['badge_image']['sm'] . '" title="' . $badge['badge_name'] . '">';
                        }
                        
                    $html .= '</div>';
                $html .= '</div>';
            }
            
            $html .= '<hr class="faded">';
            $html .= '<p class="text-center"><a href="' . $user['user']['untappd_url'] . '" target="_blank" title="Untappd.com"><i class="fab fa-untappd fa-lg"></i></a></p>';
        $html .= '</div>';
        
        return $html;
    }
    
    protected function user_badges() {
        $html = '';
        $user = json_decode( $this->api->get_body( '/user/info/' . $this->atts['user'], array( 'compact' => 'true') ), true );
        $user = $user['response'];
        $badges = json_decode( $this->api->get_body( '/user/badges/' . $this->atts['user'], array( 'limit' => $this->atts['limit'] ) ), true );
        $badges = $badges['response'];
        
        $html .= '<div class="cuf-shortcode-container">';
            $html .= $this->cuf_header( $user );
            $html .= '<hr class="faded">';
            $html .= '<div class="pure-g text-center">';
                $html .= '<div class="pure-u-1 cuf-badges">';
                    foreach( $badges['items'] as $badge ){
                        $html .= '<img class="cuf-checkin-badge" src="' . $badge['media']['badge_image_sm'] . '" title="' . $badge['badge_name'] . '">';
                    }
                $html .= '</div>';
            $html .= '</div>';
            $html .= '<hr class="faded">';
            $html .= '<p class="text-center"><a href="' . $user['user']['untappd_url'] . '" target="_blank" title="Untappd.com"><i class="fab fa-untappd fa-lg"></i></a></p>';
        $html .= '</div>';
            
        return $html;
    }
    
    protected function user_info() {
        $html = '';
        $user = json_decode( $this->api->get_body( '/user/info/' . $this->atts['user'], array( 'compact' => 'true') ), true );
        $user = $user['response'];
        
        $html .= '<div class="cuf-shortcode-container">';
            $html .= $this->cuf_header( $user );
            $html .= '<hr class="faded">';
            $html .= '<div class="pure-g cuf-user-stats text-center">';
                $html .= '<div class="pure-u-1-4"><label>Total</label><br/><span class="stat">' . $user['user']['stats']['total_checkins'] . '</span></div>';
                $html .= '<div class="pure-u-1-4"><label>Unique</label><br/><span class="stat">' . $user['user']['stats']['total_beers'] . '</span></div>';
                $html .= '<div class="pure-u-1-4"><label>Badges</label><br/><span class="stat">' . $user['user']['stats']['total_badges'] . '</span></div>';
                $html .= '<div class="pure-u-1-4"><label>Friends</label><br/><span class="stat">' . $user['user']['stats']['total_friends'] . '</span></div>';
            $html .= '</div>';
            $html .= '<hr class="faded">';
            $html .= '<p class="text-center"><a href="' . $user['user']['untappd_url'] . '" target="_blank" title="Untappd.com"><i class="fab fa-untappd fa-lg"></i></a></p>';
        $html .= '</div>';
            
        return $html;
    }
}
