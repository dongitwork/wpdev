<?php 
class Rocket_Theme_Module_Tabs extends ET_Builder_Module {
	function init() {
		$this->name            = esc_html__( 'Rocket Tabs', 'et_builder' );
		$this->slug            = 'et_pb_rk_tabs';
		$this->fb_support      = true;
		$this->child_slug      = 'et_pb_rk_tab';
		$this->child_item_text = esc_html__( 'Tab', 'et_builder' );
		$this->whitelisted_fields = array(
			'admin_label',
			'module_id',
			'module_class',
		);
		$this->main_css_element = '%%order_class%%.et_pb_rk_tabs';
		$this->advanced_options = array();
		$this->custom_css_options = array();
	}

	function get_fields() {
		$fields = array(
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

		$module_class = ET_Builder_Element::add_module_order_class( $module_class, $function_name );
		$all_tabs_content = $this->shortcode_content;
		global $tabs_data;
		$datat_title = $tab_content = '';
		if (!empty($tabs_data)) {
			$i = 0;
			 foreach ($tabs_data as $tab_data) {
			 	$activecl = ($i == 0)?'active':'';
			 	$data_tab = trim($function_name).''.rand();
			 	if ($tab_data['external_icon'] == 'on') {
			 		$user_icon = '<span class="rkt_tab-icon '.$tab_data['icon_class'].'"> </span>';
			 	}else{
			 		$icon = esc_attr( et_pb_process_font_icon($tab_data['user_icon'] ) );
			 		$user_icon = '<span class="rkt_tab-icon"><i class="et-pb-icon">'.$icon.'</i></span>';
			 	}
			 	$datat_title .= '<li data-tab='.$data_tab.' class="col-sm-6 col-md-6 col-xxs-full col-xs-6 tab_title '.$activecl.' '.$tab_data['module_class'].'">
									<div class="title_inner">
										<div class="icon_tab">
											'.$user_icon.'
										</div>
										<div class="title_group">
											<h3>'.$tab_data['title'].'</h3>
											<div class="sub_title">
												'.$tab_data['subtitle'].'
											</div>
										</div>
									</div>
								</li>';
				$tab_content .= '<div id='.$data_tab.' class="tab_content  '.$activecl.' '.$tab_data['module_class'].'">
									<div class="icon_tab">
										'.$user_icon.'
									</div>
									<h3 class="tab_title">'.$tab_data['title'].'</h3>
									<div class="content">
										'.$tab_data['content'].'
									</div>
								</div>';
				$i++;
			 }
		}

		$output = '';
		if ($tab_content !='' && $tab_title =!'' ) {
			$output = '<div class="rocket_wp_tabs">
						<div class="row_fl">
							<div class="col-xs-12 col-sm-12 col-md-8 col-lg-7">
								<div class="data_tab_title">
									<ul class="row_fl">'.$datat_title.'</ul>
								</div>
							</div>
							<div class="col-xs-12 col-sm-12 col-md-4 col-lg-5">
								<div class="data_tab_content">
									'.$tab_content.'
								</div>
							</div>
						</div>
					</div>';
		}

		$tabs_data = array();
		return $output;
	}
}
new Rocket_Theme_Module_Tabs;

class Rocket_Theme_Module_Tabs_Item extends ET_Builder_Module {
	function init() {
		$this->name                        = esc_html__( 'Tab', 'et_builder' );
		$this->slug                        = 'et_pb_rk_tab';
		$this->fb_support                  = true;
		$this->type                        = 'child';
		$this->child_title_var             = 'title';

		$this->whitelisted_fields = array(
			'title',
			'subtitle',
			'external_icon',
			'icon_class',
			'user_icon',
			'content_new',
		);

		$this->advanced_setting_title_text = esc_html__( 'New Tab', 'et_builder' );
		$this->settings_text               = esc_html__( 'Tab Settings', 'et_builder' );
		$this->main_css_element = '%%order_class%%';

		$this->options_toggles = array(
			'general'  => array(
				'toggles' => array(
					'main_content' => esc_html__( 'Text', 'et_builder' ),
				),
			),
		);

		$this->advanced_options = array();

		$this->custom_css_options = array(
			'main_element' => array(
				'label'    => esc_html__( 'Main Element', 'et_builder' ),
				'selector' => ".et_pb_rk_tabs div{$this->main_css_element}.et_pb_rk_tab",
			)
		);
	}

