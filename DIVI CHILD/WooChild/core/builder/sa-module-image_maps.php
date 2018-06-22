<?php

class SA_Module_Image_Maps extends ET_Builder_Module {
	function init() {
		$this->name             = esc_html__( 'SA Image Maps', 'sa_builder' );
		$this->slug             = 'et_pb_sa_img_maps';
		$this->fb_support       = true;
		$this->fullwidth        = true;
		$this->child_slug      = 'et_pb_sa_img_map';
		$this->child_item_text = esc_html__( 'Map Item', 'sa_builder' );
		$this->main_css_element = '%%order_class%%';

		$this->whitelisted_fields = array(
			'image',
			'admin_label',
			'module_id',
			'module_class',
		);

		$this->fields_defaults = array();
		$this->options_toggles = array(
			'general'  => array(
				'toggles' => array(
					'main_content' => esc_html__( 'Text', 'sa_builder' ),
					'images'       => esc_html__( 'Images', 'sa_builder' ),
				),
			),
		);

		$this->advanced_options = array();

		$this->custom_css_options = array();
	}

	function get_fields() {
		$fields = array(
			'image' => array(
				'label'              => esc_html__( 'Image URL', 'sa_builder' ),
				'type'               => 'upload',
				'option_category'    => 'basic_option',
				'upload_button_text' => esc_attr__( 'Upload an image', 'sa_builder' ),
				'choose_text'        => esc_attr__( 'Choose an Image', 'sa_builder' ),
				'update_text'        => esc_attr__( 'Set As Image', 'sa_builder' ),
				'description'        => esc_html__( 'Upload your desired image, or type in the URL to the image you would like to display.', 'sa_builder' ),
				'toggle_slug'        => 'images',
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
		$module_id                    = $this->shortcode_atts['module_id'];
		$module_class                 = $this->shortcode_atts['module_class'];
		$image                        = $this->shortcode_atts['image'];
		$module_class = ET_Builder_Element::add_module_order_class( $module_class, $function_name );
		$output ='';
		if ($image != '') { 
			global $maps_items;
			$output = sprintf('<div %s class="%s"> 
								<div class="sa-image_maps">
									<div class="sa-ims_inner">
										<div class="sa-ims_image">
											<img src="%s" class="img-responsive">
										</div>
										<div class="sa-ims_gcontent">
											%s
										</div>
									</div>
								</div></div>',
								($module_id)?'id="'.$module_id.'"':'',
								$module_class,
								$image,implode('', $maps_items));
			$maps_items = array();
		}

		return $output;
	}	
}

new SA_Module_Image_Maps;


class SA_Module_Map_Item extends ET_Builder_Module {
	function init() {
		$this->name                        = esc_html__( 'Map Item', 'sa_builder' );
		$this->slug                        = 'et_pb_sa_img_map';
		$this->fb_support                  = true;
		$this->type                        = 'child';
		$this->child_title_var             = 'title';

		$this->whitelisted_fields = array(
			'title',
			'position',
			'is_active',
			'content_new',
		);

		$this->advanced_setting_title_text = esc_html__( 'New Map Item', 'sa_builder' );
		$this->settings_text               = esc_html__( 'Map Item Settings', 'sa_builder' );
		$this->main_css_element = '%%order_class%%';

		$this->fields_defaults = array(
			'is_active'      => array( 'off' ),
		);

		$this->options_toggles = array(
			'general'  => array(
				'toggles' => array(
					'main_content' => esc_html__( 'Map Item Content', 'sa_builder' ),
				),
			),
		);
		$this->advanced_options = array();
		$this->custom_css_options = array();
	}

	function get_fields() {
		$fields = array(
			'title' => array(
				'label'           => esc_html__( 'item Title', 'sa_builder' ),
				'type'            => 'text',
				'option_category' => 'basic_option',
				'description'     => esc_html__( 'Input the name of the title popup.', 'sa_builder' ),
				'toggle_slug'     => 'main_content',
			),			
			'position' => array(
				'label'           => esc_html__( 'item position', 'sa_builder' ),
				'type'            => 'text',
				'option_category' => 'basic_option',
				'description'     => esc_html__( 'Position like css top right bottom left.', 'sa_builder' ),
				'toggle_slug'     => 'main_content',
			),
			'is_active' => array(
				'label'           => esc_html__( 'Show Content', 'et_builder' ),
				'type'            => 'yes_no_button',
				'option_category' => 'configuration',
				'options'         => array(
					'on'  => esc_html__( 'On', 'et_builder' ),
					'off' => esc_html__( 'Off', 'et_builder' ),
				),
				'toggle_slug'     => 'main_content',
				'description'     => esc_html__( 'Here you can choose to display content when the page loads.', 'et_builder' ),
			),
			'content_new' => array(
				'label'       => esc_html__( 'Content', 'sa_builder' ),
				'type'        => 'tiny_mce',
				'description' => esc_html__( '', 'sa_builder' ),
				'toggle_slug' => 'main_content',
			),
		);
		return $fields;
	}

	function shortcode_callback( $atts, $content = null, $function_name ) {

		global $maps_items;
		$module_class	= ET_Builder_Element::add_module_order_class( '', $function_name );
		$title			= $this->shortcode_atts['title'];
		$position		= $this->shortcode_atts['position'];
		$is_active		= $this->shortcode_atts['is_active'];
		$content		= $this->shortcode_content;
		$module_class = ET_Builder_Element::add_module_order_class( $module_class, $function_name );
		$maps_items[] = sprintf('<div class="sa-map_iterm_wp">
								<div class="sa_tooltip sa_tt_mobile %s">
									<h3 class="sa-map_title">%s</h3>
									<div class="sa-map_info">
										%s
									</div>
								</div>
					<div class="sa-map_iterm sa-map_icon '.$module_class.'" style="%s" >
									<a href="#" class="sa-tt_icon">%s</a>
									<div class="sa_tooltip %s">
										<h3 class="sa-map_title">%s</h3>
										<div class="sa-map_info">
											%s
										</div>
									</div>
								</div></div>',
								($is_active == 'on')?'active':'',
								$title,
								$content,
								$position,
								($is_active == 'on')?'-':'+',
								($is_active == 'on')?'active':'',
								$title,
								$content);


		return '';
	}
}
new SA_Module_Map_Item;