<?php
/**
 * Template Functions
 * 
 * @package DNS-theme
 */
function remove_core_updates(){
    global $wp_version;return(object) array('last_checked'=> time(),'version_checked'=> $wp_version,);
}
add_filter('pre_site_transient_update_plugins','remove_core_updates');

function dns_remove_default_image_sizes( $sizes ) {
  /* Default WordPress */
  unset( $sizes[ 'medium' ]);          
  unset( $sizes[ 'medium' ]);        
  unset( $sizes[ 'medium_large' ]);    
  unset( $sizes[ 'large' ]);  
  /* With WooCommerce */
  unset( $sizes[ 'shop_thumbnail' ]);  // Remove Shop thumbnail (180 x 180 hard cropped)
  unset( $sizes[ 'shop_single' ]);     // Shop single (600 x 600 hard cropped)
  
  return $sizes;
}
add_filter( 'intermediate_image_sizes_advanced', 'dns_remove_default_image_sizes' );


function get_dynamic_sidebar($index = 1){
	$sidebar_contents = "";
	ob_start();
	dynamic_sidebar($index);
	$sidebar_contents = ob_get_clean();
	return $sidebar_contents;
}

if (!function_exists('flex_col')) {
	function flex_col($area = 'main'){
		if (get_dynamic_sidebar('sidebar-left') != '' && 
			get_dynamic_sidebar('sidebar-right') != '') {
            $main_col = 'col-md-6 col-sm-6 col-xs-12';
			$sidebar = 'col-md-3 col-sm-3 col-xs-12';
		}elseif(get_dynamic_sidebar('sidebar-left') != '' || 
			get_dynamic_sidebar('sidebar-right') != ''){
            $main_col = 'col-lg-8 col-md-8 col-sm-8 col-xs-12';
			$sidebar = 'col-lg-4 col-md-4 col-sm-4 col-xs-12';
		}else {
            $main_col = 'col-lg-12 col-md-12 col-sm-12 col-xs-12';
            $sidebar = 'col-lg-12 col-md-12 col-sm-12 col-xs-12';
		}
        if ($area == 'sidebar') {
            echo $sidebar;
        }else{
            echo $main_col;
        }	
    }
}


function fx_nav_pager() {
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
        'prev_text' => '&larr; Trước',
        'next_text' => 'Sau &rarr;',
    ));
    
    if (is_array($pages)) {
        $current_page = ( get_query_var('paged') == 0 ) ? 1 : get_query_var('paged');
        echo '<div class="text-center"><ul class="pagination">';
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
        echo '</ul></div>';
    }
}

function flex_menu($theme_location='primary',$menu_id='',$menu_class='nav navbar-nav'){
    return wp_nav_menu(array('theme_location'=> $theme_location, 
                            'container'     => false, 
                            'menu_class'    => $menu_class,
                            'menu_id'       => $menu_id,
                            'walker'        => new Fx_Walker_Nav_Menu())
                    );
}

function flex_social(){
    global  $pl_options;
    $ouput = '';
        

        if (check_social('ss_twitter') == true) {
            $ouput .= '<li class="twitter">
                            <a target="_blank" title="Twitter" href="'.$pl_options['ss_twitter'].'">
                                <i class="fa fa-twitter"></i>
                            </a>
                        </li>';
        }

        if (check_social('ss_ldin') == true) {
            $ouput .= '<li class="linkedin">
                            <a target="_blank" title="Linkedin" href="'.$pl_options['ss_ldin'].'">
                                <i class="fa fa-linkedin"></i>
                            </a>
                        </li>';
        }
        
        if (check_social('ss_gplus') == true) {
            $ouput .= '<li class="google-plus">
                            <a target="_blank" title="Google Plus" href="'.$pl_options['ss_gplus'].'">
                                <i class="fa fa-google-plus"></i>
                            </a>
                        </li>';
        }  

        

        if (check_social('ss_ytube') == true ) {
            $ouput .= '<li class="youtube">
                            <a target="_blank" title="Youtube" href="'.$pl_options['ss_ytube'].'">
                                <i class="fa fa-youtube "></i>
                            </a>
                        </li>';
        }  
        
        if (check_social('ss_face') == true) {
            $ouput .= '<li class="facebook">
                            <a target="_blank" title="Facebook" href="'.$pl_options['ss_face'].'">
                                <i class="fa fa-facebook "></i>
                            </a>
                        </li>';
        }

        if (check_social('ss_ingram') == true) {
            $ouput .= '<li target="_blank" class="instagram">
                            <a title="Instagram" href="'.$pl_options['ss_ingram'].'">
                                <img width="30" src="'.THEME_URL_ASSETS.'/images/instagram.png" />
                            </a>
                        </li>';
        }
        
    if (!empty($ouput)) {
        return '<ul class="social_list">'.$ouput.'</ul>';
    }
    return '';
}

