<?php

/**
* Class Flex main site
*/
class Fx_Base 
{
    function __construct()
    {
        add_action( 'after_setup_theme',array($this, 'fx_add_woocommerce_support'));
        add_action('init',array($this, 'fx_theme_support'));
        add_action('wp_enqueue_scripts',array($this, 'fx_theme_add_scripts'));
        add_action('widgets_init', array($this, 'fx_theme_witget_init'));
        
        /* Hook Achive Title */
        apply_filters( 'get_the_archive_title', array($this, 'fx_filter_archive_title'));
        /* Remove script ver */
        add_filter( 'script_loader_src', array($this,'fl_remove_script_version'), 15,1);
        add_filter( 'style_loader_src', array($this,'fl_remove_script_version'), 15,1);
    }

    public function fx_add_woocommerce_support()
    {
        add_theme_support( 'woocommerce' );
        add_theme_support( 'wc-product-gallery-zoom' );
	    add_theme_support( 'wc-product-gallery-lightbox' );
	    add_theme_support( 'wc-product-gallery-slider' );
    }

    /*
    * Theme Add css and js
    */
    public function fx_theme_add_scripts()
    {
        global $wp_scripts;
        wp_enqueue_script('jquery');
        /*Google Font*/
        wp_enqueue_style('Roboto','https://fonts.googleapis.com/css?family=Oswald:400,500,600|Roboto:300,400,500,700&amp;subset=vietnamese',array(),'');
        /* Bootstrap*/
        wp_enqueue_style('btmincss',THEME_URL_LIBS.'bootstrap/css/bootstrap.min.css',array(),'3.3.7');
        wp_enqueue_style('btthemecss',THEME_URL_LIBS.'bootstrap/css/bootstrap-theme.min.css', array(), '3.3.7');
        //wp_enqueue_style('animate','https://cdnjs.cloudflare.com/ajax/libs/animate.css/3.5.2/animate.min.css', array(), '3.3.7');
        wp_enqueue_script('btminjs',THEME_URL_LIBS.'bootstrap/js/bootstrap.min.js',array(),'3.3.7',true);
        //wp_enqueue_script('wowjs','https://cdnjs.cloudflare.com/ajax/libs/wow/1.1.2/wow.min.js',array(),'3.3.7',true);
       // wp_enqueue_script('isotopejs','https://npmcdn.com/isotope-layout@3/dist/isotope.pkgd.js',array(),'3.3.7',true);

        /*owl-carousel*/
        wp_enqueue_style('owl-css',THEME_URL_LIBS.'owl-carousel/owl.carousel.min.css',array(),'2.0'); 
        wp_enqueue_script('owl-js',THEME_URL_LIBS.'owl-carousel/owl.carousel.min.js', array(), '2.0', true); 
        /*flmenu*/
        wp_enqueue_style('flmenu-css',THEME_URL_LIBS.'flmenu/flmenu.min.css',array(),THEME_VER); 
        wp_enqueue_script('flmenu-js',THEME_URL_LIBS.'flmenu/flmenu.min.js', array(), THEME_VER, true);
        /*colorbox*/
        wp_enqueue_style('colorbox-css', THEME_URL_LIBS.'colorbox/colorbox.css',array(),'1.6.4'); 
        wp_enqueue_script('colorbox-js', THEME_URL_LIBS . 'colorbox/colorbox-min.js', array(), '1.6.4', true);
        /*Font*/
        wp_enqueue_style('fontawesome', THEME_URL_LIBS.'font-awesome/css/font-awesome.min.css',array(),'4.7.0'); 
        wp_enqueue_script('waypoints', THEME_URL_LIBS.'waypoints.min.js', array(),false,true);
        /* Style Themes */
        //wp_enqueue_style('theme-style', THEME_URL.'/style.css');
        
        wp_enqueue_script('fl-script', THEME_URL_ASSETS.'js/main.js', array(),false,true);
        wp_enqueue_style('fl-css', THEME_URL_ASSETS.'css/main.css', array(),THEME_VER); 
        wp_enqueue_style('fl-cres', THEME_URL_ASSETS.'css/responsive.css', array(),THEME_VER); 
    }

