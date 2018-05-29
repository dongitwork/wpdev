<?php
/*
* Add new tracking field
* 'page_first => Page Seen First',
* 'page_total' => Page Total,
* 'page_last' =>  Page Seen Last,
* 'pip' => IP,
*/
class DNS_User_Tracking {
	protected static $page_max = 1000;
	public function __construct() {
		add_action( 'init', 'DNS_User_Tracking::compile_referer_session', 1 );
	}

	public static function compile_referer_session() {
		self::maybe_start_session();
		self::add_current_page_to_session();
		self::add_data_to_cookie();
	}

	private static function maybe_start_session() {
		if ( ! isset( $_SESSION ) ) {
			session_start();
		}
	}

	private static function add_current_page_to_session() {
		$current_url = self::get_server_value( 'REQUEST_URI' );
		
		if ( self::is_excluded_from_session( 'dns_http_pages' ) ) {
			$_SESSION['dns_http_pages'] = array( $current_url );
		}

		if ( ! empty( $_SESSION['dns_http_pages'] ) && $current_url != end( $_SESSION['dns_http_pages'] ) ) {
			$ext = substr( strrchr( substr( $current_url, 0, strrpos( $current_url, '?' ) ), '.' ), 1 );
			if ( ! in_array( $ext, array( 'css', 'js','php' ,'jpg','png') ) ) {
				if (strpos($current_url, 'wp-') === false) {
					$_SESSION['dns_http_pages'][] = $current_url;
				}
			}
		}
	}

	private static function is_excluded_from_session( $key ) {
		return ( ! self::is_included_in_session( $key ) || ! is_array( $_SESSION[ $key ] ) );
	}

	private static function is_included_in_session( $key ) {
		return isset( $_SESSION ) && isset( $_SESSION[ $key ] ) && $_SESSION[ $key ];
	}

	/**
     * Get any value from the $_SERVER
     *
     * @since 2.0
     * @param string $value
     * @return string
     */
	public static function get_server_value( $value ) {
        return isset( $_SERVER[ $value ] ) ? wp_strip_all_tags( $_SERVER[ $value ] ) : '';
    }

    /**
     * Check for the IP address in several places
     * Used by [ip] shortcode
     *
     * @return string The IP address of the current user
     */
    public static function get_ip_address() {
		$ip = '';
		foreach ( array( 'HTTP_CLIENT_IP', 'HTTP_X_FORWARDED_FOR', 'HTTP_X_FORWARDED', 'HTTP_X_CLUSTER_CLIENT_IP', 'HTTP_FORWARDED_FOR', 'HTTP_FORWARDED', 'REMOTE_ADDR' ) as $key ) {
            if ( ! isset( $_SERVER[ $key ] ) ) {
                continue;
            }

            foreach ( explode( ',', $_SERVER[ $key ] ) as $ip ) {
				$ip = trim( $ip ); // just to be safe

				if ( filter_var( $ip, FILTER_VALIDATE_IP, FILTER_FLAG_NO_PRIV_RANGE | FILTER_FLAG_NO_RES_RANGE ) !== false ) {
                    return sanitize_text_field( $ip );
                }
            }
        }

		return sanitize_text_field( $ip );
    }

    public function add_data_to_cookie()
    {	
    	if ( ! isset( $_SESSION ) ) {
			@session_start();
		}
    	$cookie_name = "dns_pages";
    	if (!empty($_SERVER['HTTPS']) && ('on' == $_SERVER['HTTPS'])) {
			$uri = 'https://';
		} else {
			$uri = 'http://';
		}
		$uri .= $_SERVER['HTTP_HOST'];
    	if (isset($_COOKIE[$cookie_name])) {
    		$cookie_value = stripslashes($_COOKIE[$cookie_name]);
    		$cookie_value = json_decode($cookie_value);
	    	if (isset($_SESSION['dns_http_pages'])) {
	    		$cookie_value->page_total = count($_SESSION['dns_http_pages']);
	    		$cookie_value->page_last = $uri.''.$_SESSION['dns_http_pages'][0];
	    		$cookie_value->pip = self::get_ip_address();
	    	}
	    	setcookie($cookie_name,json_encode($cookie_value),time()+(86400*30),"/");
    	}else{
    		$cookie_value = array();
    		if (isset($_SESSION['dns_http_pages'])) {
	    		$cookie_value['page_total'] = count($_SESSION['dns_http_pages']);
	    		$cookie_value['page_first'] = $uri.''.$_SESSION['dns_http_pages'][0];
	    		$cookie_value['page_last'] = $uri.''.$_SESSION['dns_http_pages'][0];
	    		$cookie_value['pip'] = self::get_ip_address();
	    	}
	    	setcookie($cookie_name,json_encode($cookie_value),time()+(86400*30),"/");
    	}
    	
    }

}
new DNS_User_Tracking();

