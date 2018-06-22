<?php

// Hook custom body class
add_filter('body_class', 'multisite_body_classes');
function multisite_body_classes($classes) {
    if ((is_front_page() || is_home()) || (is_singular('post') && has_post_thumbnail())) {
        $classes[] = 'mz-header-layout';
    }else{
        $classes[] = 'mz-header-color';
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

// /get_blog_image('imgblog_3')
if(!function_exists('get_blog_image')) {
    function get_blog_image($thumname='imgblog_3',$class='',$url = '') {
        switch ($thumname) {
            case 'imgblog_1':
               // $width   = 890;
                $width   = 710;
                $height  = 355;
                break;
            case 'imgblog_2':
                $width   = 420;
                $height  = 355;
                break;
            case 'mzgls':
                $width   = 145;
                $height  = 95;
                break;
           case 'mzglb':
                $width   = 885;
                $height  = 295;
                break;
            default:
                $width  = 270;
                $height = 440;
                break;
        }
        $url = ($url!='')?$url:get_the_post_thumbnail_url(get_the_ID(),'full');
        $imgurl = aq_resize($url,$width, $height,true);
        return '<img src="'.$imgurl.'" class="mz-postthumn img-responsive '.$class.'">';

    }
}


if(!function_exists('get_image_size')) {
    function get_image_size($size=array(1185,710),$class='',$url = '') {
        $url = ($url!='')?$url:get_the_post_thumbnail_url(get_the_ID(),'full');
        $imgurl = aq_resize($url,$size[0],$size[1],true);
        return '<img src="'.$imgurl.'" class="mz-postthumn img-responsive '.$class.'">';
    }
}

if(!function_exists('the_blog_image')) {
    function the_blog_image($thumname='imgblog_3',$class='') {
      print get_blog_image($thumname,$class);
    }
}


function get_author_image($uid='')
{
    if ($uid == '') {
        $uid =  $atmt = get_the_author_meta('ID');;
    }
    $img_url = get_field('profile_picture','user_'.$uid);
    if ($img_url == '') {
       $img_url = 'http://0.gravatar.com/avatar/07ba4a842f55c2ca0a80ade63bb1dfda?s=80&d=mm&r=g';
    }
    return $img_url;
}
/*
* Get BTN Share 
*/
function get_share($pid)
{
   // $share_post = get_post($pid);
    $out = '<ul class="mz_social_list">
        <li class="social_iterm">
            <a href="https://www.facebook.com/sharer.php?u='.get_the_permalink($pid, false ).'" class="facebook" target="_blank" rel="nofollow"><i class="fa fa-facebook"></i></a>
        </li>
        <li class="social_iterm">
            <a href="https://twitter.com/share?url='.get_the_permalink($pid, false ).'&amp;text='.get_the_title($pid).'" class="twitter" target="_blank" rel="nofollow"><i class="fa fa-twitter"></i></a>
        </li>
        <li class="social_iterm">
            <a href="https://pinterest.com/pin/create/button/?url='.get_the_permalink($pid, false ).'&media=dfsd&description='.get_the_title($pid ).'" class="pinterest" target="_blank" rel="nofollow"><i class="fa fa-pinterest-p"></i></a>
        </li>
    </ul>';
    return $out;
}
/*
* Custom Comment Display
*/
function crunchify_disable_comment_url($fields) { 
    unset($fields['url']);
    return $fields;
}
add_filter('comment_form_default_fields','crunchify_disable_comment_url');

function mz_custom_comments_display( $comment, $args, $depth ) {
    $GLOBALS['comment'] = $comment;
     ?>
    <li <?php comment_class(); ?> id="li-comment-<?php comment_ID() ?>">
        <article id="comment-<?php comment_ID(); ?>" class="comment-body clearfix">
            <div class="comment_avatar">
                <div class="comment_avatar_inner">
                    <img src="<?php print get_author_image($comment->user_id); ?>">
                </div>
            </div>
            
            <div class="comment_postinfo">
                <?php printf( '<span class="fn">%s</span>', get_comment_author_link() ); ?>
                <span class="comment_date">
                    <?php
                        /* translators: 1: date, 2: time */
                        printf( esc_html__( 'on %1$s at %2$s', 'et_builder' ), get_comment_date(), get_comment_time() );
                    ?>
                </span>
                <?php edit_comment_link( esc_html__( '(Edit)', 'et_builder' ), ' ' ); ?>
                <?php
                    $et_comment_reply_link = get_comment_reply_link( array_merge( $args, array(
                        'reply_text' => esc_html__( 'Reply', 'et_builder' ),
                        'depth'      => (int) $depth,
                        'max_depth'  => (int) $args['max_depth'],
                    )));
                ?>
            </div> <!-- .comment_postinfo -->

            <div class="comment_area">
                <?php if ( '0' == $comment->comment_approved ) : ?>
                    <em class="moderation"><?php esc_html_e( 'Your comment is awaiting moderation.', 'et_builder' ) ?></em>
                    <br />
                <?php endif; ?>

                <div class="comment-content clearfix">
                <?php
                    comment_text();
                ?>
                </div> <!-- end comment-content-->
                <?php 
                    if ( $et_comment_reply_link ) echo '<div class="reply-container text-right">' . $et_comment_reply_link . '</div>';
                ?>
            </div> <!-- end comment_area-->
        </article> <!-- .comment-body -->
<?php }


add_action('customize_register', 'Magazine_customize_theme');
function Magazine_customize_theme( $wp_customize ) {

    $wp_customize->add_section('mz_ss_logo', array(
        'title' => esc_html__( 'Magazine Logo', 'mz_themes' ),
        'description'    => 'Display a custom logo?',
        'priority' => 0,
    ));

    $wp_customize->add_setting('mzt_logo',array('default'  => '',));
    $wp_customize->add_control(
       new WP_Customize_Image_Control(
           $wp_customize,
           'mzt_logo',
           array(
               'label'      => __( 'Upload a logo', '' ),
               'section'    => 'mz_ss_logo',
               'settings'   => 'mzt_logo', 
           )
       )
    );

    $wp_customize->add_setting('mz_logo_color',array('default'  => '',));
    $wp_customize->add_control(
       new WP_Customize_Image_Control(
           $wp_customize,
           'mz_logo_color',
           array(
               'label'      => __( 'Upload a logo color', '' ),
               'section'    => 'mz_ss_logo',
               'settings'   => 'mz_logo_color', 
           )
       )
    );
}

// Read later ajax
function add_later_post(){
    $id_post = $_POST['id_post'];
    update_post_meta( $id_post, 'read_later', 1);
    die();
}
add_action('wp_ajax_add_later_post', 'add_later_post');
add_action('wp_ajax_nopriv_add_later_post', 'add_later_post');