function check_social($value){
    if (get_toption($value) && get_toption($value) != ''){
        return true;
    }else{
        return false;
    }
}

function fltrim($string){
    $arr = array("\r\n", "\r", "\n", "\t", "  ", "    ", "    ");
    $rep = array("", "", "", "", " ", " ", " ");
    $string = str_replace($arr, $rep, $string);
    return $string;
}

function get_toption($option){
    global  $dns_options;
    return $dns_options[$option];
}

function the_toption($option ,$type = ''){
    global  $dns_options;
    if ($type!='') {
       switch ($type) {
            case 'image':
                print $dns_options[$option]['url'];
                break;
            default:
                print do_shortcode(fltrim($dns_options[$option]), false );
                break;
        }
    }else{
        print do_shortcode(fltrim($dns_options[$option]), false );
    }
}

/*
* Get BTN Share 
*/
function get_share($pid)
{
    $out = '<ul class="dns_social_list">
         <li class="social_title">
            <span>Chia sẻ: </span>
        </li>
        <li class="social_iterm">
            <a title="Facebook" href="https://www.facebook.com/sharer.php?u='.get_the_permalink($pid, false ).'" class="facebook" target="_blank" rel="nofollow"><i class="fa fa-facebook"></i></a>
        </li>
        <li class="social_iterm">
            <a title="Twitter" href="https://twitter.com/share?url='.get_the_permalink($pid, false ).'&amp;text='.get_the_title($pid).'" class="twitter" target="_blank" rel="nofollow"><i class="fa fa-twitter"></i></a>
        </li>
        <li class="social_iterm">
            <a title="Pinterest" href="https://pinterest.com/pin/create/button/?url='.get_the_permalink($pid, false ).'&media=dfsd&description='.get_the_title($pid ).'" class="pinterest" target="_blank" rel="nofollow"><i class="fa fa-pinterest-p"></i></a>
        </li>
    </ul>';
    return $out;
}

/**
 * Functions Breadcrumb
 * Author DuyDongICT
 * DongNam Solutions
 */

