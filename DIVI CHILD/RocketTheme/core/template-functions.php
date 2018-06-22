<?php




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

/* Ajax Project Popup */

add_action( 'wp_ajax_project_iterm', 'ajax_load_project_iterm' );
add_action( 'wp_ajax_nopriv_project_iterm', 'ajax_load_project_iterm' );

function ajax_load_project_iterm()
{
	$pid = $_GET['pid'];
	$termid = $_GET['termid'];
	if (!is_numeric($pid)){die();} 
	$post = get_post($pid);
	if ($post->post_type != 'project') {
		return '';
	}
	$data = get_project_next_pre($pid,$termid);
	$nf= '';
	if ($data['pre']!='') {
		$nf .= '<a href="#"  data-termid="'.$termid.'" data-pitem="'.$data['pre'].'" class="nfpost nfpre"><span class="fa fa-angle-left"></span></a>';
	}
	if ($data['next']!='') {
		$nf .= '<a href="#"  data-termid="'.$termid.'" data-pitem="'.$data['next'].'" class="nfpost nfnext"><span class="fa fa-angle-right"></span></a>';
	}
	$all_gallery = get_field('project_gallery',$pid);
	$imgs = '';
	if (!empty($all_gallery)) {
		foreach ($all_gallery as  $img) {
			if ($img['url'] != '') {
				$imgs .= '<div class="pro-iterm"><img src="'.$img['url'].'" class="imgprs"></div>';
			}
			
		}
	}
	if ($imgs=='') {
		$imgs .= '<div class="pro-iterm">'.get_the_post_thumbnail($post->ID,'full').'</div>';
	}
	$out = '<div class="rkt_project_popup">
		<div class="rkt_project_popup_inner">				
			<div class="project_wppp">
				<div class="project_header">
					<h2 class="block-title project_author">By '.get_the_author_meta('display_name',$post->post_author).'</h2>
					<div class="project_info">
						<h3 class="project_title">'.$post->post_title.'</h3>
						<div class="project_content">
							'.wp_trim_words( $post->post_content, 35, '.' ).'
						</div>
					</div>
				</div>
				<div class="project_slider">
					<div class="project_slider_inner">
						<div class="owl-carousel owl-theme project_carouasel">
							'.$imgs.'
						</div>
					</div>
					<div class="row_fl">
						<div class="col-hidden-xs col-sm-4 text-center"> </div>	
						<div class="col-xs-6 col-sm-4 text-center">
							<div id="pps_nav"></div>
						</div>	
						<div class="col-xs-6 col-sm-4 text-center">
							<div id="pps_counter"></div>
						</div>
					</div>
				</div>
			</div>
			<div class="rkt_proect_next-pre">
				'.$nf.'
				
			</div>
		</div>
	</div>';
	print $out;
	die();
}

function get_project_next_pre($post_id,$termid)
{
	global  $wpdb;
	$output = array();

	$sql_pre = "SELECT p.`ID` as post_id
				FROM wp_posts AS p
				LEFT JOIN wp_term_relationships AS tr 
				ON (p.`ID` = tr.`object_id`)
				LEFT JOIN wp_term_taxonomy AS tt 
				ON (tr.term_taxonomy_id = tt.`term_taxonomy_id`)
				LEFT JOIN wp_terms AS t ON (t.term_id = tt.`term_id`)
				WHERE   p.post_status = 'publish' 
				    AND p.`post_type` = 'project' 
				    AND tt.term_id =  ".$termid."
				    AND p.`ID` < ".$post_id." 
				ORDER BY p.`ID` DESC LIMIT 1";

    $sql_next = "SELECT p.`ID` as post_id
					FROM wp_posts AS p
					LEFT JOIN wp_term_relationships AS tr 
					ON (p.`ID` = tr.object_id)
					LEFT JOIN wp_term_taxonomy AS tt 
					ON (tr.term_taxonomy_id = tt.term_taxonomy_id)
					LEFT JOIN wp_terms AS t ON (t.term_id = tt.term_id)
					WHERE   p.post_status = 'publish' 
					    AND p.`post_type` = 'project' 
					    AND tt.term_id =  ".$termid."
					    AND p.`ID` > ".$post_id." 
					ORDER BY p.`ID` ASC LIMIT 1";


    $data_prev = $wpdb->get_row($sql_pre,OBJECT);
    $data_next = $wpdb->get_row($sql_next,OBJECT);               
    $output['pre'] = ($data_prev->post_id)?$data_prev->post_id:'';
    $output['next'] = ($data_next->post_id)?$data_next->post_id:'';
    return $output;
}

