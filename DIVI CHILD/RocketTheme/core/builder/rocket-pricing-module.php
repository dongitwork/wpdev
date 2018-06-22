<?php 
class Rocket_Theme_Module_Pricing_Tables extends ET_Builder_Module {
	function init() {
		$this->name            = esc_html__( 'Rocket Pricing Tables', 'rkt_builder' );
		$this->slug            = 'et_pb_rk_pricing_tables';
		$this->fb_support      = true;
		$this->child_slug      = 'et_pb_rk_pricing';
		$this->child_item_text = esc_html__( 'Pricing Table', 'rkt_builder' );
		$this->whitelisted_fields = array(
			'admin_label',
			'module_id',
			'module_class',
		);
		$this->main_css_element = '%%order_class%%.et_pb_rk_pricing_tables';
		$this->advanced_options = array();
		$this->custom_css_options = array();
	}

	function get_fields() {
		$fields = array(
			'admin_label' => array(
				'label'       => esc_html__( 'Admin Label', 'rkt_builder' ),
				'type'        => 'text',
				'description' => esc_html__( 'This will change the label of the module in the builder for easy identification.', 'rkt_builder' ),
				'toggle_slug' => 'admin_label',
			),
			'module_id' => array(
				'label'           => esc_html__( 'CSS ID', 'rkt_builder' ),
				'type'            => 'text',
				'option_category' => 'configuration',
				'tab_slug'        => 'custom_css',
				'toggle_slug'     => 'classes',
				'option_class'    => 'et_pb_custom_css_regular',
			),
			'module_class' => array(
				'label'           => esc_html__( 'CSS Class', 'rkt_builder' ),
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

		$module_class = ET_Builder_Element::add_module_order_class( $module_class, $function_name );
		global $rkt_pricing_iterm;
		$output =  '';
		if (!empty($rkt_pricing_iterm)) {
			$output = '<div id="'.$module_id.'" class="rkt_pricing_tables '.$module_class.'">
							<div class="rkt_pricing_tables_inner">
								'.implode('',  $rkt_pricing_iterm).'
							</div>
					</div>';
		}
		$rkt_pricing_iterm = array();
		return $output;
	}
}
new Rocket_Theme_Module_Pricing_Tables;

class Rocket_Theme_Module_Pricing_Item extends ET_Builder_Module {
	function init() {
		$this->name                        = esc_html__( 'Pricing Table', 'rkt_builder' );
		$this->slug                        = 'et_pb_rk_pricing';
		$this->fb_support                  = true;
		$this->type                        = 'child';
		$this->child_title_var             = 'title';

		$this->whitelisted_fields = array(
			'featured',
			'title',
			'subtitle',
			'currency',
			'per',
			'price',
			'sum_group',
			'button_url',
			'button_text',
			'content_new',
		);
		$this->fields_defaults = array(
			'featured' => array( 'off' ),
		);
		$this->advanced_setting_title_text = esc_html__( 'New Pricing Table', 'rkt_builder' );
		$this->settings_text               = esc_html__( 'Pricing Table Settings', 'rkt_builder' );
		$this->main_css_element = '%%order_class%%';

		$this->options_toggles = array(
			'general'  => array(
				'toggles' => array(
					'main_content' => esc_html__( 'Text', 'rkt_builder' ),
					'link'         => esc_html__( 'Link', 'rkt_builder' ),
					'layout'  	   => esc_html__( 'Layout', 'rkt_builder' ),
				),
			),
		);

		$this->advanced_options = array();

		$this->custom_css_options = array(
			'main_element' => array(
				'label'    => esc_html__( 'Main Element', 'rkt_builder' ),
				'selector' => ".et_pb_rk_pricing div{$this->main_css_element}.et_pb_rk_tab",
			)
		);
	}

	function get_fields() {
		$fields = array(
			'featured' => array(
				'label'           => esc_html__( 'Make This Table Featured', 'rkt_builder' ),
				'type'            => 'yes_no_button',
				'option_category' => 'basic_option',
				'options'         => array(
					'off' => esc_html__( 'No', 'rkt_builder' ),
					'on'  => esc_html__( 'Yes', 'rkt_builder' ),
				),
				'toggle_slug'     => 'layout',
				'description'     => esc_html__( 'Featuring a table will make it stand out from the rest.', 'rkt_builder' ),
			),
			'title' => array(
				'label'           => esc_html__( 'Title', 'rkt_builder' ),
				'type'            => 'text',
				'option_category' => 'basic_option',
				'description'     => esc_html__( 'Define a title for the pricing table.', 'rkt_builder' ),
				'toggle_slug'     => 'main_content',
			),
			'subtitle' => array(
				'label'           => esc_html__( 'Subtitle', 'rkt_builder' ),
				'type'            => 'text',
				'option_category' => 'basic_option',
				'description'     => esc_html__( 'Define a sub title for the table if desired.', 'rkt_builder' ),
				'toggle_slug'     => 'main_content',
			),
			'currency' => array(
				'label'           => esc_html__( 'Currency', 'rkt_builder' ),
				'type'            => 'text',
				'option_category' => 'basic_option',
				'description'     => esc_html__( 'Input your desired currency symbol here.', 'rkt_builder' ),
				'toggle_slug'     => 'main_content',
			),
			'per' => array(
				'label'           => esc_html__( 'Per', 'rkt_builder' ),
				'type'            => 'text',
				'option_category' => 'basic_option',
				'description'     => esc_html__( 'If your pricing is subscription based, input the subscription payment cycle here.', 'rkt_builder' ),
				'toggle_slug'     => 'main_content',
			),
			'price' => array(
				'label'           => esc_html__( 'Price', 'rkt_builder' ),
				'type'            => 'text',
				'option_category' => 'basic_option',
				'description'     => esc_html__( 'Input the value of the product here.', 'rkt_builder' ),
				'toggle_slug'     => 'main_content',
			),
			'sum_group' => array(
				'label'           => esc_html__( 'Price Fieldset', 'rkt_builder' ),
				'type'            => 'text',
				'option_category' => 'basic_option',
				'description'     => esc_html__( 'Input the value of below the price.', 'rkt_builder' ),
				'toggle_slug'     => 'main_content',
			),
			'button_text' => array(
				'label'           => esc_html__( 'Button Text', 'rkt_builder' ),
				'type'            => 'text',
				'option_category' => 'basic_option',
				'description'     => esc_html__( 'Adjust the text used from the signup button.', 'rkt_builder' ),
				'toggle_slug'     => 'link',
			),
			'button_url' => array(
				'label'           => esc_html__( 'Button URL', 'rkt_builder' ),
				'type'            => 'text',
				'option_category' => 'basic_option',
				'description'     => esc_html__( 'Input the destination URL for the signup button.', 'rkt_builder' ),
				'toggle_slug'     => 'link',
			),
			'content_new' => array(
				'label'           => esc_html__( 'Content', 'rkt_builder' ),
				'type'            => 'tiny_mce',
				'option_category' => 'basic_option',
				'description'     => sprintf(
					'%1$s<br/> + %2$s<br/> - %3$s',
					esc_html__( 'Input a list of features that are/are not included in the product. Separate items on a new line, and begin with either a + or - symbol: ', 'rkt_builder' ),
					esc_html__( 'Included option', 'rkt_builder' ),
					esc_html__( 'Excluded option', 'rkt_builder' )
				),
				'toggle_slug'     => 'main_content',
			),
		);
		return $fields;
	}

	function shortcode_callback( $atts, $content = null, $function_name ) {
		
		$featured      = $this->shortcode_atts['featured'];
		$title         = $this->shortcode_atts['title'];
		$subtitle      = $this->shortcode_atts['subtitle'];
		$currency      = $this->shortcode_atts['currency'];
		$per           = $this->shortcode_atts['per'];
		$price         = $this->shortcode_atts['price'];
		$sum_group     = $this->shortcode_atts['sum_group'];
		$button_url    = $this->shortcode_atts['button_url'];
		$button_text   = $this->shortcode_atts['button_text'];
		$btn_link = '';
		$prices = explode('.', $price);
		$price = $prices[0];
		$small_price = (isset($prices[1]) && $prices[1]!='')?'<sup class="small_price">.'.$prices[1].'</sup>':'';
		$sum_group = ($sum_group!='')?'<div  class="rkt_pricing_sum_wp"><span class="rkt_pricing_sum_group">'.$sum_group.'</span></div>':'';
		$per = ($per!='')?'<span class="rkt_pricing_per">'.$per.'</span>':'';
		if ($button_url != '' || $button_text != '') {
			$btn_link = sprintf('<a class="rkt-btn btn-color" href="%s">%s</a>',
								($button_url!='')?$button_url:'#',
								($button_text != '')?$button_text:'BUY NOW');		
		}
		$ft_class = $ft_title = '';
		if ($featured == 'on') {
			$ft_class = 'rkt_iterm_featured';
			$ft_title = '<h3 class="rkt_pricing_subtitle text-center">'.$subtitle.'</h3>';
		}
		global $rkt_pricing_iterm;
		$rkt_pricing_iterm[] = '<div class="rkt_pricing_iterm '.$ft_class.'">
									'.$ft_title.'
									<div class="rkt_pricing_header">
										<h2 class="rkt_pricing_title text-center">'.$title.'</h2>
										<div class="rkt_price_wrap">
											<div class="rkt_price_group text-center">
												<div class="rkt_price_inner">
													<sup class="currency">'.$currency.'</sup>
													<span class="big_price">'.$price.'</span>
													'.$small_price.'
													'.$per.'
												</div>
											</div>
											'.$sum_group.'
										</div>
									</div>
									<div class="rkt_pricing_info">
										<div class="rkt_pricing_content">
											'.$this->shortcode_content.'
										</div>
										<div class="rkt_pricing_btn">
											'.$btn_link.'
										</div>
									</div>
								</div>';
		return '';
	}
}
new Rocket_Theme_Module_Pricing_Item;