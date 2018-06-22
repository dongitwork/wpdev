<?php
/*
*
* Folder assets Include all style css/js/images
* Folder assets Include Library
*
*/
define("THEME_VER", '2.0');
define("CORE_URL", get_template_directory_uri());
define("THEME_DIR", get_stylesheet_directory());
define("THEME_URL", get_stylesheet_directory_uri());
define("THEME_CORE", THEME_DIR.'/core/');
define("SA_Builder", THEME_DIR.'/core/builder/');
define("THEME_URL_ASSETS", THEME_URL.'/assets/');
define("THEME_URL_LIBS", THEME_URL.'/assets/vendor/');

/*
* Class require all setting in themes
*/
require_once THEME_CORE.'theme-init.php';



