<?php
/**
* Plugin Name: Unlimited Smart Addons
* Plugin URI: https://eastvn.info
* Description: All in one for Your WPBakery Page Builder Needs!.
* Description: Drag and drop add-on page builder for WordPress.
* Version: 2.0
* Text Domain: smart-addon
* Author: EastVN
* Author URI: https://eastvn.info
* Copyright 2018.
*/

// don't load directly
if ( ! defined( 'ABSPATH' ) ) {die('Kiss Me');}

// Check SSL Mode
if ( isset( $_SERVER['HTTP_X_FORWARDED_PROTO'] ) && ( $_SERVER['HTTP_X_FORWARDED_PROTO'] === 'https' ) ) {
	$_SERVER['HTTPS'] = 'on';
}


/* Plugin All Constants*/
// ==================
// = Plugin Smart Addon Version =
// ==================
define( 'USAEV_VERSION', '2.0' );

// ===============
// = Plugin Name =
// ===============
define( 'USAEV_PLUGIN_NAME', 'Unlimited Smart Addons' );

// ===============
// = Plugin Path =
// ===============
define( 'USAEV_PATH', plugin_dir_path(__FILE__ ) );

// ===============
// = Plugin Url  =
// ===============
define( 'USAEV_URL', plugin_dir_url(__FILE__ ) );

// ===============
// = Plugin Libraries  =
// ===============
define( 'USAEV_LIBRARIES', USAEV_PATH  . "libraries" . DIRECTORY_SEPARATOR );


// ===============
// = Plugin Shortcodes  =
// ===============
define( 'USAEV_SHORTCODES', USAEV_PATH . "shortcodes" . DIRECTORY_SEPARATOR );

// ===============
// = Plugin Templates  =
// ===============
define( 'USAEV_TEMPLATES', USAEV_SHORTCODES . "templates" . DIRECTORY_SEPARATOR );

// ===============
// = Plugin Includes  =
// ===============
define( 'USAEV_INCLUDES', USAEV_PATH . "includes" . DIRECTORY_SEPARATOR );

// ===============
// = Plugin Css  =
// ===============
define( 'USAEV_CSS', USAEV_URL . "assets/css/" );

// ===============
// = Plugin Js  =
// ===============
define( 'USAEV_JS', USAEV_URL . "assets/js/" );

// ===============
// = Plugin Images  =
// ===============
define( 'USAEV_IMAGES', USAEV_URL . "assets/images/" );

// =================
// = Plugin Vendor =
// =================
define( 'USAEV_VENDOR', USAEV_URL . "assets/vendor/" );
/* End Constants*/


/**
* Require functions on plugin
*/
require_once USAEV_INCLUDES . "functions.php";

/**
* Require Init on plugin
*/
require_once USAEV_INCLUDES . "init.php";
