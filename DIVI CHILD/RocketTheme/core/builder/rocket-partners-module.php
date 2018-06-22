<?php 
class Rocket_Theme_Module_Partners extends ET_Builder_Module {
	function init() {
		$this->name            = esc_html__( 'Rocket Partners', 'et_builder' );
		$this->slug            = 'et_pb_rk_partners';
		$this->fb_support      = true;
		$this->whitelisted_fields = array(
			'src',
			'gallery_ids',
			'gallery_orderby',
			'gallery_captions',
			'layout_type',
			'admin_label',
			'module_id',
			'module_class',
		);
		$this->main_css_element = '%%order_class%%.et_pb_rk_partners';
		$this->options_toggles = array(
			'general'  => array(
				'toggles' => array(
					'main_content' => esc_html__( 'Main Content', 'et_builder' ),
				),
			),
		);
		$this->advanced_options = array();
		$this->custom_css_options = array();
	}

	function get_fields() {
		$fields = array(
			'title' => array(
				'label'       => esc_html__( 'Title', 'et_builder' ),
				'type'        => 'text',
				'description' => esc_html__( '', 'et_builder' ),
				'toggle_slug' => 'main_content',
			),
			'src' => array(
				'label'           => esc_html__( 'Partners Images', 'et_builder' ),
				'renderer'        => 'et_builder_get_gallery_settings',
				'option_category' => 'basic_option',
				'overwrite'       => array(
					'ids'         => 'gallery_ids',
					'orderby'     => 'gallery_orderby',
					'captions'    => 'gallery_captions',
				),
				'toggle_slug'     => 'main_content',
			),
			'gallery_ids' => array(
				'type'  => 'hidden',
				'class' => array( 'et-pb-gallery-ids-field' ),
				'computed_affects'   => array(
					'__gallery',
				),
			),
			'gallery_orderby' => array(
				'label' => esc_html__( 'Partners Images', 'et_builder' ),
				'type'  => 'hidden',
				'class' => array( 'et-pb-gallery-ids-field' ),
				'computed_affects'   => array(
					'__gallery',
				),
				'toggle_slug' => 'main_content',
			),
			'gallery_captions' => array(
				'type'  => 'hidden',
				'class' => array( 'et-pb-gallery-captions-field' ),
				'computed_affects'   => array(
					'__gallery',
				),
			),
			'layout_type' => array(
				'label'             => esc_html__( 'Layout', 'et_builder' ),
				'type'              => 'select',
				'option_category'   => 'configuration',
				'options'           => array(
					'Grid' => esc_html__( 'Grid', 'et_builder' ),
					'Slider'  => esc_html__( 'Slider', 'et_builder' ),
				),
				'description'       => esc_html__( 'Toggle between the various blog layout types.', 'et_builder' ),
				'toggle_slug' => 'main_content',
			),
			'admin_label' => array(
				'label'       => esc_html__( 'Admin Label', 'et_builder' ),
				'type'        => 'text',
				'description' => esc_html__( 'This will change the label of the module in the builder for easy identification.', 'et_builder' ),
				'toggle_slug' => 'admin_label',
			),

			'module_id' => array(
				'label'           => esc_html__( 'CSS ID', 'et_builder' ),
				'type'            => 'text',
				'option_category' => 'configuration',
				'tab_slug'        => 'custom_css',
				'toggle_slug'     => 'classes',
				'option_class'    => 'et_pb_custom_css_regular',
			),

			'module_class' => array(
				'label'           => esc_html__( 'CSS Class', 'et_builder' ),
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
		$gallery_ids            = $this->shortcode_atts['gallery_ids'];
		$gallery_orderby        = $this->shortcode_atts['gallery_orderby'];
		$layout_type            = $this->shortcode_atts['layout_type'];

		$gallery_ids = explode(',', $gallery_ids);
		$output = '';
		if (($layout_type == 'Slider')) {
			$output = '<div class="rkt_partners_slider ">';
			foreach ( $gallery_ids as $key => $val ) {
				$src  = wp_get_attachment_url( $val, 'full' );
				$output .= '<div class="rkt_partner_iterm">
								<img src="'.$src.'" class="img_partner">
							</div>';
			}
			$output .= '</div>';
		}else{
			$output = '<div class="rkt_partners_grid "><div class="rkt_grid_inner ">';
			foreach ( $gallery_ids as $key => $val ) {
				$src  = wp_get_attachment_url( $val, 'full' );
				$output .= '<div class="rkt_partner_iterm">
								<div class="rkt_iterm_wp">
									<div class="rkt_iterm_inner">
										<img src="'.$src.'" class="img_partner">
									</div>
								</div>
							</div>';
			}
			$output .= '</div></div>';
		}

		$module_class = ET_Builder_Element::add_module_order_class( $module_class, $function_name );


		return $output;
	}
}
new Rocket_Theme_Module_Partners;
