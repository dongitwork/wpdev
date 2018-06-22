<?php 
/*
* Ver: 2.0
* Fullwidth
* Include Title desc
* Child muti 
*/

class SA_Builder_Module_VideoText extends ET_Builder_Module {

	function init() {
		$this->name  = esc_html__('SA Video Text', 'sa_builder');
		$this->slug            = 'et_pb_sa_videotext';
		$this->fb_support      = true;
		$this->child_slug      = 'et_pb_sa_vtitemlist';
		$this->child_item_text = esc_html__( 'Item List', 'sa_builder' );

		$this->whitelisted_fields = array(
			'title',
			'videoid',
			'image',
			'content',
			'url',
			'btn_text',
			'admin_label',
			'module_id',
			'module_class',
		);

		$this->main_css_element = '%%order_class%%.et_pb_sa_videotext';
		$this->options_toggles = array(
			'general'  => array(
				'toggles' => array(
					'main_content' => esc_html__( 'Main Content','sa_builder' ),
					'link' => esc_html__( 'Main Link','sa_builder' ),
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
			'videoid' => array(
				'label'       => esc_html__( 'Youtube Video ID', 'sa_builder' ),
				'type'        => 'text',
				'description' => esc_html__( '', 'sa_builder' ),
				'toggle_slug' => 'main_content',
			),
			'content' => array(
				'label'       => esc_html__( 'Content', 'sa_builder' ),
				'type'        => 'textarea',
				'description' => esc_html__( '', 'sa_builder' ),
				'toggle_slug' => 'main_content',
			),

			'image' => array(
				'label'              => esc_html__( 'Image URL', 'sa_builder' ),
				'type'               => 'upload',
				'option_category'    => 'basic_option',
				'upload_button_text' => esc_attr__( 'Upload an image', 'sa_builder' ),
				'choose_text'        => esc_attr__( 'Choose an Image', 'sa_builder' ),
				'update_text'        => esc_attr__( 'Set As Image', 'sa_builder' ),
				'description'        => esc_html__( 'Upload your desired image, or type in the URL to the image you would like to display.', 'sa_builder' ),
				'toggle_slug'        => 'main_content',
			),

			'url' => array(
				'label'       => esc_html__( 'Button Url', 'sa_builder' ),
				'type'        => 'text',
				'description' => esc_html__( 'Input the destination URL for your CTA button.', 'sa_builder' ),
				'toggle_slug' => 'link',
			),
			'btn_text' => array(
				'label'       => esc_html__( 'Button Text', 'sa_builder' ),
				'type'        => 'text',
				'description' => esc_html__( 'Input your desired button text, or leave blank for no button.', 'sa_builder' ),
				'toggle_slug' => 'link',
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
		$videoid		= $this->shortcode_atts['videoid'];
		$url			= $this->shortcode_atts['url'];
		$btn_text		= $this->shortcode_atts['btn_text'];
		$content		= $this->shortcode_atts['content'];
		$image			= $this->shortcode_atts['image'];
		$module_class   = ET_Builder_Element::add_module_order_class( $module_class, $function_name );
		$output = '';
		global $data_iterm;
		$List_item = '';
		if (!empty($data_iterm)):
			$List_item .= '<div class="row_fl">';
			foreach ($data_iterm as $val) {
				$List_item .= '<div class="col-xs-full col-xs-6 sa-literm col-sm-6">'.$val.'</div>';
			}
			$List_item .= '</div>';
		endif; 
		$data_iterm = array();
		if ($url != '' || $btn_text != '') {
			$btn_gr = sprintf('<div class="sa-vtbtn_group">
							<a href="%s" class="sa-btn">%s</a>
							</div>',
							($url)?$url:'#',
							($btn_text)?$btn_text:'Learn more');
		}
		
		if ($videoid) {
			$sa_video = sprintf('<a href="https://www.youtube.com/embed/%s?autoplay=1&rel=0" class="sa-play"><span class="fa fa-play"></span></a>',$videoid);
		}

		$output = sprintf('<div id="'.$module_id.'" class="'.$module_class.'">
						<div class="sa-video-text">
							<div class="sa-vt_inner">
								<div class="sa_vtcol col-xs-12 col-sm-6 col-md-6 sa-vtcol_left">
									<div class="sa_vt_inner">%s %s</div>
								</div>
								<div class="sa_vtcol col-xs-12 col-sm-6 col-md-6 sa-vtcol_right">
									<h2 class="sa-vt_title">%s</h2>
									<div class="sa-vt_desc">
										%s
									</div>
									%s %s
								</div>
							</div>
						</div></div>',
						($image)?'<img src="'.$image.'" class="sa-vt_image">':'',
						($sa_video)?$sa_video:'',
						$title,
						$content,
						($List_item)?'<div class="sa-iterm_list">'.$List_item.'</div>':'',
						($btn_gr)?$btn_gr:''
					);
		return $output;
	}
}
new SA_Builder_Module_VideoText;

class SA_Builder_Module_VTList_Item extends ET_Builder_Module {
	function init() {
		$this->name              = esc_html__( 'Item List', 'sa_builder' );
		$this->slug              = 'et_pb_sa_vtitemlist';
		$this->fb_support        = true;
		$this->type              = 'child';
		$this->child_title_var   = 'title';

		$this->whitelisted_fields= array(
			'title',
			'iterm_image',
		);

		$this->advanced_setting_title_text = esc_html__( 'New Item', 'sa_builder' );
		$this->settings_text               = esc_html__( 'Item Settings', 'sa_builder' );
		$this->main_css_element = '%%order_class%%';

		$this->options_toggles = array(
			'general'  => array(
				'toggles' => array(
					'main_content' => esc_html__( 'Item Data', 'sa_builder' ),
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
				'description'     => esc_html__( '', 'sa_builder' ),
				'toggle_slug'     => 'main_content',
			),

			'iterm_image' => array(
				'label'              => esc_html__( 'Image URL', 'sa_builder' ),
				'type'               => 'upload',
				'option_category'    => 'basic_option',
				'upload_button_text' => esc_attr__( 'Upload an image', 'sa_builder' ),
				'choose_text'        => esc_attr__( 'Choose an Image', 'sa_builder' ),
				'update_text'        => esc_attr__( 'Set As Image', 'sa_builder' ),
				'description'        => esc_html__( 'Upload your desired image, or type in the URL to the image you would like to display.', 'sa_builder' ),
				'toggle_slug'        => 'main_content',
			),
		);
		return $fields;
	}

	function shortcode_callback( $atts, $content = null, $function_name ) {

		global $data_iterm;
		$module_class	= ET_Builder_Element::add_module_order_class( '', $function_name );
		$title			= $this->shortcode_atts['title'];
		$iterm_image	= $this->shortcode_atts['iterm_image'];
		if ($title != '') {
			$data_iterm[] = sprintf('<span class="img_text">
				%s %s</span>',
				($iterm_image)?'<img src="'.$iterm_image.'" height="28">':'',
				$title);
		}
		
	}
}
new SA_Builder_Module_VTList_Item;