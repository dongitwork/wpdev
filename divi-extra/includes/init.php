<?php

require_once DE_INCLUDES . "functions.php";
// DE_Builder
class Divi_Extra_Plugin{
    var $builder = array('image_text'=>'Module Name');
    function __construct(){
        add_action('wp_enqueue_scripts',array($this, 'divi_extra_add_scripts'));
        add_action('et_builder_ready',array($this, 'divi_extra_builder'));
    }

    public function divi_extra_add_scripts()
    {
        global $wp_scripts;
        wp_enqueue_script('jquery');

        wp_enqueue_script('divi-extra-jd', DE_JS.'divi-extra.js', array(),false,true);
        wp_enqueue_style('divi-extra-css', DE_CSS.'divi-extra.css', array(),'2.0'); 
    }

    public function divi_extra_builder()
    {
        if ( ! class_exists( 'ET_Builder_Module' ) ) { return; }
        if (is_array($this->builder)) {
            foreach ($this->builder as $file => $name) {
                $filename = DE_Builder.''.$file.'.php';
                if (file_exists($filename)) {
                    include $filename;
                }
            }
        }
    }
}

new Divi_Extra_Plugin();