function dns_bootstrap_breadcrumb($home_icon = 'Trang chủ',$show_blogs = true,$show_container = false, $custom_post_types = true) {
    wp_reset_query();
    global $post;
    $breadcrumb = '';
    $is_custom_post = $custom_post_types ? is_singular( $custom_post_types ) : false;
    
    if (!is_front_page()) {
        $home_title = ( $home_icon )?$home_icon: bloginfo('name');
        $breadcrumb .=  '<ol class="dns-breadcrumb breadcrumb">';
        // Home
        $breadcrumb .=  '<li><a href="'. get_option('home'). '">'.$home_title. '</a></li>';
        if (is_home()) {
            $home_post = get_option( 'page_for_posts' );
            $breadcrumb .=  '<li class="active">'.get_the_title($home_post).'</li>';
        }else{
            if ( has_category() && is_single()) {
                $breadcrumb .=  '<li >
                <a href="'.esc_url( get_permalink( get_page( get_the_category($post->ID) ) ) ).'">';

                $all_cat = get_the_category(get_the_ID());
                $cats = array();
                foreach ($all_cat as $key => $cat) {
                    $cats[] = '<a href="'.get_category_link( $cat->term_id).'">'.$cat->name.'</a>';
                }

                $breadcrumb .=  implode(', ', $cats).'</a></li>';
            }


            $archives = array('post','page');
            if(is_archive() && (!is_tax()  && !is_tag() && !is_category())){
                 $breadcrumb .=  '<li class="active">'.post_type_archive_title( '', false ).'</li>';
            }

            if ( is_category() || is_tax() || is_tag() || is_single() || $is_custom_post ) {
                if ( is_category() ){
                    $breadcrumb .=  '<li class="active">'.get_the_category($post->ID)[0]->name.'</li>';
                }elseif (is_tax() || is_tag()) {
                    $breadcrumb .=  '<li class="active">'.get_queried_object()->name.'</li>';
                }
                    
                $posts_type = array('post','page');
                if ( $is_custom_post && !in_array(get_post_type_object( get_post_type($post) )->name, $posts_type)) {
                    $breadcrumb .=  '<li class="active"><a href="'.get_post_type_archive_link(get_post_type_object( get_post_type($post) )->name).'">'.get_post_type_object( get_post_type($post) )->label.'</a></li>';
                    if ( $post->post_parent ) {
                        $home = get_page(get_option('page_on_front'));
                        for ($i = count($post->ancestors)-1; $i >= 0; $i--) {
                            if (($home->ID) != ($post->ancestors[$i])) {
                                $breadcrumb .=  '<li><a href="';
                                $breadcrumb .=  get_permalink($post->ancestors[$i]); 
                                $breadcrumb .=  '">';
                                $breadcrumb .=  get_the_title($post->ancestors[$i]);
                                $breadcrumb .=  "</a></li>";
                            }
                        }
                    }
                }

                if ( is_single() ){
                     $breadcrumb .=  '<li class="active">'.get_the_title($post->ID).'</li>';
                }elseif ( is_page() && $post->post_parent ) {
                    $home = get_page(get_option('page_on_front'));
                    for ($i = count($post->ancestors)-1; $i >= 0; $i--) {
                        if (($home->ID) != ($post->ancestors[$i])) {
                            $breadcrumb .=  '<li><a href="';
                            $breadcrumb .=  get_permalink($post->ancestors[$i]); 
                            $breadcrumb .=  '">';
                            $breadcrumb .=  get_the_title($post->ancestors[$i]);
                            $breadcrumb .=  "</a></li>";
                        }
                    }
                    $breadcrumb .=  '<li class="active">'.get_the_title($post->ID).'</li>';
                } elseif (is_page()) {
                    $breadcrumb .=  '<li class="active">'.get_the_title($post->ID).'</li>';
                } elseif (is_404()) {
                    $breadcrumb .=  '<li class="active">404</li>';
                }
                   
            } elseif ( is_page() && $post->post_parent ) {
                $home = get_page(get_option('page_on_front'));
                for ($i = count($post->ancestors)-1; $i >= 0; $i--) {
                    if (($home->ID) != ($post->ancestors[$i])) {
                        $breadcrumb .=  '<li><a href="';
                        $breadcrumb .=  get_permalink($post->ancestors[$i]); 
                        $breadcrumb .=  '">';
                        $breadcrumb .=  get_the_title($post->ancestors[$i]);
                        $breadcrumb .=  "</a></li>";
                    }
                }
                $breadcrumb .=  '<li class="active">'.get_the_title($post->ID).'</li>';
            } elseif (is_page()) {
                $breadcrumb .=  '<li class="active">'.get_the_title($post->ID).'</li>';
            } elseif (is_404()) {
                $breadcrumb .=  '<li class="active">404</li>';
            }
        }
        $breadcrumb .=  '</ol>';
    }
    if ($show_container == true) {
        $breadcrumb = sprintf('<div class="container">%s</div>',$breadcrumb);
    }
    if (is_home() && $show_blogs == true) {
        print $breadcrumb;
    }else{
        if (!is_home()) {
            print $breadcrumb;
        }
        
    }
}

function dns_excerpt_length( $length ) {
    return 30;
}
add_filter( 'excerpt_length', 'dns_excerpt_length' );

// Replaces the excerpt "Read More" text by a link
function dns_new_excerpt_more($more) {
    return '...';
}
add_filter('excerpt_more', 'dns_new_excerpt_more');