    /*
    * Add theme support
    */
    public function fx_theme_support() 
    {
        load_theme_textdomain( 'flex-theme', get_template_directory() . '/languages' );
        // Adds title tag
        add_theme_support('post-thumbnails');
        add_theme_support('title-tag');
        add_theme_support('automatic-feed-links' );
        

        add_theme_support('post-formats',array( 'video', 'audio' , 'gallery', 'link', 'quote',));
        register_nav_menus(array(
            'topbar' => __('TopBar Menu', 'flex-theme'),
            'primary' => __('Primary Menu', 'flex-theme'),
            'footer' => __('Footer Menu', 'flex-theme'),
        ));
        remove_action( 'wp_head', 'print_emoji_detection_script', 7 );
        remove_action( 'wp_print_styles', 'print_emoji_styles' ); 
        add_filter( 'wp_get_attachment_image_attributes', function( $attr ){
            if( isset( $attr['class'] )  && 'custom-logo' === $attr['class'] )
                $attr['class'] = 'custom-logo img-responsive';
            return $attr;
        });
        add_filter('widget_text', 'do_shortcode');
        add_filter( 'login_headerurl',function(){ return home_url(); });
        add_filter( 'login_headertitle',function(){ return get_bloginfo('name'); });
    }

    /*
    * Add witget
    */
    public function fx_theme_witget_init() 
    {
        register_sidebar(array(
            'name'          => __('Sidebar left', 'flex-theme'),
            'id'            => 'sidebar-left',
            'before_widget' => '<aside id="%1$s" class="widget %2$s">',
            'after_widget'  => '</aside>',
            'before_title'  => '<h2 class="widget-title">',
            'after_title'   => '</h2>',
        ));

        register_sidebar(array(
            'name'          => __('Sidebar right', 'flex-theme'),
            'id'            => 'sidebar-right',
            'before_widget' => '<aside id="%1$s" class="widget %2$s">',
            'after_widget'  => '</aside>',
            'before_title'  => '<h4 class="widget-title bg-title">',
            'after_title'   => '</h4>',
        ));
        
        register_sidebar(array(
            'name'          => __('Header', 'flex-theme'),
            'id'            => 'header',
            'before_widget' => '<div id="%1$s" class="block_header %2$s">',
            'after_widget'  => '</div>',
        )); 

        register_sidebar(array(
            'name'          => __('After Content', 'flex-theme'),
            'id'            => 'after-content',
            'before_widget' => '<aside id="%1$s" class="widget %2$s ">',
            'after_widget'  => '</aside>',
            'before_title'  => '<div class="group-title "><h2 class="block-title">',
            'after_title'   => '</h2></div>',
        ));

        register_sidebar(array(
            'name'          => __('Footer tags', 'flex-theme'),
            'id'            => 'footer-tags',
            'before_widget' => '<aside id="%1$s" class="widget %2$s ">',
            'after_widget'  => '</aside>',
            'before_title'  => '<h5 class="widget-title">',
            'after_title'   => '</h5>',
        ));

        register_sidebar(array(
            'name'          => __('Footer 1', 'flex-theme'),
            'id'            => 'footer-1',
            'before_widget' => '<aside id="%1$s" class="widget %2$s ">',
            'after_widget'  => '</aside>',
            'before_title'  => '<h5 class="widget-title">',
            'after_title'   => '</h5>',
        ));

        register_sidebar(array(
            'name'          => __('Footer 2', 'flex-theme'),
            'id'            => 'footer-2',
            'before_widget' => '<aside id="%1$s" class="widget %2$s ">',
            'after_widget'  => '</aside>',
            'before_title'  => '<h5 class="widget-title">',
            'after_title'   => '</h5>',
        ));

        register_sidebar(array(
            'name'          => __('Footer 3', 'flex-theme'),
            'id'            => 'footer-3',
            'before_widget' => '<aside id="%1$s" class="widget %2$s ">',
            'after_widget'  => '</aside>',
            'before_title'  => '<h5 class="widget-title">',
            'after_title'   => '</h5>',
        ));

        register_sidebar(array(
            'name'          => __('Footer 4', 'flex-theme'),
            'id'            => 'footer-4',
            'before_widget' => '<aside id="%1$s" class="widget %2$s ">',
            'after_widget'  => '</aside>',
            'before_title'  => '<h5 class="widget-title">',
            'after_title'   => '</h5>',
        ));
    }

