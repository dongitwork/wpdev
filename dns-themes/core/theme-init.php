<?php 

/*
* Base class theme 
* add css and js theme support menu and widgets
*/
if (!class_exists( 'Fx_Base' ) ){
	require_once THEME_CORE.'class-flex-base.php';
}

/**
* Class custom post type and taxonomy
*/
if (!class_exists( 'Fx_Post' ) ){
	require_once THEME_CORE.'class-custom-post.php';
}

/*
* Class theme option 
* global $dns_options 
*/
if ( ! class_exists( 'ReduxFramework' ) ) {
	require_once( THEME_OPTIONS.'ReduxCore/framework.php');
	require_once( THEME_OPTIONS.'class-dns-options.php');
}
/**
 * My walker nav menu extends wp walker nav menu
 */
if (!class_exists('Fx_Walker_Nav_Menu')) {
	require_once THEME_CORE.'menu/class-flex-walker-nav.php';
}

/** Template functions */
require_once THEME_CORE. 'aq_resizer.php';
require_once THEME_CORE. 'template-functions.php';
require_once THEME_CORE. 'template-woocommerce.php';
require_once THEME_CORE. 'template-widget.php';
require_once THEME_CORE. 'woocommerce-shortcodes.php';
require_once THEME_CORE. 'template-shortcode.php';
require_once THEME_CORE. 'template-add_script.php';
