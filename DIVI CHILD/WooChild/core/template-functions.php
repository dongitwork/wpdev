<?php

// Hook custom body class
add_filter('body_class', 'multisite_body_classes');
function multisite_body_classes($classes) {
    if ((is_front_page() || is_home()) ) {
        $classes[] = 'sa-header-home';
    }
    
    if (get_post_meta(get_the_ID(), "bg_custom", true) == 1 ) {
        $classes[] = 'sa-header-color';
    }    

    if (get_post_meta(get_the_ID(), "hide_newslt", true) == 1 ) {
        $classes[] = 'sa-hide_newslt';
    }

    return $classes;
}


function sa_nav_pager() {
    global $wp_query;
    $big = 999999999;
    $pages = paginate_links(array(
        'base' => str_replace($big, '%#%', get_pagenum_link($big)),
        'format' => '?page=%#%',
        'current' => max(1, get_query_var('paged')),
        'total' => $wp_query->max_num_pages,
        'prev_next' => false,
        'type' => 'array',
        'prev_next' => TRUE,
        'prev_text' => '&larr; Prev',
        'next_text' => 'Next &rarr;',
    ));
    
    if (is_array($pages)) {
        $current_page = ( get_query_var('paged') == 0 ) ? 1 : get_query_var('paged');
        echo '<ul class="pagination">';
        foreach ($pages as $i => $page) {
            if ($current_page == 1 && $i == 0) {
                echo "<li class='active'>$page</li>";
            } else {
                if (strpos( $page, 'current' ) !== false ) {
                    echo "<li class='active'>$page</li>";
                } else {
                    echo "<li>$page</li>";
                }
            }
        }
        echo '</ul>';
    }
}

/*
* Get Divi Module
*/
function the_sa_divi($id)
{
   print do_shortcode('[et_pb_section global_module="'.$id.'"][/et_pb_section]'); 
}

/*
* Get AQResize
*/
if(!function_exists('aq_resize')) {
    function aq_resize( $url, $width = null, $height = null, $crop = null, $single = true, $upscale = true ) {
        if ( defined( 'ICL_SITEPRESS_VERSION' ) ){
            global $sitepress;
            $url = $sitepress->convert_url( $url, $sitepress->get_default_language() );
        }
        $aq_resize = Aq_Resize::getInstance();
        return $aq_resize->process( $url, $width, $height, $crop, $single, $upscale );
    }
}


if(!function_exists('get_image_size')) {
    function get_image_size($size=array(1185,710),$class='',$url = '') {
        $url = ($url!='')?$url:get_the_post_thumbnail_url(get_the_ID(),'full');
        $imgurl = aq_resize($url,$size[0],$size[1],true);
        return '<img src="'.$imgurl.'" class="mz-postthumn img-responsive '.$class.'">';
    }
}

/*
* Get BTN Share 
*/
function get_share($pid)
{
   // $share_post = get_post($pid);
    $out = '<ul class="sa_social_list">
        <li class="social_iterm">
            <a href="https://www.facebook.com/sharer.php?u='.get_the_permalink($pid, false ).'" class="facebook" target="_blank" rel="nofollow"><i class="fa fa-facebook"></i></a>
        </li>
        <li class="social_iterm">
            <a href="https://twitter.com/share?url='.get_the_permalink($pid, false ).'&amp;text='.get_the_title($pid).'" class="twitter" target="_blank" rel="nofollow"><i class="fa fa-twitter"></i></a>
        </li>
        <li class="social_iterm">
            <a href="https://pinterest.com/pin/create/button/?url='.get_the_permalink($pid, false ).'&media=dfsd&description='.get_the_title($pid ).'" class="instagram" target="_blank" rel="nofollow"><i class="fa fa-instagram"></i></a>
        </li>
        <li class="social_iterm">
            <a href="https://pinterest.com/pin/create/button/?url='.get_the_permalink($pid, false ).'&media=dfsd&description='.get_the_title($pid ).'" class="linkedin" target="_blank" rel="nofollow"><i class="fa fa-linkedin"></i></a>
        </li>
    </ul>';
    return $out;
}



