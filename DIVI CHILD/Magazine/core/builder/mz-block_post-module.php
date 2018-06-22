<?php
/*
* Module Magazine Block Post
*/
class Magazine_Module_Block_Post extends ET_Builder_Module {
	function init() {
		$this->name       = esc_html__( 'Magazine Block Post', 'sa_builder' );
		$this->slug       = 'et_pb_mz_bpost';
		$this->fb_support = true;

		$this->whitelisted_fields = array(
			'title',
			'posts_number',
			'include_categories',
			'layout_type',
			'admin_label',
			'module_id',
			'module_class',
		);

		$this->fields_defaults = array();

		$this->options_toggles = array(
			'general'  => array(
				'toggles' => array(
					'main_content' => esc_html__( 'Main Content', 'sa_builder' ),
				),
			),
			'advanced' => array(
				'toggles' => array(
					'text'       => array(
						'title'    => esc_html__( 'Text', 'sa_builder' ),
						'priority' => 1,
					),
				),
			),
		);

		$this->advanced_options = array();
		$this->custom_css_options = array();
	}

	function get_fields() {
		$fields = array(
			'title' => array(
				'label'       => esc_html__( 'Title', 'sa_builder' ),
				'type'        => 'text',
				'description' => esc_html__('Title displayed above on the tabs.', 'sa_builder' ),
				'toggle_slug'       => 'main_content',
			),

			'posts_number' => array(
				'label'             => esc_html__('Posts Number','sa_builder' ),
				'type'              => 'text',
				'option_category'   => 'configuration',
				'description'       => esc_html__( 'Choose how much posts you would like to display per page.', 'sa_builder' ),
				'computed_affects'   => array('__posts',),
				'toggle_slug'       => 'main_content',
			),

			'include_categories' => array(
				'label'            => esc_html__( 'Include Categories', 'sa_builder' ),
				'renderer'         => 'et_builder_include_categories_option',
				'option_category'  => 'basic_option',
				'renderer_options' => array(
					'use_terms' => false,
				),
				'description'      => esc_html__( 'Choose which categories you would like to include in the feed.', 'sa_builder' ),
				'toggle_slug'      => 'main_content',
				'computed_affects' => array(
					'__posts',
				),
			),

			'layout_type' => array(
				'label'             => esc_html__( 'Layout', 'sa_builder' ),
				'type'              => 'select',
				'option_category'   => 'configuration',
				'options'           => array(
					'TopNew' => esc_html__( 'Grid TopNew', 'sa_builder' ),
					'Grid'  => esc_html__( 'Grid Colunm', 'sa_builder' ),
				),
				'description'       => esc_html__( 'Toggle between the various blog layout types.', 'sa_builder' ),
				'toggle_slug' => 'main_content',
			),

			'admin_label' => array(
				'label'       => esc_html__( 'Admin Label', 'sa_builder' ),
				'type'        => 'text',
				'description' => esc_html__( 'This will change the label of the module in the builder for easy identification.', 'sa_builder' ),
				'toggle_slug' => 'admin_label',
			),

			'module_id' => array(
				'label'           => esc_html__( 'CSS ID', 'sa_builder' ),
				'type'            => 'text',
				'option_category' => 'configuration',
				'tab_slug'        => 'custom_css',
				'toggle_slug'     => 'classes',
				'option_class'    => 'et_pb_custom_css_regular',
			),

			'module_class' => array(
				'label'           => esc_html__( 'CSS Class', 'sa_builder' ),
				'type'            => 'text',
				'option_category' => 'configuration',
				'tab_slug'        => 'custom_css',
				'toggle_slug'     => 'classes',
				'option_class'    => 'et_pb_custom_css_regular',
			),
		);
		return $fields;
	}

