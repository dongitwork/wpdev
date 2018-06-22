<?php 
class Rocket_Theme_Module_Testimonials extends ET_Builder_Module {
	function init() {
		$this->name            = esc_html__( 'Rocket Fullwidth Testimonials', 'et_builder' );
		$this->slug            = 'et_pb_rk_fw_testimonials';
		$this->fb_support      = true;
		$this->fullwidth        = true;
		$this->child_slug      = 'et_pb_rk_testimonial';
		$this->child_item_text = esc_html__( 'Testimonial', 'et_builder' );
		$this->whitelisted_fields = array(
			'title',
			'content',
			'bg_img',
			'admin_label',
			'module_id',
			'module_class',
		);
		$this->main_css_element = '%%order_class%%.et_pb_rk_full_testimonials';
		$this->options_toggles = array(
			'general'  => array(
				'toggles' => array(
					'main_content' => esc_html__( 'Main Content', 'et_builder' ),
					'main_testimonial' => esc_html__( 'Main Content', 'et_builder' ),
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
				'toggle_slug' => 'main_testimonial',
			),
			'content' => array(
				'label'       => esc_html__( 'Content', 'et_builder' ),
				'type'        => 'textarea',
				'description' => esc_html__( '', 'et_builder' ),
				'toggle_slug' => 'main_testimonial',
			),

			'bg_img' => array(
				'label'              => esc_html__( 'Image URL', 'et_builder' ),
				'type'               => 'upload',
				'option_category'    => 'basic_option',
				'upload_button_text' => esc_attr__( 'Upload an image', 'et_builder' ),
				'choose_text'        => esc_attr__( 'Choose an Image', 'et_builder' ),
				'update_text'        => esc_attr__( 'Set As Image', 'et_builder' ),
				'description'        => esc_html__( 'Upload your desired image, or type in the URL to the image you would like to display.', 'et_builder' ),
				'toggle_slug'        => 'main_testimonial',
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
		$title			= $this->shortcode_atts['title'];
		$content		= $this->shortcode_atts['content'];
		$bg_img			= $this->shortcode_atts['bg_img'];


		$module_class = ET_Builder_Element::add_module_order_class( $module_class, $function_name );
		$all_tabs_content = $this->shortcode_content;


		global $data_testimonials;
		if (!empty($data_testimonials)) {
			$data = '<div class="testimonial_wp">
						<div class="tt_inner">
							<div class="container">
								<div class="tt_carouasel">
									'.implode('', $data_testimonials).'
								</div>		
							</div>
						</div>		
					</div>';
			$data_testimonials =  array();
		}else{
			$data = '';
		}

		$output = sprintf('<div class="full-width_tt" >
					    <div class="full-width_tt-inner" style="background-image: url(\'%s\');">
					        <div class="container">
					        	<div class="col-xs-12 col-md-5">
						            <div class="tt_main-content">
						                <h2 class="tt-main_title">
						                	%s
						                </h2>
						                <div class="tt_main-desc">
											%s
						                </div>
						                <div id="custom-dots"></div>
						            </div>
						        </div>
					        </div>
					    </div>
					    <div class="tt_full-slider">
					    	%s
					    </div>
					</div>',$bg_img,$title,$content,$data);
		return $output;
	}
}
new Rocket_Theme_Module_Testimonials;

class Rocket_Theme_Module_Testimonial_Item extends ET_Builder_Module {
	function init() {
		$this->name                        = esc_html__( 'Testimonial', 'et_builder' );
		$this->slug                        = 'et_pb_rk_testimonial';
		$this->fb_support                  = true;
		$this->type                        = 'child';
		$this->child_title_var             = 'author';

		$this->whitelisted_fields = array(
			'author',
			'job_title',
			'company_name',
			'author_img',
			'rating',
			'content_new',
		);

		$this->advanced_setting_title_text = esc_html__( 'New Testimonial', 'et_builder' );
		$this->settings_text               = esc_html__( 'Testimonial Settings', 'et_builder' );
		$this->main_css_element = '%%order_class%%';

		$this->options_toggles = array(
			'general'  => array(
				'toggles' => array(
					'main_content' => esc_html__( 'Testimonial Data', 'et_builder' ),
				),
			),
		);

		$this->advanced_options = array();

		$this->custom_css_options = array(
			'main_element' => array(
				'label'    => esc_html__( 'Main Element', 'et_builder' ),
				'selector' => ".et_pb_rk_testimonials div{$this->main_css_element}.et_pb_rk_testimonial",
			)
		);
	}

	function get_fields() {
		$fields = array(
			'author' => array(
				'label'           => esc_html__( 'Author Name', 'et_builder' ),
				'type'            => 'text',
				'option_category' => 'basic_option',
				'description'     => esc_html__( 'Input the name of the testimonial author.', 'et_builder' ),
				'toggle_slug'     => 'main_content',
			),

			'author_img' => array(
				'label'              => esc_html__( 'Author Image URL', 'et_builder' ),
				'type'               => 'upload',
				'option_category'    => 'basic_option',
				'upload_button_text' => esc_attr__( 'Upload an image', 'et_builder' ),
				'choose_text'        => esc_attr__( 'Choose an Image', 'et_builder' ),
				'update_text'        => esc_attr__( 'Set As Image', 'et_builder' ),
				'description'        => esc_html__( 'Upload your desired image, or type in the URL to the image you would like to display.', 'et_builder' ),
				'toggle_slug'        => 'main_content',
			),

			'job_title' => array(
				'label'           => esc_html__( 'Job Title', 'et_builder' ),
				'type'            => 'text',
				'option_category' => 'basic_option',
				'description'     => esc_html__( 'Input the job title.', 'et_builder' ),
				'toggle_slug'     => 'main_content',
			),

			'company_name' => array(
				'label'           => esc_html__( 'Company Name', 'et_builder' ),
				'type'            => 'text',
				'option_category' => 'basic_option',
				'description'     => esc_html__( 'Input the name of the company.', 'et_builder' ),
				'toggle_slug'     => 'main_content',
			),

			'rating' => array(
				'label'           => esc_html__( 'Rating', 'et_builder' ),
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
		$job_title		= $this->shortcode_atts['job_title'];
		$company_name	= $this->shortcode_atts['company_name'];
		$rating			= $this->shortcode_atts['rating'];
		$content		= $this->shortcode_content;

		if ($rating>0) {
			$spanrating = '<span class="rating_star">';
			for ($i=1; $i <= $rating ; $i++) { 
				$spanrating .= '<span class="star"><i class="fa fa-star"></i></span>';
			}
			$spanrating .= '</span>';
		}

		$data_testimonials[] = sprintf('<div class="ttiterm '.$module_class.'">
						<div class="row_tt">
						    <div class="row_tt_left">
						        <div class="author-image">
						            %s
						        </div>
						    </div>
						    <div class="row_tt_right">
						        <div class="ttdata">
						            <h3 class="author-name">%s</h3>
						            <div class="job_company">
						                %s
						            </div>
						            <div class="tt_content">
						                %s
						            </div>
						            <div class="tt_rating">
						                %s
						            </div>
						        </div>
						    </div>
						</div>
					</div>', ($author_img !='')?'<img src="'.$author_img.'">':'',
					$author,$company_name.' '.$job_title,$content,($spanrating)?$spanrating:'');


		return '';
	}
}
new Rocket_Theme_Module_Testimonial_Item;