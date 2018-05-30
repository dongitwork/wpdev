<?php
if ( ! defined( 'ABSPATH' ) ) {die('Kiss Me');}
class USAEV_PluginCore{
    public function __construct(){

        /* Include Custom Font Icon */
        require_once USAEV_INCLUDES . '/fontlibs/pe7stroke.php';
        require_once USAEV_INCLUDES . '/fontlibs/etline.php';
        require_once USAEV_INCLUDES . '/fontlibs/linearicons.php';


        /**
        * Init function, which is run on site init and plugin loaded
        */
        add_filter('style_loader_tag', array( $this, 'Smart_Addon_ValidateStylesheet'));
        
        /**
         * Enqueue Scripts on plugin
        */
        add_action('wp_enqueue_scripts', array( $this, 'Smart_Addon_Register_Script'));

        /**
         * Enqueue Scripts into Admin
         */
        add_action('admin_enqueue_scripts', array( $this, 'Smart_Addon_Admin_Script'));

        /**
        * Visual Composer action
        */
        add_action('vc_before_init', array($this, 'Smart_AddOn_ShortcodeRegister'));
        add_action('vc_after_init', array($this, 'Smart_AddOn_ShortcodeRegister'));

        /**
        * Widget text apply shortcode
        */
        add_filter('widget_text', 'do_shortcode');
    }

    /*
    * Smart AddOn Register Shortcode
    */
    function Smart_AddOn_ShortcodeRegister() {
        require_once USAEV_SHORTCODES . 'smart-shortcodes.php';
    }

    /**
    * Function register CSS or Js on plugin
    */
    public function Smart_Addon_Register_Script()
    {
        /* For CSS*/
        wp_register_style('font-stroke7', USAEV_CSS . 'Pe-icon-7-stroke.css', array(), '1.2.0');
        wp_register_style('font-etline', USAEV_CSS . 'et-line.css', array(), '1.0.0');
        wp_register_style('font-linearicons', USAEV_CSS . 'linearicons.css', array(), '1.0.0');

        wp_register_style('owl-css', USAEV_VENDOR . 'owl-carousel/owl.carousel.min.css', array(), 'v2.2');

        /* Base Plugin Css */
        wp_enqueue_style('sa-main-css', USAEV_CSS. 'sa-main.css');
        wp_enqueue_style('sa-responsive-css', USAEV_CSS. 'sa-responsive.css');

        /* For Js libs*/
        wp_register_script('modernizr', USAEV_VENDOR. 'jquery.modernizr.min.js', array('jquery'),'',true);
        wp_register_script('waypoints', USAEV_VENDOR. 'jquery.waypoints.min.js', array('waypoints'),'',true);
        wp_register_script('imagesloaded', USAEV_VENDOR. 'jquery.imagesloaded.js', array('imagesloaded'),'',true);
        wp_register_script('shuffle', USAEV_VENDOR . 'jquery.shuffle.js', array('jquery','modernizr','imagesloaded'),'',true);
        wp_register_script('owl-js', USAEV_VENDOR . 'owl-carousel/owl.carousel.min.js', array(),'v2.2',true);

        /* */
        wp_enqueue_script('sa-main-js', USAEV_JS.'main.js', array(),false,true);
    }

    /**
     * replace rel on stylesheet (Fix validator link style tag attribute)
     */
    function Smart_Addon_ValidateStylesheet($src) {
        if(strstr($src,'widget_search_modal-css')||strstr($src,'owl-carousel-css') || strstr($src,'vc_google_fonts')){
            return str_replace('rel', 'property="stylesheet" rel', $src);
        } else {
            return $src;
        }
    }


    /**
     * Register Scripts to admin
     */
    function Smart_Addon_Admin_Script(){
        wp_enqueue_style('font-stroke7');
        wp_enqueue_style('font-etline');
        wp_enqueue_style('font-linearicons');
    }
}

new USAEV_PluginCore();