	function shortcode_callback( $atts, $content = null, $function_name ) {
		$module_id           = $this->shortcode_atts['module_id'];
		$module_class        = $this->shortcode_atts['module_class'];
		$posts_number        = $this->shortcode_atts['posts_number'];
		$include_categories  = $this->shortcode_atts['include_categories'];
		$title             	 = $this->shortcode_atts['title'];
		$layout_type         = $this->shortcode_atts['layout_type'];

		$module_class = ET_Builder_Element::add_module_order_class( $module_class, $function_name );
		$output = '';

		if ($layout_type == 'Grid') {
			$post_data = $this->get_gird_post($include_categories,$posts_number);
			$output = sprintf('<div  id="%s" class="%s"> 
									<div class="mz-ymal-posts">
									<div class="mz-ymal-posts_list">
										%s
									</div>
								</div></div>',$module_id,$module_class,$post_data['all_post']);
		}else{
			$post_data = $this->get_topnew_post($include_categories,$posts_number);
			$output = sprintf('<div  id="%s" class="%s"> 
									<div class="mz-topnew-posts">
									<div class="mz-topnew-posts_list">
										%s
									</div>
								</div></div>',$module_id,$module_class,$post_data['all_post']);
		}
		return $output;

	}

	public function get_topnew_post($term_id,$numpost = 3){
		$args = array('post_type' => 'post',
						'posts_per_page' => $numpost ,
						'post_status' => 'publish',
					);
		if ( '' !== $term_id ){
			$args['cat'] = $term_id;
		}
		$blog_twqr = new WP_Query( $args );
		$all_post = '';
		$output = array();
		if ($blog_twqr->have_posts()) {
			$i = 1;
			$all_post .= '<div class="row_fl">';
			while ($blog_twqr->have_posts()) {
				$blog_twqr->the_post();	
				$cat = get_the_category(get_the_ID());
				$comments_count = wp_count_comments(get_the_ID());
				if ($i == 1) {
					$all_post .= '<div class="col-xs-12">
									<div class="mz-tn-piterm">
										<div class="mz-topnew-cat">
											<span>'.$cat[0]->name.'</span>
										</div>
										<a href="'.get_the_permalink().'">
											<h3 class="mz-topnew-ptitle">
												'.get_the_title().'
											</h3>
										</a>
										<div class="mz-topnew-pcontent">'.wp_trim_words( get_the_excerpt(), 30, '.' ).'</div>
										<div class="mz-ymal-pmore text-left">
											<a href="'.get_the_permalink().'">Read Article <i class="fa fa-long-arrow-right"></i></a>
											<a class="mz-tncm"><i class="fa fa-comments-o"></i> '.$comments_count->total_comments.'</a>
											<a class="mz-tnrlt" alt="Read Later" title="Read Later" id="'.get_the_ID().'"><i class="fa fa-bookmark "></i> Read later</a>
										</div>
										<div class="mz-atm-author">
												-By: <span>'.get_the_author().'</span>
										</div>
										<div class="mz-topnew-pimages">
											'.get_blog_image('imgblog_1','center-block').'
										</div>
									</div>
								</div>';
				}else{
					$all_post .= '<div class="col-xs-12 col-sm-6 col-md-6">
									<div class="mz-topnew-piterm">
										<div class="mz-topnew-pimages">
											'.get_blog_image('imgblog_2','center-block').'
										</div>
										<div class="mz-topnew-cat">
											<span>'.$cat[0]->name.'</span>
										</div>
										<a href="'.get_the_permalink().'">
											<h3 class="mz-topnew-ptitle">
												'.get_the_title().'
											</h3>
										</a>
										<div class="mz-atcmlt">
											<a class="mz-atm-author">
												By: <span>'.get_the_author().'</span>
											</a>
											<a class="mz-tncm"><i class="fa fa-comments-o"></i> '.$comments_count->total_comments.'</a>
											<a class="mz-tnrlt" alt="Read Later" title="Read Later" id="'.get_the_ID().'"><i class="fa fa-bookmark "></i></a>
										</div>
										<div class="mz-topnew-pcontent">'.wp_trim_words( get_the_excerpt(), 30, '.' ).'</div>
										<div class="mz-ymal-pmore text-right">
											<a href="'.get_the_permalink().'">Read Article <i class="fa fa-long-arrow-right"></i></a>
										</div>
									</div>
								</div>';
				}
				
				$i++;
			}
			$all_post .= '</div>';
			wp_reset_query();
			if ($post_first != '' || $all_post != '') {
				$output['post_first'] = $post_first;
				$output['all_post'] =  $all_post;
			}
		}
		return $output;
	}

	public function get_gird_post($term_id,$numpost = 3){
		$args = array('post_type' => 'post',
						'posts_per_page' => $numpost ,
						'post_status' => 'publish',
					);
		if ( '' !== $term_id ){
			$args['cat'] = $term_id;
		}
		$blog_twqr = new WP_Query( $args );
		$all_post = '';
		$output = array();
		if ($blog_twqr->have_posts()) {
			$all_post .= '<div class="row_fl">';
			while ($blog_twqr->have_posts()) {
				$blog_twqr->the_post();	
				$all_post .= '<div class="col-xs-12 col-sm-4 col-md-4">
									<div class="mz-ymal-piterm">
										<div class="mz-ymal-pimages">
											'.get_blog_image('imgblog_3','center-block').'
										</div>
										<a href="'.get_the_permalink().'">
											<h3 class="mz-ymal-ptitle">
												'.get_the_title().'
											</h3>
										</a>
										<div class="mz-ymal-pcontent">'.wp_trim_words( get_the_excerpt(), 20, '.' ).'</div>
										<div class="mz-ymal-pmore text-right">
											<a href="'.get_the_permalink().'">Read Article <i class="fa fa-long-arrow-right"></i></a>
										</div>
									</div>
								</div>';
			}
			$all_post .= '</div>';
			wp_reset_query();
			if ($post_first != '' || $all_post != '') {
				$output['post_first'] = $post_first;
				$output['all_post'] =  $all_post;
			}
		}
		return $output;
	}

}

new Magazine_Module_Block_Post;
