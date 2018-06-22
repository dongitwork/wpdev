<?php
/*
* Module SA Carousel Product
*/
class SA_Module_Carousel_Product extends ET_Builder_Module {
	function init() {
		$this->name       = esc_html__('SA Carousel Product', 'sa_builder' );
		$this->slug       = 'et_pb_sa_crproduct';
		$this->fb_support = true;

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
					'use_terms' => true,
					'term_name' => 'product_cat',
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
		$sa_product = $this->sa_get_product($include_categories,$posts_number);
		if ($sa_product != '') {
			$output = sprintf('<div class="%s" id="%s">
									<div class="sa_crproduct_wp">
										<div class="row_fl">
											<div class="col-xs-12 col-sm-12 sa-md-5">
												<div class="sa-cr_left">
													<h2 class="sa-cr_title">%s</h2>
												</div>
											</div>
											<div class="col-xs-12 col-sm-12 sa-md-7">
												<div class="sa-cr_right">
													<div class="sa-cr_carousel owl-carousel owl-theme">
														%s
													</div>
												</div>
											</div>
										</div>
									</div>
								</div>',$module_class,$module_id,$title,$sa_product);
		}
		return $output;

	}

	function sa_get_product($term_id,$numpost = 3){
		$args = array('post_type' => 'product',
						'posts_per_page' => $numpost ,
						'post_status' => 'publish',
					);
		if ( '' !== $term_id ){
			$args['tax_query'] = array(
									array(
										'taxonomy' => 'product_cat',
										'field'    => 'term_id',
										'terms'    => explode(',', $term_id),
									),
								 );
		}
		$sacr_pro = new WP_Query( $args );
		$output = '';
		if ($sacr_pro->have_posts()) {
			$i =1;
			while ($sacr_pro->have_posts()) {
				$sacr_pro->the_post();	
				global $product;
				$product_detail = $product->get_data();
				
				$output .= '<div class="sa-procr_iterm">
								<div class="sa-procr_iterm_inner text-center">
									<div class="sa-procr_image">
										'.get_the_post_thumbnail(get_the_ID(), 'full', '' ).'
									</div>
									<a href="'.get_the_permalink().'">
										<h2 class="sa-procr_title">'.get_the_title().'</h2>
									</a>
									<div class="sa-procr_desc">
										'.wp_trim_words($product_detail['short_description'], 4, '' ).'
									</div>
									<div class="sa-procr_btn">
										<a data-product_id="'.get_the_ID().'" href="#" class=" yith-wcqv-button sa-procr_addcart">
											<span class="fa fa-plus"></span> Add to cart
										</a>
									</div>
								</div>
							</div>';
			}
			wp_reset_query();
		}
		return $output;
	}

}

new SA_Module_Carousel_Product;
