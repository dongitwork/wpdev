<?php

vc_map(
    array(
        "name" => __("Smart Carousel", 'smart-addon'),
        "base" => "sa_vc_carousel",
        "class" => "sa-vc-carousel",
        "category" => __("Smart AddOn", 'smart-addon'),
        "params" => array(
            array(
                "type" => "dropdown",
                "heading" => __("Source Type",'smart-addon'),
                "param_name" => "sourcetype",
                "value" => array(
                    "Images" => 'images',
                    "Post Content" => 'post'
                ),
                'std' => 'post',
                "group" => __("Source Settings", 'smart-addon')
            ),
            array(
                "type" => "loop",
                "heading" => __("Source",'smart-addon'),
                "param_name" => "source",
                'settings' => array(
                    'size' => array('hidden' => 0, 'value' => 10),
                    'order_by' => array('value' => 'date')
                ),
                "dependency" => array(
                    "element"=>"sourcetype",
                    "value" => 'post'
                ),
                "group" => __("Source Settings", 'smart-addon'),
                
            ),
            array(
                "type" => "attach_images",
                "heading" => __("Images Source",'smart-addon'),
                "param_name" => "imagessource",
                "dependency" => array(
                    "element"=>"sourcetype",
                    "value" => 'images'
                ),
                "group" => __("Source Settings", 'smart-addon'),
            ),
            array(
                "type" => "dropdown",
                "heading" => __("XSmall Devices",'smart-addon'),
                "param_name" => "xsmall_items",
                "edit_field_class" => "vc_col-sm-3 vc_carousel_item",
                "value" => array(1,2,3,4,5,6),
                "std" => 1,
                "group" => __("Carousel Settings", 'smart-addon')
            ),
            array(
                "type" => "dropdown",
                "heading" => __("Small Devices",'smart-addon'),
                "param_name" => "small_items",
                "edit_field_class" => "vc_col-sm-3 vc_carousel_item",
                "value" => array(1,2,3,4,5,6),
                "std" => 2,
                "group" => __("Carousel Settings", 'smart-addon')
            ),
            array(
                "type" => "dropdown",
                "heading" => __("Medium Devices",'smart-addon'),
                "param_name" => "medium_items",
                "edit_field_class" => "vc_col-sm-3 vc_carousel_item",
                "value" => array(1,2,3,4,5,6),
                "std" => 3,
                "group" => __("Carousel Settings", 'smart-addon')
            ),
            array(
                "type" => "dropdown",
                "heading" => __("Large Devices",'smart-addon'),
                "param_name" => "large_items",
                "edit_field_class" => "vc_col-sm-3 vc_carousel_item",
                "value" => array(1,2,3,4,5,6),
                "std" => 4,
                "group" => __("Carousel Settings", 'smart-addon')
            ),
            array(
                "type" => "textfield",
                "heading" => __("Margin Items",'smart-addon'),
                "param_name" => "margin",
                "value" => "10",
                "description" => __("",'smart-addon'),
                "group" => __("Carousel Settings", 'smart-addon')
            ),
            array(
                "type" => "dropdown",
                "heading" => __("Loop Items",'smart-addon'),
                "param_name" => "loop",
                "value" => array(
                    "True" => 1,
                    "False" => 0
                ),
                'std' => 1,
                "group" => __("Carousel Settings", 'smart-addon')
            ),
            array(
                "type" => "dropdown",
                "heading" => __("Mouse Drag",'smart-addon'),
                "param_name" => "mousedrag",
                "value" => array(
                    "True" => 1,
                    "False" => 0
                ),
                'std' => 1,
                "group" => __("Carousel Settings", 'smart-addon')
            ),
            array(
                "type" => "dropdown",
                "heading" => __("Touch Drag",'smart-addon'),
                "param_name" => "touchdrag",
                "value" => array(
                    "True" => 1,
                    "False" => 0
                ),
                'std' => 1,
                "group" => __("Carousel Settings", 'smart-addon')
            ),
            array(
                "type" => "dropdown",
                "heading" => __("Show Nav",'smart-addon'),
                "param_name" => "nav",
                "value" => array(
                    "True" => 1,
                    "False" => 0
                ),
                'std' => 1,
                "group" => __("Carousel Settings", 'smart-addon')
            ),
            array(
                "type" => "dropdown",
                "heading" => __("Show Dots",'smart-addon'),
                "param_name" => "dots",
                "value" => array(
                    "True" => 1,
                    "False" => 0
                ),
                'std' => 1,
                "group" => __("Carousel Settings", 'smart-addon')
            ),
            array(
                "type" => "dropdown",
                "heading" => __("Center",'smart-addon'),
                "param_name" => "center",
                "value" => array(
                    "False" => 0,
                    "True" => 1
                ),
                'std' => 0,
                "group" => __("Carousel Settings", 'smart-addon')
            ),
            array(
                "type" => "dropdown",
                "heading" => __("Auto Play",'smart-addon'),
                "param_name" => "autoplay",
                "value" => array(
                    "True" => 1,
                    "False" => 0
                ),
                'std' => 1,
                "group" => __("Carousel Settings", 'smart-addon')
            ),
            array(
                "type" => "textfield",
                "heading" => __("Auto Play TimeOut",'smart-addon'),
                "param_name" => "autoplaytimeout",
                "value" => "5000",
                "dependency" => array(
                    "element"=>"autoplay",
                    "value" => 1
                ),
                "description" => __("",'smart-addon'),
                "group" => __("Carousel Settings", 'smart-addon')
            ),
            array(
                "type" => "textfield",
                "heading" => __("Smart Speed",'smart-addon'),
                "param_name" => "smartspeed",
                "value" => "1000",
                "description" => __("Speed scroll of each item",'smart-addon'),
                "group" => __("Carousel Settings", 'smart-addon')
            ),
            array(
                "type" => "dropdown",
                "heading" => __("Pause On Hover",'smart-addon'),
                "param_name" => "autoplayhoverpause",
                "dependency" => array(
                    "element"=>"autoplay",
                    "value" => 1
                ),
                "value" => array(
                    "True" => 1,
                    "False" => 0
                ),
                'std' => 1,
                "group" => __("Carousel Settings", 'smart-addon')
            ),
            array(
                'type' => 'iconpicker',
                'heading' => __( 'Left Arrow', 'smart-addon' ),
                'param_name' => 'left_arrow',
                'value' => 'fa fa-arrow-left',
                'settings' => array(
                    'emptyIcon' => 0, 
                    'iconsPerPage' => 200, 
                ),
                'description' => __( 'Select icon from library.', 'smart-addon' ),
                "group" => __("Carousel Settings", 'smart-addon')
            ),
            array(
                'type' => 'iconpicker',
                'heading' => __( 'Right Arrow', 'smart-addon' ),
                'param_name' => 'right_arrow',
                'value' => 'fa fa-arrow-right',
                'settings' => array(
                    'emptyIcon' => 0, 
                    'iconsPerPage' => 200, 
                ),
                'description' => __( 'Select icon from library.', 'smart-addon' ),
                "group" => __("Carousel Settings", 'smart-addon')
            ),
            array(
                "type" => "dropdown",
                "heading" => __("Filter", 'smart-addon'),
                "param_name" => "filter",
                "value" => array(
                    "Disable" => "false",
                    "Enable" => "true"
                ),
                'std' => "false",
                'description' => __('The filter don\'t work with Loop.', 'smart-addon'),
                "group" => __("Carousel Settings", 'smart-addon')
            ),
            array(
                "type" => "textfield",
                "heading" => __("Extra Class",'smart-addon'),
                "param_name" => "class",
                "value" => "",
                "description" => __("",'smart-addon'),
                "group" => __("Template", 'smart-addon')
            ),
            array(
                "type" => "dropdown",
                "heading" => __("Carouasel Type", 'smart-addon'),
                "param_name" => "cs_type",
                "value" => array(
                    "Slider" => "slider",
                    "Carouasel" => "carouasel"
                ),
                'std' => "carouasel",
                "group" => __("Template", 'smart-addon')
            ),
            array(
                "type" => "fl_template",
                "param_name" => "fl_template",
                "shortcode" => "flcarousel",
                "admin_label" => true,
                "heading" => __("Shortcode Template",'smart-addon'),
                "group" => __("Template", 'smart-addon'),
            )
        )
    )
);
global $sa_vc_carousel;
$sa_vc_carousel = array();