/* Process Image */
/*
* Get AQResize
*/
if(!function_exists('aq_resize')) {
    function aq_resize( $url, $width = null, $height = null, $crop = null, $single = true, $upscale = true ) {
        if ( defined( 'ICL_SITEPRESS_VERSION' ) ){
            global $sitepress;
            $url = $sitepress->convert_url( $url, $sitepress->get_default_language() );
        }
        if ($url == '') {
            return ;
        }
        $aq_resize = Aq_Resize::getInstance();
        return $aq_resize->process( $url, $width, $height, $crop, $single, $upscale );
    }
}

if(!function_exists('get_dns_image')) {
    function get_dns_image($size=array(600,400),$class='',$url = '') {
        $url = ($url!='')?$url:get_the_post_thumbnail_url(get_the_ID(),'full');
        $imgurl = aq_resize($url,$size[0],$size[1],true);
        return '<img src="'.$imgurl.'" class="dns-thumn img-responsive '.$class.'">';
    }
}

if(!function_exists('get_dns_thumbnail_url')) {
    function get_dns_thumbnail_url($size=array(300,400),$url = '') {
        $url = ($url!='')?$url:get_the_post_thumbnail_url(get_the_ID(),'full');
        $imgurl = aq_resize($url,$size[0],$size[1],true);
        return $imgurl;
    }
}

if(!function_exists('the_dns_image')) {
    function the_dns_image($size=array(600,400),$class='',$url = '') {
      print get_dns_image($size,$class,$url);
    }
}

/* Process Form Link */
add_filter('frm_get_default_value', 'dns_default_value', 10, 3);
function dns_default_value($new_value, $field){
  $curl = home_url('').''.$_SERVER['REQUEST_URI'];;
  if($field->field_key == 'link_product' || $field->field_key == 'link_baiviet'){
    $new_value = $curl;
  }
  return $new_value;
}

/* Set post views */
function dns_set_post_views($postID) {
    $count_key = 'post_views_count';
    $count = get_post_meta($postID, $count_key, true);
    if($count==''){
        $count = 0;
        delete_post_meta($postID, $count_key);
        add_post_meta($postID, $count_key, '0');
    }else{
        $count++;
        update_post_meta($postID, $count_key, $count);
    }
}

function dns_track_post_views($post_id) {
    if ( !is_single() ) return;
    if ( empty ( $post_id) ) {
        global $post;
        $post_id = $post->ID;    
    }
    dns_set_post_views($post_id);
}
add_action( 'wp_head', 'dns_track_post_views');

// function register_jquery_button(){
//     if(is_single() || is_singular('product')){
//         $text_link_1 = ot_get_option('nn_text_link_button_1');
//         $text_link_2 = ot_get_option('nn_text_link_button_2');
//         $link_1 = ot_get_option('nn_link_button_1');
//         $vitri_link_1 = ot_get_option('nn_position_link_button_1');
//         $link_2 = ot_get_option('nn_link_button_2');
//         $vitri_link_2 = ot_get_option('nn_position_link_button_2');
//         if(is_singular('product')){
//             $type = 'product';
//         }else{
//             $type = 'post';
//         }
//         wp_enqueue_script('button-content-jquery',get_template_directory_uri().'/js/add-button-to-content.js');
//         wp_localize_script( 'button-content-jquery', 'bt_object',
//             array( 
//                 'link_1' => $link_1,
//                 'link_2'    =>  $link_2,
//                 'text_link_1'   =>  $text_link_1,
//                 'text_link_2'   =>  $text_link_2,
//                 'position_link_1'   =>  $vitri_link_1,
//                 'position_link_2'   =>  $vitri_link_2,
//                 'type'  =>  $type
//             ) );
//     }
// }
// add_action('wp_enqueue_scripts','register_jquery_button');


