<?php
/**
* Plugin Name: DiVi Extra
* Plugin URI: #
* Description: Add-on For Divi.
* Version: 2.0
* Author: duydongit 
* Copyright 2017
*/

define( 'DE_DIR', plugin_dir_path(__FILE__) );
define( 'DE_URL', plugin_dir_url(__FILE__) );
define( 'DE_INCLUDES', DE_DIR ."includes/");
define( 'DE_Builder', DE_DIR ."builder/");
define( 'DE_CSS', DE_URL . "assets/css/" );
define( 'DE_JS', DE_URL . "assets/js/" );
define( 'DE_IMAGES', DE_URL . "assets/images/" );

/**
* Require functions on plugin
*/
require_once DE_INCLUDES . "init.php";