	function get_fields() {
		$fields = array(
			'title' => array(
				'label'       => esc_html__( 'Title', 'et_builder' ),
				'type'        => 'text',
				'description' => esc_html__( 'The title will be used within the tab button for this tab.', 'et_builder' ),
				'toggle_slug' => 'main_content',
			),
			'subtitle' => array(
				'label'       => esc_html__( 'Sub Title', 'et_builder' ),
				'type'        => 'text',
				'description' => esc_html__( 'The text under title.', 'et_builder' ),
				'toggle_slug' => 'main_content',
			),
			'external_icon' => array(
				'label'           => esc_html__( 'External Icon', 'et_builder' ),
				'type'            => 'yes_no_button',
				'option_category' => 'basic_option',
				'options'         => array(
					'off' => esc_html__( 'No', 'et_builder' ),
					'on'  => esc_html__( 'Yes', 'et_builder' ),
				),
				'toggle_slug'     => 'main_content',
				'affects'         => array(
					'icon_class',
					'user_icon',
				),
				'description' => esc_html__( 'Here you can choose to use an external icon. Ex: fa fa-facebook', 'et_builder' ),
			),
			'icon_class' => array(
				'label'       => esc_html__( 'Icon Class', 'et_builder' ),
				'type'        => 'text',
				'description' => esc_html__( 'Here you please enter external icon', 'et_builder' ),
				'toggle_slug' => 'main_content',
				'depends_default' => true,
			),
			'user_icon' => array(
				'label'               => esc_html__( 'Icon Picker', 'rkt_builder' ),
				'type'                => 'text',
				'option_category'     => 'configuration',
				'class'               => array( 'et-pb-font-icon' ),
				'renderer'            => 'et_pb_get_font_icon_list',
				'renderer_with_field' => true,
				'description'         => esc_html__( 'Here you can define a custom icon.', 'rkt_builder' ),
				'toggle_slug'         => 'main_content',
				'computed_affects'    => array(
					'__posts',
				),
				'depends_show_if'    => 'off',
			),
			'content_new' => array(
				'label'       => esc_html__( 'Content', 'et_builder' ),
				'type'        => 'tiny_mce',
				'description' => esc_html__( 'Here you can define the content that will be placed within the current tab.', 'et_builder' ),
				'toggle_slug' => 'main_content',
			),
		);
		return $fields;
	}

	function shortcode_callback( $atts, $content = null, $function_name ) {
		global $tabs_data;
		$title 			= $this->shortcode_atts['title'];
		$subtitle 		= $this->shortcode_atts['subtitle'];
		$icon_class 	= $this->shortcode_atts['icon_class'];
		$external_icon 	= $this->shortcode_atts['external_icon'];
		$user_icon 		= $this->shortcode_atts['user_icon'];
		$module_class 	= ET_Builder_Element::add_module_order_class( '', $function_name );
		$t_data 		= trim($module_class);

		$tabs_data[$t_data]['title']  			= '' !== $title ? $title : esc_html__( 'Tab', 'et_builder' );
		$tabs_data[$t_data]['subtitle']  		= $subtitle;
		$tabs_data[$t_data]['external_icon']  	= $external_icon;
		$tabs_data[$t_data]['user_icon']  		= $user_icon;
		$tabs_data[$t_data]['icon_class']  		= $icon_class;
		$tabs_data[$t_data]['content']  		= $this->shortcode_content;
		$tabs_data[$t_data]['module_class']  	= $module_class;

		return '';
	}
}
new Rocket_Theme_Module_Tabs_Item;