class WPBakeryShortCode_sa_vc_carousel extends Smart_Addon_Shortcode{
    protected function content($atts, $content = null){

        $atts_extra = shortcode_atts(array(
            'xsmall_items' => 1,
            'small_items' => 2,
            'medium_items' => 3,
            'large_items' => 4,
            'margin' => 0,
            'loop' => 1,
            'mousedrag' => 1,
            'touchdrag' => 1,
            'nav' => 1,
            'dots' => 1,
            'center' => 0,
            'autoplay' => 1,
            'autoplaytimeout' => '5000',
            'smartspeed' => '250',
            'autoplayhoverpause' => 1,
            'left_arrow' => 'fa fa-arrow-left',
            'right_arrow' => 'fa fa-arrow-right',
            'filter' => "false",
            'class' => '',
            'sourcetype' => 'post',
            'imagessource' => '',
            'fl_template' => 'flcarousel.php'
        ), $atts);

        global $sa_vc_carousel;
        $atts = array_merge($atts_extra,$atts);

        wp_enqueue_style('owl-carousel',FL_CSS.'owl.carousel.css','','2.0.0b','all');
        wp_enqueue_script('owl-carousel',FL_JS.'owl.carousel.js',array('jquery'),'2.0.0b', true);
        wp_enqueue_script('owl-autoplay',FL_JS.'owl.autoplay.js',array('jquery'),'2.0.0b', true);
        wp_enqueue_script('owl-navigation',FL_JS.'owl.navigation.js',array('jquery'),'2.0.0b', true);
        wp_enqueue_script('owl-animate',FL_JS.'owl.animate.js',array('jquery'),'2.0.0b', true);

        wp_enqueue_script('owl-carousel-fl',FL_JS.'owl.carousel.fl.js',array('jquery'),'1.0.0', true);
        
        if ($atts['sourcetype'] == 'post') {
            $source = $atts['source'];
            list($args, $posts) = vc_build_loop_query($source);
            $atts['posts'] = $posts;
        }else{
            $atts['posts'] = '';
        }
        
        $html_id = getHtmlID('fl-carousel');
        $atts['autoplaytimeout'] = isset($atts['autoplaytimeout']) ? (int)$atts['autoplaytimeout'] : 5000;
        $atts['smartspeed'] = isset($atts['smartspeed']) ? (int)$atts['smartspeed'] : 250;
        $left_arrow = isset($atts['left_arrow'])?$atts['left_arrow']:'fa fa-arrow-left';
        $right_arrow = isset($atts['right_arrow'])?$atts['right_arrow']:'fa fa-arrow-right';

        $sa_vc_carousel[$html_id] = array(
            'margin' => (int)$atts['margin'],
            'loop' => $atts['loop'] == 1 ? true : false,
            'mouseDrag' => $atts['mousedrag'] == 1 ? true : false,
            'touchDrag' => $atts['touchdrag'] == 1 ? true : false,
            'nav' => $atts['nav'] == 1 ? true : false,
            'dots' => $atts['dots'] == 1 ? true : false,
            'center' => $atts['center'] == 1 ? true : false,
            'autoplay' => $atts['autoplay'] == 1 ? true : false,
            'autoplayTimeout' => $atts['autoplaytimeout'],
            'smartSpeed' => $atts['smartspeed'],
            'autoplayHoverPause' => $atts['autoplayhoverpause'] == 1 ? true : false,
            'navText' => array('<i class="'.$left_arrow.'"></i>','<i class="'.$right_arrow.'"></i>'),
            'dotscontainer' => $html_id.' .fl-dots',
            'items' => (int)$atts['large_items'],
            'responsive' => array(
                0 => array(
                    "items" => (int)$atts['xsmall_items'],
                ),
                768 => array(
                    "items" => (int)$atts['small_items'],
                ),
                992 => array(
                    "items" => (int)$atts['medium_items'],
                ),
                1200 => array(
                    "items" => (int)$atts['large_items'],
                )
            )
        );

        wp_localize_script('sa-vc-carousel', "sa-vc-carousel", $sa_vc_carousel);

        $atts['template'] = 'template-'.str_replace('.php','',$atts['fl_template']). ' '. $atts['class'];
        $atts['html_id'] = $html_id;
        return parent::content($atts, $content);
    }
}