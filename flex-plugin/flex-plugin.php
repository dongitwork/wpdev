<?php
/**
* Plugin Name: Flex Plugin
* Plugin URI: 
* Description: Add-on For Visual Comporser plugin.
* Version: 2.0
* Author: Eastvn
* Copyright 2017.
*/

define( 'FL_DIR', plugin_dir_path(__FILE__) );
define( 'FL_URL', plugin_dir_url(__FILE__) );
define( 'FL_LIBRARIES', FL_DIR  . "libraries" . DIRECTORY_SEPARATOR );
define( 'FL_TEMPLATES', FL_DIR . "templates" . DIRECTORY_SEPARATOR );
define( 'FL_INCLUDES', FL_DIR . "includes" . DIRECTORY_SEPARATOR );

define( 'FL_CSS', FL_URL . "assets/css/" );
define( 'FL_JS', FL_URL . "assets/js/" );
define( 'FL_IMAGES', FL_URL . "assets/images/" );

/**
* Require functions on plugin
*/
require_once FL_INCLUDES . "init.php";