function dns_get_posts($post_id,$data =  'next' ,$type ='post', $limit = 5)
{
    global  $wpdb;
    $output = '';

    $sql_pre = "SELECT
				    ID AS pid
				FROM
				    `{$wpdb->prefix}posts`
				WHERE
				    `post_status` = 'publish' AND `post_type` = '$type' AND `ID` < $post_id
				ORDER BY
				    `ID` DESC
				LIMIT $limit";  

	$sql_next = "SELECT
				    ID AS pid
				FROM
				    `{$wpdb->prefix}posts`
				WHERE
				    `post_status` = 'publish' AND `post_type` = '$type' AND `ID` > $post_id
				ORDER BY
				    `ID` ASC
				LIMIT $limit";
	if ($data == 'next') {
		$data_ret = $wpdb->get_results($sql_next,OBJECT );
	}else{
		$data_ret = $wpdb->get_results($sql_pre,OBJECT );
	}
	$pids = array();
    if (!empty($data_ret)) {
    	foreach ($data_ret as  $var) {
    		$pids[] = $var->pid;
    	}
    	return $pids;
    }
    
    return $pids;          
}

/// Get post by xxx
function the_post_by($pl_query = array(),$title = '',$layout = 'slider_image',$has_container = 1, $hidetitle = 0)
{
	if ( $pl_query->have_posts() ) {
		$containercl = ($has_container == 1)?'container':'';
		switch ($layout) {
			case 'slider_image':
		?>
			<div  class="dns-list_post dns-owl_list ">
	            <div class="<?=$containercl;?>">
	            	<?php if ($hidetitle === 0): ?>
		            	<div class="group-title text-left">
			            	<h3 class="block-title "><?=$title; ?></h3>
			            </div>
			        <?php endif; ?>
		            
					<div class="dns-crpost_wp">
						<div class="dns-crpost owl-carousel owl-theme">
							<?php 
								while ( $pl_query->have_posts() ) :
									$pl_query->the_post();
									set_query_var( 'layout', 'has_image' );
									get_template_part('template_part/post', 'loop');
					        	endwhile;
					        	wp_reset_postdata();
					        ?>
						</div>
					</div>
	            </div>
			</div>
		<?php
			break;

			case 'image_text':
			?>
				<div  class="dns-list_post dns-owl_list ">
		            <div class="<?=$containercl;?>">
		            	<?php if ($hidetitle === 0): ?>
			            	<div class="group-title text-left">
				            	<h3 class="block-title "><?=$title; ?></h3>
				            </div>
				        <?php endif; ?>
			            
						<div class="dns-crpost_wp ">
							<div class="archive_list row">
								<?php 
									while ( $pl_query->have_posts() ) :
										$pl_query->the_post();
										set_query_var( 'layout', 'has_image' );
										set_query_var( 'has_slider', 0 );
										get_template_part('template_part/post', 'loop');
						        	endwhile;
						        	wp_reset_postdata();
						        ?>
							</div>
						</div>
		            </div>
				</div>
			<?php
				break;

			case 'list_style':
				?>
					<div  class="dns-ls_container">
			            <div class="<?=$containercl;?>">
			            	<?php if ($hidetitle === 0): ?>
				            	<div class="group-title text-left">
					            	<h3 class="block-title "><?=$title; ?></h3>
					            </div>
					        <?php endif; ?>
				            
							<div class="dns-ls_wp">
								<ul class="dns_list_style">
									<?php 
										while ( $pl_query->have_posts() ) :
											$pl_query->the_post();
											set_query_var( 'layout', 'list_title' );
											get_template_part('template_part/post', 'loop');
							        	endwhile;
							        	wp_reset_postdata();
							        ?>
								</ul>
							</div>
			            </div>
					</div>
				<?php 
			break;
            case 'list_price':
                ?>
                    <div  class="dns-ls_container">
                        <div class="<?=$containercl;?>">
                            <?php if ($hidetitle === 0): ?>
                                <div class="group-title text-left">
                                    <h3 class="block-title "><?=$title; ?></h3>
                                </div>
                            <?php endif; ?>
                            
                            <div class="dns-ls_wp">
                                <ul class="dns_list_style">
                                    <?php 
                                        while ( $pl_query->have_posts() ) :
                                            $pl_query->the_post();
                                            set_query_var( 'layout', 'list_title' );
                                            get_template_part('template_part/post', 'loop');
                                        endwhile;
                                        wp_reset_postdata();
                                    ?>
                                </ul>
                            </div>
                        </div>
                    </div>
                <?php 
            break;

		}
	}
}


