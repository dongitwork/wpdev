<?php 

/*
* Base class theme 
* add css and js theme support menu and widgets
*/
class SA_Extra_Theme{
    function __construct(){
        add_action('wp_enqueue_scripts',array($this, 'SA_extra_add_scripts'),100);
        add_action('et_builder_ready',array($this, 'SA_extra_builder'));
        add_action('init',array($this, 'SA_theme_setting'));
        add_action('widgets_init',array($this, 'SA_theme_widgets_init'),10,3);
    }

    public function SA_theme_setting()
    {
        /*register_nav_menus(array(
            'mobilenav' => __('Mobile Menu', 'mz-theme'),
        ));*/
    }

    /*
    * Add Module SA Builder
    */
    public function SA_extra_builder()
    {
        if ( ! class_exists( 'ET_Builder_Module' ) ) { return; }
         include SA_Builder.'sa-module-testimonials.php';
         include SA_Builder.'sa-module-videotext.php';
         include SA_Builder.'sa-module-header.php';
         include SA_Builder.'sa-module-carousel_product.php';
         include SA_Builder.'sa-module-slider_product.php';
         include SA_Builder.'sa-module-list_product.php';
         include SA_Builder.'sa-module-image_maps.php';
    }
    
    public function SA_extra_add_scripts()
    {
        global $wp_scripts;
        wp_enqueue_script('jquery');

        wp_enqueue_style('Divi-style', CORE_URL.'/style.css', array(),'2.0'); 
        wp_enqueue_style('Playfair', 'https://fonts.googleapis.com/css?family=Playfair+Display:400,700,900', array(),'2.0'); 

        /*owl-carousel*/
        wp_enqueue_style('owl-css',THEME_URL_LIBS.'owl-carousel/owl.carousel.min.css',array(),'2.0'); 
        wp_enqueue_script('owl-js',THEME_URL_LIBS.'owl-carousel/owl.carousel.min.js', array(), '2.0', true);
        
        /*jquery-ui*/
        wp_enqueue_style('jqueryui-css',THEME_URL_LIBS.'jquery-ui/jquery-ui.css',array(),'1.3'); 
        wp_enqueue_script('jqueryui-js',THEME_URL_LIBS.'jquery-ui/jquery-ui.js', array(), '1.3', true);  

        wp_enqueue_script('githubusercontent-js',THEME_URL_LIBS.'url.min.js', array(), '1.3', true); 

        /*flmenu*/
        wp_enqueue_style('flmenu-css',THEME_URL_LIBS.'flmenu/flmenu.min.css',array(),'2.0'); 
        wp_enqueue_script('flmenu-js',THEME_URL_LIBS.'flmenu/flmenu.min.js', array(), '2.0', true);

        /*colorbox*/
        wp_enqueue_style('colorbox-css', THEME_URL_LIBS.'colorbox/colorbox.css',array(),'1.6.4'); 
        wp_enqueue_script('colorbox-js', THEME_URL_LIBS . 'colorbox/colorbox-min.js', array(), '1.6.4', true);

        /*Font*/
        wp_enqueue_style('fontawesome', THEME_URL_LIBS.'font-awesome/css/font-awesome.min.css',array(),'4.7.0'); 
        wp_enqueue_script('Woo-script-js', THEME_URL_ASSETS.'js/main.js', array(),false,true);
        wp_enqueue_style('Woo-col-css', THEME_URL_ASSETS.'css/col-12.css', array(),'2.0'); 
        wp_enqueue_style('Woo-main', THEME_URL_ASSETS.'css/main.css', array(),'2.0'); 
        wp_enqueue_style('Woo-responsive', THEME_URL_ASSETS.'css/responsive.css', array(),'2.0'); 
    }

    public function SA_theme_widgets_init()
    {
        // Footer Top
        register_sidebar( array(
            'name' => __( 'Footer Top', 'theme-slug' ),
            'id' => 'sa-fttop',
            'description' => __( 'Widgets in this area will be shown on above footer site.', '' ),
            'before_widget' => '<div id="%1$s" class="sa_widget %2$s">',
            'after_widget'  => '</div>',
            'before_title'  => '<h4 class="sa-title">',
            'after_title'   => '</h4>',
        ) );

        // Footer Top
        register_sidebar( array(
            'name' => __( 'Product List', 'theme-slug' ),
            'id' => 'sa-prolist',
            'description' => __( 'Widgets in this area will be shown on above list product.', '' ),
            'before_widget' => '<div id="%1$s" class="sa_widget %2$s">',
            'after_widget'  => '</div>',
            'before_title'  => '<h4 class="sa-title">',
            'after_title'   => '</h4>',
        ) );

    }

}
new SA_Extra_Theme();

/** Template functions */
require_once THEME_CORE. 'aq_resizer.php';
require_once THEME_CORE. 'template-woocommerce.php';
require_once THEME_CORE. 'template-functions.php';
require_once THEME_CORE. 'template-widgets.php';
require_once THEME_CORE. 'template-shortcode.php';
require_once THEME_CORE. 'menu/class-flex-walker-nav.php';
