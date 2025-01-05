<?php

if (!defined('ABSPATH'))
    die('Restricted Access');

class JSVEHICLEMANAGERwpvmsession {

    public $sessionid;
    public $sessionexpire;
    private $sessiondata;
    private $datafor;

    function __construct( ) {
        // add_action( 'init', array($this , 'init') );
        $this->init();
    }

    function getSessionId(){
        return $this->sessionid;
    }

    function init(){
        if (isset($_COOKIE['_wpjsvm_session_'])) {
            $cookie = stripslashes($_COOKIE['_wpjsvm_session_']);
            $user_cookie = explode('/', $cookie);
            $this->sessionid = preg_replace("/[^A-Za-z0-9_]/", '', $user_cookie[0]);
            $this->sessionexpire = absint($user_cookie[1]);
            $this->nextsessionexpire = absint($user_cookie[2]);
            // Update options session expiration
            if (time() > $this->nextsessionexpire) {
                $this->jsvm_set_cookies_expiration();
            }
        } else {
            $sessionid = $this->jsvm_generate_id();
            $this->sessionid = $sessionid . get_option( '_wpjsvm_session_', 0 );
            $this->jsvm_set_cookies_expiration();
        }
        $this->jsvm_set_user_cookies();
        return $this->sessionid;
    }

    private function jsvm_set_cookies_expiration(){
        $this->sessionexpire = time() + (int)(30*60);
        $this->nextsessionexpire = time() + (int)(60*60);
    }

    private function jsvm_generate_id(){
        require_once( ABSPATH . 'wp-includes/class-phpass.php' );
        $hash = new PasswordHash( 16, false );

        return md5( $hash->get_random_bytes( 32 ) );
    }

    private function jsvm_set_user_cookies(){
        setcookie( '_wpjsvm_session_', $this->sessionid . '/' . $this->sessionexpire . '/' . $this->nextsessionexpire , $this->sessionexpire, COOKIEPATH, COOKIE_DOMAIN);
        $count = get_option( '_wpjsvm_session_', 0 );
        update_option( '_wpjsvm_session_', ++$count);
    }

}

?>
