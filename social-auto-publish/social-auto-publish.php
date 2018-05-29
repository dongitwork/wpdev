<?php
/**
 * Plugin Name: Social Auto Publish
 * Plugin URI:
 * Description: Publish posts automatically from your blog to social media.
 * Version: 2.0
 * Author: EastVN 
 * Author URI: eastvn.info 
 */
if( !defined('ABSPATH') ){ exit();}
define('SAP_FILE',__FILE__);
define( 'SAP_DIR', plugin_dir_path(__FILE__) );
define( 'SAP_URL', plugin_dir_url(__FILE__) );

require_once( SAP_DIR. '/api/twitteroauth.php' );
require_once( SAP_DIR. '/admin/menu.php' );
require_once( SAP_DIR. '/admin/publish.php' );