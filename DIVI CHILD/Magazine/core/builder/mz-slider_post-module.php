<?php
/*
* Module Magazine Slider Post
*/
class Magazine_Module_Slider_Post extends ET_Builder_Module {
	function init() {
		$this->name       = esc_html__( 'Magazine Slider Post', 'sa_builder' );
		$this->slug       = 'et_pb_mz_slider_post';
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
		if ($post_data != '') {
			$output = sprintf('<div id="%s" class="%s">
								%s
							</div>',
							$module_class,
							$module_id,
							$post_data);
		}
		return $output;
	}

	function get_blogs_post($term_id,$numpost = 3){
		$args = array('post_type' => 'post',
						'posts_per_page' => $numpost ,
						'post_status' => 'publish',
					);
		if ( '' !== $term_id ){
			$args['cat'] = $term_id;
		}
		$big_sl = $smslider = $output ='';
		$blog_twqr = new WP_Query( $args );
		$output = array();
		if ($blog_twqr->have_posts()) {
			$i =1;
			
			while ($blog_twqr->have_posts()) {
				$blog_twqr->the_post();	
				$cat = get_the_category(get_the_ID());
				
				$url_thumb = '';
				$social = '<div class="mz-social-slider">
								'.get_share(get_the_ID()).'
							</div>';
				if (has_post_thumbnail()) {
					$url_thumb=get_the_post_thumbnail_url(get_the_ID(),'full');
				}else{
					$url_thumb = '/wp-content/uploads/home_banner.jpg';
				}
				
	 		  	$big_sl .= '<div class="sp-slide">
	 		  				<img class="sp-image" data-src="'.$url_thumb.'" data-retina="'.$url_thumb.'" />
				 			<div class="container">
				 				<div class="row_fl">
				 					<div class="col-sm-7 col-xs-12">
				 						<div class="mz-slider-big-text">
											<div class="mz-category-slider">
												<span class="sp-layer" data-show-transition="left" data-show-delay="200">'.$cat[0]->name.'</span>
											</div>
											<div class="mz-title-slider">
												<h3 class="sp-layer" data-show-transition="left" data-show-delay="400">'.get_the_title().'</h3>
											</div>
											<div class="mz-content-slider sp-layer" data-show-transition="left" data-show-delay="400">
												'.get_the_excerpt().'
											</div>
											<div class="mz-slider-more">
												<a href="'.get_permalink(get_the_ID()).'" class="sp-layer" data-show-transition="left" data-show-delay="400">See more</a>
											</div>
										</div>
									</div>
								</div> 
							</div>
							'.$social.'
					 	  </div>';
				$smslider .= sprintf('
			 		  <div class="sp-thumbnail">
						<div class="mz-slthum-inner">
							<div class="mz-slicon"><i class="fa fa-play-circle"></i></div>
							<h4 class="mz-slthum-title">'.substr(get_the_title(), 0,22).'</h4>
							<div class="mz-slthum-desc">'.wp_trim_words(get_the_excerpt(), 10, '.' ).'</div>
						</div>
					  </div>');	 	  


			}
			wp_reset_query();
			if ($big_sl!='') {
				$output = sprintf('<div class="mz-slider-home slider-pro">
										<div class="sp-slides">
											%s
										</div>
										<div class="sp-thumbnails hidden-xs">
											%s
										</div>
									</div>',$big_sl,$smslider);
			}
		}
		return $output;
	}

}

new Magazine_Module_Slider_Post;
