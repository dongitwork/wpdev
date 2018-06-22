<?php
/*
* Module Magazine Carousel Post
*/
class Magazine_Module_Carousel_Post extends ET_Builder_Module {
	function init() {
		$this->name       = esc_html__('Magazine Carousel Post', 'sa_builder' );
		$this->slug       = 'et_pb_mz_carousel_post';
		$this->fb_support = true;
		$this->fullwidth  = true;

		$this->whitelisted_fields = array(
			'title',
			'posts_number',
			'include_categories',
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
					'use_terms'    => false,
				),
				'description'      => esc_html__( 'Choose which categories you would like to include in the feed.', 'sa_builder' ),
				'toggle_slug'      => 'main_content',
				'computed_affects' => array(
					'__posts',
				),
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

		$module_class = ET_Builder_Element::add_module_order_class( $module_class, $function_name );
		$output = '';
		$post_data = $this->get_blogs_post($include_categories,$posts_number);
		
		$output = sprintf('<div class="%s" id="%s">
								<div class="mz-crs-wp owl-carousel owl-theme">
									%s
								</div>
								<div class="custom_dots_wp">
									<div class="container">
										<div id="custom_dots"></div>
									</div>
								</div>
							</div>',$module_class,$module_id,$post_data);

		return $output;

	}

	function get_blogs_post($term_id,$numpost = 1){
		$args = array('post_type' => 'post',
						'posts_per_page' => $numpost ,
						'post_status' => 'publish',
					);
		if ( '' !== $term_id ){
			$args['cat'] = $term_id;
		}
		$blog_twqr = new WP_Query( $args );
		$output = '';
		if ($blog_twqr->have_posts()) {
			$i =1;
			while ($blog_twqr->have_posts()) {
				$blog_twqr->the_post();	
				///$url = get_the_post_thumbnail_url(get_the_ID(),'full');
				$cat = get_the_category(get_the_ID());
				$output .= '<div class="mz-crs-iterm" >
								<div class="mz-crs-iterm_inner">
									<a href="'.get_permalink(get_the_ID()).'"><div class="mz-crs-image">'.get_image_size().'</div>
									</a>
									<div class="mz-crs-info">
										<div class="container">
											<div class="mz-crs-inner">
												<div class="mz-crs-cat">
													<span>'.$cat[0]->name.'</span>
												</div>
												<h3 class="mz-crs-title">'.get_the_title().'</h3>
												<div class="mz-crs-author">
													-By: <span>'.get_the_author().'</span>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>';
			}
			wp_reset_query();
		}
		return $output;
	}

}

new Magazine_Module_Carousel_Post;
