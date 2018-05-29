<?php

require_once FL_INCLUDES . "functions.php";

class FlPluginCore{
    public function __construct(){
        /**
        * Init function, which is run on site init and plugin loaded
        */
        add_filter('style_loader_tag', array( $this, 'flValidateStylesheet'));
        
        /**
        * Enqueue Scripts on plugin
        */
        add_action('wp_enqueue_scripts', array( $this, 'fl_register_style'));
        add_action('wp_enqueue_scripts', array( $this, 'fl_register_script'));
        /**
         * Enqueue Scripts into Admin
         */
        add_action('admin_enqueue_scripts', array( $this, 'fl_register_style'));
        add_action('admin_enqueue_scripts', array( $this, 'fl_admin_script'));

        /**
        * Visual Composer action
        */
        add_action('vc_before_init', array($this, 'flShortcodeRegister'));
        add_action('vc_after_init', array($this, 'flShortcodeAddParams'));

        /**
        * widget text apply shortcode
        */
        add_filter('widget_text', 'do_shortcode');
    }

    function flShortcodeRegister() {
        require_once FL_INCLUDES . 'fl_shortcodes.php';
    }

    /**
     * Add Shortcode Params
     */
    function flShortcodeAddParams(){
        $extra_params_folder = get_template_directory() . '/vc_params';
        $files = flFileScanDirectory($extra_params_folder,'/^fl_.*\.php/');
        if(!empty($files)){
            foreach($files as $file){
                if(WPBMap::exists($file->name)){
                    include $file->uri;
                    if(isset($params) && is_array($params)){
                        foreach($params as $param){
                            if(is_array($param)){
                                $param['group'] = __('Template', 'flex-theme');
                                $param['edit_field_class'] = isset($param['edit_field_class'])? $param['edit_field_class'].' fl_custom_param vc_col-sm-12 vc_column':'fl_custom_param vc_col-sm-12 vc_column';
                                $param['class'] = 'fl-extra-param';
                                if(isset($param['template']) && !empty($param['template'])){
                                    if(!is_array($param['template'])){
                                        $param['template'] = array($param['template']);
                                    }
                                    $param['dependency'] = array("element"=>"fl_template", "value" => $param['template']);

                                }
                                vc_add_param($file->name, $param);
                            }
                        }
                    }
                }
            }
        }
    }
    /**
    * Function register stylesheet on plugin
    */
    function fl_register_style(){
        wp_enqueue_style('fl-plugin-stylesheet', FL_CSS. 'fl-style.css');
        wp_register_style('fltheme-font-stroke7', FL_CSS . 'Pe-icon-7-stroke.css', array(), '1.2.0');
        wp_register_style('fltheme-font-etline', FL_CSS . 'et-line.css', array(), '1.0.0');
        wp_register_style('fltheme-font-linearicons', FL_CSS . 'linearicons.css', array(), '1.0.0');

        $mobile = (strstr($_SERVER['HTTP_USER_AGENT'],'Android') || strstr($_SERVER['HTTP_USER_AGENT'],'webOS') || strstr($_SERVER['HTTP_USER_AGENT'],'iPhone') ||strstr($_SERVER['HTTP_USER_AGENT'],'iPod') || strstr($_SERVER['HTTP_USER_AGENT'],'iPad') || wp_is_mobile()) ? true : false;
        if($mobile){
            wp_dequeue_style('js_composer_front');
            wp_deregister_style('js_composer_front');
            wp_enqueue_style( 'FL_JS_composer_front',FL_CSS. 'js_composer.css');
        }
    }

    /**
     * replace rel on stylesheet (Fix validator link style tag attribute)
     */
    function flValidateStylesheet($src) {
        if(strstr($src,'widget_search_modal-css')||strstr($src,'owl-carousel-css') || strstr($src,'vc_google_fonts')){
            return str_replace('rel', 'property="stylesheet" rel', $src);
        } else {
            return $src;
        }
    }

    /**
    * Function register script on plugin
    */
    function fl_register_script(){
        wp_register_script('modernizr', FL_JS. 'modernizr.min.js', array('jquery'));
        wp_register_script('waypoints', FL_JS. 'waypoints.min.js', array('jquery'));
        wp_register_script('imagesloaded', FL_JS. 'jquery.imagesloaded.js', array('jquery'));
        wp_register_script('jquery-shuffle', FL_JS . 'jquery.shuffle.js', array('jquery','modernizr','imagesloaded'));
        wp_register_script('fl-jquery-shuffle', FL_JS. 'jquery.shuffle.fl.js', array('jquery-shuffle'));
        wp_register_script('fl-masonry', FL_JS. 'fl.masonry.js', array('jquery-shuffle', 'jquery-ui-resizable'));
        wp_register_script('fl-masonry-admin', FL_JS. 'fl.masonry.admin.js', array('fl-masonry'));
        wp_register_style('fl-jquery-ui', FL_CSS . 'jquery-ui.css', array(), '1.2.0');
    }

    /**
     * Register Scripts to admin
     */
    function fl_admin_script(){
        wp_enqueue_style('fltheme-font-stroke7');
        wp_enqueue_style('fltheme-font-etline');
        wp_enqueue_style('fltheme-font-linearicons');
    }
}

new FlPluginCore();