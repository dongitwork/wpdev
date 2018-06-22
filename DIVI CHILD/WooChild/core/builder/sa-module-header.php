<?php

class SA_Module_Fullwidth_Header extends ET_Builder_Module {
	function init() {
		$this->name             = esc_html__( 'SA Fullwidth Header', 'sa_builder' );
		$this->slug             = 'et_pb_sa_fullwidth_header';
		$this->fb_support       = true;
		$this->fullwidth        = true;
		$this->main_css_element = '%%order_class%%.et_pb_sa_fullwidth_header';

		$this->whitelisted_fields = array(
			'title',
			'subhead',
			'bg_image_url',
			'content_new',
			'admin_label',
			'module_id',
			'module_class',
		);

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
				'label'           => esc_html__( 'Title', 'sa_builder' ),
				'type'            => 'text',
				'option_category' => 'basic_option',
				'description'     => esc_html__( 'Enter your page title here.', 'sa_builder' ),
				'toggle_slug'     => 'main_content',
			),
			'subhead' => array(
				'label'           => esc_html__( 'Subheading Text', 'sa_builder' ),
				'type'            => 'text',
				'option_category' => 'basic_option',
				'description'     => esc_html__( 'If you would like to use a subhead, add it here. Your subhead will appear above your title in a small font.', 'sa_builder' ),
				'toggle_slug'     => 'main_content',
			),
			'bg_image_url' => array(
				'label'              => esc_html__( 'Background Image URL', 'sa_builder' ),
				'type'               => 'upload',
				'option_category'    => 'basic_option',
				'upload_button_text' => esc_attr__( 'Upload an image', 'sa_builder' ),
				'choose_text'        => esc_attr__( 'Choose an Image', 'sa_builder' ),
				'update_text'        => esc_attr__( 'Set As Image', 'sa_builder' ),
				'description'        => esc_html__( 'Upload your desired image, or type in the URL to the image you would like to display.', 'sa_builder' ),
				'toggle_slug'        => 'main_content',
			),
			'content_new' => array(
				'label'           => esc_html__( 'Content', 'sa_builder' ),
				'type'            => 'tiny_mce',
				'option_category' => 'basic_option',
				'description'     => esc_html__( 'Content entered here will appear below the subheading text.', 'sa_builder' ),
				'toggle_slug'     => 'main_content',
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
		$subhead		= $this->shortcode_atts['subhead'];
		$bg_url   		= $this->shortcode_atts['bg_image_url'];
		$content   		= $this->shortcode_content;
		$module_class   = ET_Builder_Element::add_module_order_class( $module_class, $function_name );
		$output = sprintf('<div id="'.$module_id.'" class="'.$module_class.'">
						<div class="sa-fullwidth_header" %s>
							<div class="container">
								<div class="sa-fwh_content text-center">
									%s
									<h1 class="sa-fwh_title">%s</h1>
									<div class="sa-fwh_desc">
										%s
									</div>
								</div>
							</div>
						</div>
					</div>',
					($bg_url)?'style="background-image: url(\''.$bg_url.'\');"':'',
					($subhead)?'<h4 class="sa-fwh_subtitle">'.$subhead.'</h4>':'',
					$title,$content
					);
		return $output;
	}
}

new SA_Module_Fullwidth_Header;