/* SA ADD METABOX */
function sa_add_post_meta_box() {
    if ( et_pb_is_allowed( 'page_options' ) ) {
        add_meta_box( 'sa_settings_meta_box', esc_html__( 'SA Page Settings', '' ), 'sa_settings_meta_box_out', 'page', 'side', 'high' );
    }
}
add_action( 'add_meta_boxes', 'sa_add_post_meta_box' );


function sa_settings_meta_box_out($object)
{
    wp_nonce_field(basename(__FILE__), "sa_settings_meta_box");

    ?>
        <div>
            <input id="bg_custom" name="bg_custom" value="1" type="checkbox" <?php print (get_post_meta($object->ID, "bg_custom", true) == 1)?'checked':'' ?>>
            <label for="bg_custom">Custom BG Header</label>
        </div>
        <div>
            <input id="hide_newslt" name="hide_newslt" value="1" type="checkbox" <?php print (get_post_meta($object->ID, "hide_newslt", true) == 1)?'checked':'' ?>>
            <label for="hide_newslt">Hide Newsletter</label>
        </div>
    <?php  
}

function save_sa_settings_meta_box($post_id, $post, $update)
{
    if (!isset($_POST["sa_settings_meta_box"]) || !wp_verify_nonce($_POST["sa_settings_meta_box"], basename(__FILE__)))
        return $post_id;
    if(!current_user_can("edit_post", $post_id))
        return $post_id;
    if(defined("DOING_AUTOSAVE") && DOING_AUTOSAVE)
        return $post_id;

    $slug = "page";
    if($slug != $post->post_type)
        return $post_id;

    $bg_custom = "";
    $fields = array('hide_newslt','bg_custom');
    foreach ($fields  as  $field) {
        if(isset($_POST[$field])){   
             $fvalue = $_POST[$field];
                update_post_meta($post_id, $field, $fvalue);
           
        }  
    }
     
    

}
add_action("save_post", "save_sa_settings_meta_box", 10, 3);

function remove_sa_settings_meta_box()
{
    remove_meta_box("postcustom", "page", "normal");
}
add_action("do_meta_boxes", "remove_sa_settings_meta_box");

// SA THEMES SETTING
add_action('customize_register', 'Magazine_customize_theme');
function Magazine_customize_theme( $wp_customize ) {

    $wp_customize->add_section('sa_wc_product', array(
        'title' => esc_html__( 'SA Setting', 'mz_themes' ),
        'description'    => 'Display a custom header shop page?',
        'priority' => 0,
    ));

    $wp_customize->add_setting('et_divi[sa_idblock]',array('default'  => '',));
    $wp_customize->add_control(
       'et_divi[sa_idblock]',
       array(
           'type' => 'text',
          'section' => 'sa_wc_product', 
          'label' => __( 'ID Global DIVI' ),
          'description' => __( 'This is a custom header shop page EX:123,12.' ),
       )
    );

    $wp_customize->add_setting('et_divi[sa_instagram]',array('default'  => '#',));
    $wp_customize->add_control(
       'et_divi[sa_instagram]',
       array(
           'type' => 'text',
          'section' => 'sa_wc_product', 
          'label' => __( 'Instagram' ),
          'description' => __( '' ),
       )
    );

    $wp_customize->add_setting('et_divi[sa_linkedin]',array('default'  => '#',));
    $wp_customize->add_control(
       'et_divi[sa_linkedin]',
       array(
           'type' => 'text',
          'section' => 'sa_wc_product', 
          'label' => __( 'Linkedin' ),
          'description' => __( '' ),
       )
    );
}

add_action( 'sa_header_shop', 'sa_load_header_shop', 10 );
function sa_load_header_shop()
{
   $sabid = et_get_option('sa_idblock','416,418');
   $sabid = explode(',', trim($sabid));
   if (!empty($sabid)) {
        foreach ($sabid as $sbid) {
            if (is_numeric($sbid)) {
               the_sa_divi($sbid);
            } 
        }
   }
}