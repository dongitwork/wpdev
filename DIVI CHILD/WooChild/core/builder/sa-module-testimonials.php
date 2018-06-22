<?php 
/*
* Ver: 2.0
* Fullwidth
* Include Title desc
* Child muti 
*/

class SA_Builder_Module_Testimonials extends ET_Builder_Module {

	function init() {
		$this->name  = esc_html__('SA Fullwidth Testimonials', 'sa_builder');
		$this->slug            = 'et_pb_sa_mtestimonials';
		$this->fb_support      = true;
		$this->fullwidth       = true;
		$this->child_slug      = 'et_pb_sa_ctestimonial';
		$this->child_item_text = esc_html__( 'Testimonial', 'sa_builder' );

		$this->whitelisted_fields = array(
			'title',
			'content',
			'bg_img',
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
			'content' => array(
				'label'       => esc_html__( 'Content', 'sa_builder' ),
				'type'        => 'textarea',
				'description' => esc_html__( '', 'sa_builder' ),
				'toggle_slug' => 'main_content',
			),

			'bg_img' => array(
				'label'              => esc_html__( 'Background Image', 'sa_builder' ),
				'type'               => 'upload',
				'option_category'    => 'basic_option',
				'upload_button_text' => esc_attr__( 'Upload an image', 'sa_builder' ),
				'choose_text'        => esc_attr__( 'Choose an Image', 'sa_builder' ),
				'update_text'        => esc_attr__( 'Set As Image', 'sa_builder' ),
				'description'        => esc_html__( 'Upload your desired image, or type in the URL to the image you would like to display.', 'sa_builder' ),
				'toggle_slug'        => 'main_content',
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
		$content		= $this->shortcode_atts['content'];
		$bg_img			= $this->shortcode_atts['bg_img'];
		$module_class = ET_Builder_Element::add_module_order_class( $module_class, $function_name );
		$output = '';
		global $data_testimonials;
		if (!empty($data_testimonials)):
			$gtitle = sprintf('<div class="sa-ttgroup-header text-center">
						<h2 class="sa-tt_title">%s</h2>
						<div class="sa-tt_desc">
							%s
						</div>
					</div>',$title,$content);
			$output = sprintf('<div id="'.$module_id.'" class="'.$module_class.'" >
								<div class="sa_tt_group" %s>
								<div class="container">
									%s
									<div class="sa_tt_carousel owl-carousel owl-theme">
										%s
									</div>
								</div>
							</div></div>',
							($bg_img)?'style="background-image: url(\''.$bg_img.'\');"':'',
							($gtitle)?$gtitle:'',
							implode('', $data_testimonials));
		endif; // end check data_testimonials

		$data_testimonials = array();
		return $output;
	}
}
new SA_Builder_Module_Testimonials;

class SA_Builder_Module_Testimonial_Item extends ET_Builder_Module {
	function init() {
		$this->name              = esc_html__( 'Testimonial', 'sa_builder' );
		$this->slug              = 'et_pb_sa_ctestimonial';
		$this->fb_support        = true;
		$this->type              = 'child';
		$this->child_title_var   = 'author';

		$this->whitelisted_fields= array(
			'author',
			'author_img',
			'rating',
			'content_new',
		);

		$this->advanced_setting_title_text = esc_html__( 'New Testimonial', 'sa_builder' );
		$this->settings_text               = esc_html__( 'Testimonial Settings', 'sa_builder' );
		$this->main_css_element = '%%order_class%%';

		$this->options_toggles = array(
			'general'  => array(
				'toggles' => array(
					'main_content' => esc_html__( 'Testimonial Data', 'sa_builder' ),
				),
			),
		);

		$this->advanced_options = array();
		$this->custom_css_options = array();
	}

	function get_fields() {
		$fields = array(
			'author' => array(
				'label'           => esc_html__( 'Author Name', 'sa_builder' ),
				'type'            => 'text',
				'option_category' => 'basic_option',
				'description'     => esc_html__( 'Input the name of the testimonial author.', 'sa_builder' ),
				'toggle_slug'     => 'main_content',
			),

			'author_img' => array(
				'label'              => esc_html__( 'Author Image URL', 'sa_builder' ),
				'type'               => 'upload',
				'option_category'    => 'basic_option',
				'upload_button_text' => esc_attr__( 'Upload an image', 'sa_builder' ),
				'choose_text'        => esc_attr__( 'Choose an Image', 'sa_builder' ),
				'update_text'        => esc_attr__( 'Set As Image', 'sa_builder' ),
				'description'        => esc_html__( 'Upload your desired image, or type in the URL to the image you would like to display.', 'sa_builder' ),
				'toggle_slug'        => 'main_content',
			),

			'rating' => array(
				'label'           => esc_html__( 'Rating', 'sa_builder' ),
				'type'            => 'range',
				'option_category' => 'basic_option',
				'toggle_slug'     => 'main_content',
				'range_settings'  => array(
					'min'  => '1',
					'max'  => '5',
					'step' => '1',
				),
			),

			'content_new' => array(
				'label'       => esc_html__( 'Content', 'et_builder' ),
				'type'        => 'tiny_mce',
				'description' => esc_html__( '', 'et_builder' ),
				'toggle_slug' => 'main_content',
			),
		);
		return $fields;
	}

	function shortcode_callback( $atts, $content = null, $function_name ) {

		global $data_testimonials;
		$module_class	= ET_Builder_Element::add_module_order_class( '', $function_name );
		$author			= $this->shortcode_atts['author'];
		$author_img		= $this->shortcode_atts['author_img'];
		$rating			= $this->shortcode_atts['rating'];
		$content		= $this->shortcode_content;
		if ($rating>0) {
			$spanrating = '<span class="rating_star">';
			for ($i=1; $i <= $rating ; $i++) { 
				$spanrating .= '<span class="star"><i class="fa fa-star"></i></span>';
			}
			$spanrating .= '</span>';
		}

		$data_testimonials[] = sprintf('<div class="sa_tt_iterm text-center">
				<div class="sa_ttiterm_inner">
						%s
					<div class="sa_tt_itdesc">
						%s
					</div>
					<h3 class="sa_tt_itauthor">
						%s
					</h3>
				</div>
				<div class="sa_tt_itimg">
					<div class="sa_tt_itimgin">
						%s	
					</div>	
				</div>
			</div>',
			($spanrating)?'<div class="ttrating">'.$spanrating.'</div>':'',
			strip_tags($content),$author, 
			($author_img !='')?'<img width="92" height="92" src="'.$author_img.'">':'');;
		//return '';
	}
}
new SA_Builder_Module_Testimonial_Item;