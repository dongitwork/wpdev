<?php 

/*
* Base class theme 
* add css and js theme support menu and widgets
*/
class Magazine_Extra_Theme{
    function __construct(){
        add_action('wp_enqueue_scripts',array($this, 'Magazine_extra_add_scripts'),100);
        add_action('et_builder_ready',array($this, 'Magazine_extra_builder'));
        add_action('init',array($this, 'Magazine_theme_setting'));
        add_action('widgets_init',array($this, 'theme_add_widgets_init'),10,3);
    }

    public function Magazine_theme_setting()
    {
        register_nav_menus(array(
            'mobilenav' => __('Mobile Menu', 'mz-theme'),
        ));
    }

    /*
    * Add custom module shortcode
    */
    public function Magazine_extra_builder()
    {
        if ( ! class_exists( 'ET_Builder_Module' ) ) { return; }
        include Magazine_Builder.'mz-gallery-module.php';
        include Magazine_Builder.'mz-block_post-module.php';
        include Magazine_Builder.'mz-slider_post-module.php';
        include Magazine_Builder.'mz-carousel_post-module.php';
    }

   
    public function theme_add_widgets_init() {
        register_sidebar( array(
            'name' => __( 'Magazine Sidebar', 'theme-slug' ),
            'id' => 'magazine-sidebar',
            'description' => __( 'Widgets in this area will be shown on all posts and pages.', 'theme-slug' ),
            'before_widget' => '<div id="%1$s" class="et_pb_widget %2$s">',
            'after_widget'  => '</div>',
            'before_title'  => '<h4 class="mz-title"><span>',
            'after_title'   => '</span></h4>',
        ) );

        register_sidebar( array(
            'name' => __( 'Magazine Home Top', 'theme-slug' ),
            'id' => 'home-top',
            'description' => __( 'Widgets in this area will be shown on all posts and pages.', 'theme-slug' ),
            'before_widget' => '<div id="%1$s" class="et_pb_widget %2$s">',
            'after_widget'  => '</div>',
            'before_title'  => '<h4 class="mz-title"><span>',
            'after_title'   => '</span></h4>',
        ) );

        register_sidebar( array(
            'name' => __( 'Magazine Home Bottom', 'theme-slug' ),
            'id' => 'home-bottom',
            'description' => __( 'Widgets in this area will be shown on all posts and pages.', 'theme-slug' ),
            'before_widget' => '<div id="%1$s" class="et_pb_widget %2$s">',
            'after_widget'  => '</div>',
            'before_title'  => '<h4 class="mz-title"><span>',
            'after_title'   => '</span></h4>',
        ) );
    }
    
    public function Magazine_extra_add_scripts()
    {
        global $wp_scripts;
        wp_enqueue_script('jquery');

        wp_enqueue_style('Divi-style', CORE_URL.'/style.css', array(),'2.0'); 
        wp_enqueue_style('Playfair', 'https://fonts.googleapis.com/css?family=Playfair+Display:400,700,900', array(),'2.0'); 
        /*owl-carousel*/
        wp_enqueue_style('owl-css',THEME_URL_LIBS.'owl-carousel/owl.carousel.min.css',array(),'2.0'); 
        wp_enqueue_script('owl-js',THEME_URL_LIBS.'owl-carousel/owl.carousel.min.js', array(), '2.0', true);
        
        /*slider-pro*/
        wp_enqueue_style('sliderPro-css',THEME_URL_LIBS.'slider-pro/css/slider-pro.min.css',array(),'1.3'); 
        wp_enqueue_script('sliderPro-js',THEME_URL_LIBS.'slider-pro/js/jquery.sliderPro.min.js', array(), '1.3', true); 
        /*flmenu*/
        wp_enqueue_style('flmenu-css',THEME_URL_LIBS.'flmenu/flmenu.min.css',array(),'2.0'); 
        wp_enqueue_script('flmenu-js',THEME_URL_LIBS.'flmenu/flmenu.min.js', array(), '2.0', true);
        /*colorbox*/
        wp_enqueue_style('colorbox-css', THEME_URL_LIBS.'colorbox/colorbox.css',array(),'1.6.4'); 
        wp_enqueue_script('colorbox-js', THEME_URL_LIBS . 'colorbox/colorbox-min.js', array(), '1.6.4', true);

        /*Font*/
        wp_enqueue_style('fontawesome', THEME_URL_LIBS.'font-awesome/css/font-awesome.min.css',array(),'4.7.0'); 
        wp_enqueue_script('Magazine-script-js', THEME_URL_ASSETS.'js/main.js', array(),false,true);
        wp_enqueue_style('Magazine-col-css', THEME_URL_ASSETS.'css/col-12.css', array(),'2.0'); 
        wp_enqueue_style('Magazine-main', THEME_URL_ASSETS.'css/main.css', array(),'2.0'); 
        //wp_enqueue_style('Magazine-color', THEME_URL_ASSETS.'css/colorsite.css', array(),'2.0'); 
        wp_enqueue_style('Magazine-responsive', THEME_URL_ASSETS.'css/responsive.css', array(),'2.0'); 
    }

}
new Magazine_Extra_Theme();

/** Template functions */
require_once THEME_CORE. 'aq_resizer.php';
require_once THEME_CORE. 'template-functions.php';
require_once THEME_CORE. 'template-widgets.php';
require_once THEME_CORE. 'template-shortcode.php';
require_once THEME_CORE. 'menu/class-flex-walker-nav.php';