    /**
     * minimize CSS styles
     */
    public static function compressCss($buffer){
        $buffer = preg_replace("!/\*[^*]*\*+([^/][^*]*\*+)*/!", "", $buffer);
        $buffer = str_replace(" ", " ", $buffer); 
        $arr = array("\r\n", "\r", "\n", "\t", "  ", "    ", "    ");
        $rep = array("", "", "", "", " ", " ", " ");
        $buffer = str_replace($arr, $rep, $buffer);
        $buffer = preg_replace("/\s*([\{\}:,])\s*/", "$1", $buffer);
        $buffer = str_replace(';}', "}", $buffer);
        return $buffer;
    }

    public static function fx_filter_archive_title() {
        if ( is_category() ) {
            $title = sprintf( __( '%s' ), single_cat_title( '', false ) );
        } elseif ( is_tag() ) {
            $title = sprintf( __( 'Tag: %s' ), single_tag_title( '', false ) );
        } elseif ( is_author() ) {
            $title = sprintf( __( 'Author: %s' ), '<span class="vcard">' . get_the_author() . '</span>' );
        } elseif ( is_year() ) {
            $title = sprintf( __( 'Year: %s' ), get_the_date( _x( 'Y', 'yearly archives date format' ) ) );
        } elseif ( is_month() ) {
            $title = sprintf( __( 'Month: %s' ), get_the_date( _x( 'F Y', 'monthly archives date format' ) ) );
        } elseif ( is_day() ) {
            $title = sprintf( __( 'Day: %s' ), get_the_date( _x( 'F j, Y', 'daily archives date format' ) ) );
        } elseif ( is_tax( 'post_format' ) ) {
            if ( is_tax( 'post_format', 'post-format-aside' ) ) {
                $title = _x( 'Asides', 'post format archive title' );
            } elseif ( is_tax( 'post_format', 'post-format-gallery' ) ) {
                $title = _x( 'Galleries', 'post format archive title' );
            } elseif ( is_tax( 'post_format', 'post-format-image' ) ) {
                $title = _x( 'Images', 'post format archive title' );
            } elseif ( is_tax( 'post_format', 'post-format-video' ) ) {
                $title = _x( 'Videos', 'post format archive title' );
            } elseif ( is_tax( 'post_format', 'post-format-quote' ) ) {
                $title = _x( 'Quotes', 'post format archive title' );
            } elseif ( is_tax( 'post_format', 'post-format-link' ) ) {
                $title = _x( 'Links', 'post format archive title' );
            } elseif ( is_tax( 'post_format', 'post-format-status' ) ) {
                $title = _x( 'Statuses', 'post format archive title' );
            } elseif ( is_tax( 'post_format', 'post-format-audio' ) ) {
                $title = _x( 'Audio', 'post format archive title' );
            } elseif ( is_tax( 'post_format', 'post-format-chat' ) ) {
                $title = _x( 'Chats', 'post format archive title' );
            }
        } elseif ( is_post_type_archive() ) {
            $title = sprintf( __( '%s' ), post_type_archive_title( '', false ) );
        } elseif ( is_tax() ) {
            $tax = get_taxonomy( get_queried_object()->taxonomy );
            /* translators: 1: Taxonomy singular name, 2: Current taxonomy term */
            $title = sprintf( __( '%1$s: %2$s' ), $tax->labels->singular_name, single_term_title( '', false ) );
        } else {
            $title = __( 'Archives' );
        }
        
        return str_replace('Category:', '', $title);
    }

    public static function fl_remove_script_version( $src ){
        $parts = explode( '?ver', $src );
        return $parts[0];
    }
    
}

global $fx_base;
$fx_base = new Fx_Base();