add_action('wp_footer', 'rocket_push_html');
function rocket_push_html()
{
	print '<div class="rkt_ajax_loadding" style="display: none;">
			<div class="rkt_ajax_loadin"><span class="fa fa-spinner fa-pulse fa-3x fa-fw"></span></div>
		</div>';
}
/*
* Themes Customizer option for child divi theme 
*/
add_action('customize_register', 'rocket_theme_customize_theme');
function rocket_theme_customize_theme( $wp_customize ) {
    $wp_customize->remove_section( 'et_color_schemes');
    $wp_customize->add_section( 'rk_color_schemes' , array(
        'title'       => esc_html__( 'Rocket Color Schemes', 'Divi' ),
        'priority'    => 0,
        'description' => esc_html__( 'Note: Color settings set above should be applied to the Default color scheme.', 'Divi' ),
    ) );
    $wp_customize->add_setting( 'et_divi[main_color]', array(
        'default'       => '#186ded',
        'type'          => 'option',
        'capability'    => 'edit_theme_options',
        'sanitize_callback' => 'et_sanitize_alpha_color',
    ));

    $wp_customize->add_control( new ET_Divi_Customize_Color_Alpha_Control( $wp_customize, 'et_divi[main_color]', array(
        'label'     => esc_html__( 'Theme Primary Color', 'Divi' ),
        'section'   => 'rk_color_schemes',
        'settings'  => 'et_divi[main_color]',
    )));

    $wp_customize->add_setting( 'et_divi[secon_color]', array(
        'default'       => '#28a7fb',
        'type'          => 'option',
        'capability'    => 'edit_theme_options',
        'sanitize_callback' => 'et_sanitize_alpha_color',
    ) );

    $wp_customize->add_control( new ET_Divi_Customize_Color_Alpha_Control( $wp_customize, 'et_divi[secon_color]', array(
        'label'     => esc_html__( 'Theme Secondary Color', 'Divi' ),
        'section'   => 'rk_color_schemes',
        'settings'  => 'et_divi[secon_color]',
    )));


    /* Hook custom button*/
    $wp_customize->add_setting( 'et_divi[btn_main_color]', array(
        'default'       => '#0e1764',
        'type'          => 'option',
        'capability'    => 'edit_theme_options',
        'sanitize_callback' => 'et_sanitize_alpha_color',
    ));

    $wp_customize->add_control( new ET_Divi_Customize_Color_Alpha_Control( $wp_customize, 'et_divi[btn_main_color]', array(
        'label'     => esc_html__( 'Button Primary Color', 'Divi' ),
        'section'   => 'rk_color_schemes',
        'settings'  => 'et_divi[btn_main_color]',
    )));

    $wp_customize->add_setting( 'et_divi[btn_secon_color]', array(
        'default'       => '#0155a3',
        'type'          => 'option',
        'capability'    => 'edit_theme_options',
        'sanitize_callback' => 'et_sanitize_alpha_color',
    ) );

    $wp_customize->add_control( new ET_Divi_Customize_Color_Alpha_Control( $wp_customize, 'et_divi[btn_secon_color]', array(
        'label'     => esc_html__( 'Button Secondary Color', 'Divi' ),
        'section'   => 'rk_color_schemes',
        'settings'  => 'et_divi[btn_secon_color]',
    )));


}

