<?php
/**
 * Template Main Functions
 * 
 */
// Define Variable In Theme
define("THEME_VER", '2.0');
define("THEME_DIR", get_template_directory());
define("THEME_URL", get_template_directory_uri());
define("THEME_CORE", THEME_DIR.'/core/');
define("THEME_OPTIONS", THEME_CORE.'options/');
define("THEME_URL_ASSETS", THEME_URL.'/assets/');
define("THEME_URL_LIBS", THEME_URL.'/assets/vendor/');
/*
* Class require all setting in themes
*/
require_once THEME_CORE.'theme-init.php';
