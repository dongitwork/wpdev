<?php 

/*
* Base class theme 
* add css and js theme support menu and widgets
*/
class Rocket_Extra_Theme{
    function __construct(){
        add_action('wp_enqueue_scripts',array($this, 'Rocket_extra_add_scripts'),100);
        add_action('et_builder_ready',array($this, 'Rocket_extra_builder'));
        add_action('widgets_init', array($this, 'Rocket_theme_witget_init'));
        add_action('init', array($this, 'roket_theme_addcustom'));
    }

    /*
    * Add custom module shortcode
    */
    public function Rocket_extra_builder()
    {
        if ( ! class_exists( 'ET_Builder_Module' ) ) { return; }
        include Rocket_Builder.'rocket-tabs-module.php';
        include Rocket_Builder.'rocket-testimonials-module.php';
        include Rocket_Builder.'rocket-partners-module.php';
        include Rocket_Builder.'rocket-pricing-module.php';
        include Rocket_Builder.'rocket-blog-module.php';
        include Rocket_Builder.'rocket-project-module.php';
        include Rocket_Builder.'rocket-blog_twitter-module.php';
      //  include Rocket_Builder.'rocket-cta-module.php';
    }
    
    public function Rocket_extra_add_scripts()
    {
        global $wp_scripts;
        wp_enqueue_script('jquery');    
        

        wp_enqueue_style('Divi-style', CORE_URL.'/style.css', array(),'2.0'); 
        wp_enqueue_style('Raleway', 'https://fonts.googleapis.com/css?family=Raleway:400,500,600,700,800,900', array(),'2.0');  
        wp_enqueue_style('OpenSans', 'https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700,800', array(),'2.0');
         
        /*owl-carousel*/
        wp_enqueue_style('owl-css',THEME_URL_LIBS.'owl-carousel/owl.carousel.min.css',array(),'2.0'); 
        wp_enqueue_script('owl-js',THEME_URL_LIBS.'owl-carousel/owl.carousel.min.js', array(), '2.0', true); 

        /*colorbox*/
        wp_enqueue_style('colorbox-css', THEME_URL_LIBS.'colorbox/colorbox.css',array(),'1.6.4'); 
        wp_enqueue_script('colorbox-js', THEME_URL_LIBS . 'colorbox/colorbox-min.js', array(), '1.6.4', true);

        /*Font*/
        wp_enqueue_style('fontawesome', THEME_URL_LIBS.'font-awesome/css/font-awesome.min.css',array(),'4.7.0'); 
        //wp_enqueue_style('elegant_font', THEME_URL_LIBS.'elegant_font/elegant_font.css',array(),'3.0'); 

        wp_enqueue_script('Rocket-script-js', THEME_URL_ASSETS.'js/main.js', array(),false,true);
        wp_enqueue_style('Rocket-col-css', THEME_URL_ASSETS.'css/col-12.css', array(),'2.0'); 
        wp_enqueue_style('Rocket-main', THEME_URL_ASSETS.'css/main.css', array(),'2.0'); 
      //  wp_enqueue_style('Rocket-color', THEME_URL_ASSETS.'css/colorsite.css', array(),'2.0'); 
        wp_enqueue_style('Rocket-responsive', THEME_URL_ASSETS.'css/responsive.css', array(),'2.0'); 

        wp_localize_script(
            'Rocket-script-js',
            'rkt_js',
            array( 'ajaxurl' => admin_url( 'admin-ajax.php' ) )
        );
    }

    /*
    * Add witget
    */
    public function Rocket_theme_witget_init() 
    {
        register_sidebar(array(
            'name'          => __('Subscribe', 'rocket-theme'),
            'id'            => 'subscribe',
            'before_widget' => '<aside id="%1$s" class="widget %2$s">',
            'after_widget'  => '</aside>',
            'before_title'  => '<h2 class="widget-title">',
            'after_title'   => '</h2>',
        ));
    }
    public function roket_theme_addcustom() {
      /**
       * Post Type: Team Members.
       */

      $labels = array(
        "name" => __( "Team Members", "" ),
        "singular_name" => __( "Team Member", "" ),
      );

      $args = array(
        "label" => __( "Team Members", "" ),
        "labels" => $labels,
        "description" => "",
        "public" => true,
        "publicly_queryable" => true,
        "show_ui" => true,
        "show_in_rest" => false,
        "rest_base" => "",
        "has_archive" => false,
        "show_in_menu" => true,
        "exclude_from_search" => false,
        "capability_type" => "post",
        "map_meta_cap" => true,
        "hierarchical" => false,
        "rewrite" => array( "slug" => "team_member", "with_front" => true ),
        "query_var" => true,
        "supports" => array( "title", "editor", "thumbnail" ),
      );

      register_post_type( "team_member", $args );

      $labels = array(
        "name" => __( "Categories", "" ),
        "singular_name" => __( "Category", "" ),
      );

      $args = array(
        "label" => __( "Categories", "" ),
        "labels" => $labels,
        "public" => true,
        "hierarchical" => true,
        "label" => "Categories",
        "show_ui" => true,
        "show_in_menu" => true,
        "show_in_nav_menus" => true,
        "query_var" => true,
        "rewrite" => array( 'slug' => 'team_cat', 'with_front' => true, ),
        "show_admin_column" => false,
        "show_in_rest" => false,
        "rest_base" => "",
        "show_in_quick_edit" => false,
      );
      register_taxonomy( "team_cat", array( "team_member" ), $args );
    }
}
new Rocket_Extra_Theme();

if(!function_exists('acf_register_repeater_field') ){
    add_action('acf/register_fields', 'acf_register_repeater_field');
    function acf_register_repeater_field()
    {
        include_once(THEME_CORE. 'acf-gallery/gallery.php');
    }
}
/** Template functions */
require_once THEME_CORE. 'template-functions.php';
require_once THEME_CORE. 'template-widgets.php';
require_once THEME_CORE. 'template-shortcode.php';