// 
function rock_theme_color_choices()
{
    return apply_filters( 'rock_theme_color_choices', array(
        'blue'      => esc_html__( 'Blue', 'rkt_theme' ),
        'red'      => esc_html__( 'Red', 'rkt_theme' ),
        'green'  => esc_html__( 'Green', 'rkt_theme' )
    ) );
}


add_action('wp_head', 'rocket_push_css_color');
function rocket_push_css_color(){
    $main_color = et_get_option( 'main_color' );
    $secon_color = et_get_option( 'secon_color' );
    $btn_main_color = et_get_option( 'btn_main_color' );
    $btn_secon_color = et_get_option( 'btn_secon_color' );
    $output = '.et_pb_button.rkt-btn.btn-color,
				.rkt-btn.btn-color,
				.et_pb_contact_submit.et_pb_button {
					background: '.$btn_main_color.' !important;
					color: #fff !important;
					background-image: linear-gradient(to right, '.$btn_main_color.', '.$btn_secon_color.') !important
				}

				.et_pb_button.rkt-btn.btn-color:hover,
				.rkt-btn.btn-color:hover,
				.et_pb_contact_submit.et_pb_button:hover {
					background-image: linear-gradient(to left, '.$btn_main_color.', '.$btn_secon_color.') !important
				}

				.rkt-btn.btn-border {
					-webkit-background-clip: text;
					background-clip: text;
					-webkit-text-fill-color: transparent;
					background-image: linear-gradient(to right, '.$btn_main_color.', '.$secon_color.') !important;
					border: solid 2px '.$btn_secon_color.'
				}

				.rocket_wp_tabs .data_tab_title .tab_title.active .icon_tab span {
					background-image: linear-gradient(58deg, '.$main_color.', '.$secon_color.')
				}

				.portfolio_wp .portfolio_author:before,
				.what_new_wp .whatnew_iterm  .event_bg:after {
					background-image: linear-gradient(to right, '.$main_color.', '.$secon_color.')
				}

				.rkt-product-iterm .et_pb_blurb_description .btn-read-more:after {
					border: solid 1px '.$secon_color.';
					color: '.$secon_color.';
					-webkit-text-fill-color: '.$secon_color.'
				}

				.what_new_wp .whatnew_iterm .wn_except .wn_more,
				.full-width_tt .tt_full-slider .ttiterm .job_company,
				.what_new_wp .owl-nav [class*="owl-"] {
					color: '.$main_color.' !important
				}

				.rkt-tab_custom .et_pb_tabs_controls li.et_pb_tab_active a,
				.portfolio_wp .portfolio_author {
					color: '.$secon_color.' !important
				}

				.rkt-tab_custom .et_pb_tabs_controls li.et_pb_tab_active a {
					border-color: '.$secon_color.' !important
				}

				.rkt_team,
				.rkt-product-iterm {
					border: 1px solid '.$secon_color.'
				}

				#home-banner,
				#home_bg,
				#main-header,
				.rkt-banner-header {
					background-image: linear-gradient(to right, '.$main_color.', '.$secon_color.')
				}

				.rkt_icon_text>i,
				.rkt-left-icon .et_pb_module_header,
				.rkt-left-icon .et-pb-icon,
				.rkt-call_to_action .et_pb_module_header,
				.rkt_pricing_tables .rkt_pricing_iterm .rkt_pricing_header .rkt_price_wrap .rkt_price_group .big_price,
				.portfolio_wp .owl-nav [class*="owl-"]:hover i:before,
				.portfolio_wp .portfolio_title,
				.rkt-product-iterm .et_pb_blurb_description .btn-read-more,
				.et_pb_widget_area_left h4.widgettitle,
				#sidebar h4.widgettitle,
				h2.block-title {
					-webkit-background-clip: text;
					background-clip: text;
					-webkit-text-fill-color: transparent;
					background-image: linear-gradient(to right, '.$main_color.', '.$secon_color.')
				}

				.rocket_wp_tabs .data_tab_title .icon_tab .et-pb-icon,
				.rocket_wp_tabs .data_tab_content .tab_content .icon_tab .et-pb-icon,
				.rocket_wp_tabs .data_tab_title .icon_tab span:before,
				.rocket_wp_tabs .data_tab_content .tab_content .icon_tab span:before {
					-webkit-background-clip: text;
					background-clip: text;
					-webkit-text-fill-color: transparent;
					background-image: linear-gradient(58deg, '.$main_color.', '.$secon_color.')
				}

				.rkt-product-iterm .et_pb_main_blurb_image {
					background-image: linear-gradient(58deg, '.$main_color.', '.$secon_color.')
				}

				.rkt-product-iterm .et_pb_module_header:after,
				.rkt_pricing_tables .rkt_pricing_iterm.rkt_iterm_featured .rkt_pricing_subtitle,
				.rkt-call_to_action.rkt_border-conten .et_pb_promo_description:after,
				.rkt-call_to_action.rkt_border-title h2.et_pb_module_header:after {
					background-image: linear-gradient(to right, '.$main_color.', '.$secon_color.')
				}

				.portfolio_wp .owl-nav [class*="owl-"] i:after {
					-webkit-text-fill-color: '.$main_color.'
				}

				.portfolio_wp .owl-nav .owl-prev:hover i:before {
					background-image: linear-gradient(to left, '.$main_color.', '.$secon_color.')
				}

				.rkt_pricing_tables .rkt_pricing_iterm .rkt_pricing_header .rkt_price_wrap,
				.rkt_pricing_tables .rkt_pricing_iterm.rkt_iterm_featured {
					border: solid 1px '.$main_color.'
				}

				.rkt_team .rkt_team_image_inner img {
					border: solid 2px '.$main_color.'
				}

				.full-width_tt {
					background-image: linear-gradient(141deg, '.$main_color.', '.$secon_color.')
				}

				.rkt_pricing_tables .rkt_pricing_iterm .rkt_pricing_content ul li:before {
					color: '.$secon_color.'
				}

				.rkt_team .rkt_team_inner .rkt_team_skill ul li {
					background-color: '.$secon_color.'
				}

				.et_pb_rkt_project_iterm .rkt-projects-carousels .rkt_prc-info .portfolio_title,
				.et_pb_rkt_project_iterm .rkt-projects-title,
				.rkt_blogs_list .rkt_blog-iterm .rkt-group-title:after,
				.rkt_blogs_list .rkt_blog-iterm  .rkt-blog-meta .fa:before,
				.rkt_blogs_list .rkt_blog-iterm  .rkt-btn-more,
				.rkt_blogs_list .rkt-group-title .rkt-blog-title {
					background-image: -moz-linear-gradient(0deg, '.$main_color.' 0%, '.$secon_color.' 100%);
					background-image: -webkit-linear-gradient(0deg, '.$main_color.' 0%, '.$secon_color.' 100%);
					background-image: -ms-linear-gradient(0deg, '.$main_color.' 0%, '.$secon_color.' 100%)
				}

				.rktpj-layout-light .rkt-prt-header .rkt-prt-tabs li a.active {
					color: '.$secon_color.';
					border-bottom: solid 5px '.$secon_color.'
				}

				.et_pb_rkt_project_iterm .rkt-projects-carousels .rkt_prc-info .portfolio_author:before {
					background-color: '.$main_color.'
				}

				.et_pb_rkt_project_iterm .rkt-projects-carousels .rkt_prc-info .portfolio_author {
					color: '.$secon_color.';
					-webkit-text-fill-color: '.$secon_color.'
				}

				.et_pb_rkt_project_iterm .rkt-projects-carousels .owl-nav .owl-prev:hover i:before {
					background-image: linear-gradient(to left, '.$main_color.', '.$secon_color.')
				}

				.et_pb_rkt_project_iterm .rkt-projects-carousels .owl-next:hover i:before {
					background-image: linear-gradient(to right, '.$main_color.', '.$secon_color.')
				}';

   print '<style type="text/css">'.$output.'</style>';
}