<?php 
/*
* Ver: 2.0
* Fullwidth
* Include Title desc
* Child muti 
*/

class SA_Builder_Module_List_Product extends ET_Builder_Module {

	function init() {
		$this->name  = esc_html__('SA List Product', 'sa_builder');
		$this->slug            = 'et_pb_sa_lpr';
		$this->fb_support      = true;

		$this->whitelisted_fields = array(
			'title',
			'admin_label',
			'module_id',
			'module_class',
		);

		$this->main_css_element = '%%order_class%%.et_pb_sa_mtestimonials';
		$this->options_toggles = array(
			'general'  => array(
				'toggles' => array(
					'main_content' => esc_html__( 'Main Content','sa_builder' ),
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
				'description' => esc_html__( '', 'sa_builder' ),
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
		$module_id		= $this->shortcode_atts['module_id'];
		$module_class	= $this->shortcode_atts['module_class'];
		$title			= $this->shortcode_atts['title'];
		$module_class = ET_Builder_Element::add_module_order_class( $module_class, $function_name );
		$output = '';
		ob_start();
		$per_page = 4;
		$args = array(
			'post_type' => 'product',
			'orderby' => 'date',
			'order' => 'DESC',
			'posts_per_page' => $per_page,
			'paged' => get_query_var( 'paged' ),
		);
		$products = new WP_Query( $args );
		// Standard loop
		if ( $products->have_posts() ) :
			?>
			<div class="sa-pro_list">
				<div class="row_fl">
					<?php 
						while ( $products->have_posts() ) : $products->the_post();
							get_template_part( 'template_part/product', 'loop' );
						endwhile;
					?>
				</div>
				<div class="sa-fnlink text-center">
					<?php 
						previous_posts_link('<i class="fa fa-long-arrow-left"></i>', $products->max_num_pages);
						next_posts_link('<i class="fa fa-long-arrow-right"></i>', $products->max_num_pages);
					?>
				</div>
			</div>
			<?php 
			wp_reset_postdata();
		endif;

		

		return ob_get_clean();
	}
}
new SA_Builder_Module_List_Product;
