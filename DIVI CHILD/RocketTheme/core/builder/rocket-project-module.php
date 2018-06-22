<?php

class ET_Builder_Module_Rocket_Project extends ET_Builder_Module {
	function init() {
		$this->name       = esc_html__( 'Rocket Project', 'rkt_builder' );
		$this->slug       = 'et_pb_rkt_projects';
		$this->child_slug = 'et_pb_rkt_project_iterm';
		$this->fb_support = true;

		$this->whitelisted_fields = array(
			'title',
			'posts_number',
			'color_layout',
			'admin_label',
			'module_id',
			'module_class',
		);

		$this->fields_defaults = array();

		$this->options_toggles = array(
			'general'  => array(
				'toggles' => array(
					'main_content' => esc_html__( 'Content', 'rkt_builder' ),
				),
			),
			'advanced' => array(
				'toggles' => array(
					'text'       => array(
						'title'    => esc_html__( 'Text', 'rkt_builder' ),
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
				'label'       => esc_html__( 'Title', 'rkt_builder' ),
				'type'        => 'text',
				'description' => esc_html__('Title displayed above on the tabs.', 'rkt_builder' ),
				'toggle_slug'       => 'main_content',
			),
			'posts_number' => array(
				'label'             => esc_html__( 'Posts Number', 'rkt_builder' ),
				'type'              => 'text',
				'option_category'   => 'configuration',
				'description'       => esc_html__( 'Choose how much project you would like to display per page.', 'rkt_builder' ),
				'toggle_slug'       => 'main_content',
			),
			'color_layout' => array(
				'label'           => esc_html__( 'Text Color', 'rkt_builder' ),
				'type'            => 'select',
				'option_category' => 'color_option',
				'options'         => array(
					'light' => esc_html__( 'Dark', 'rkt_builder' ),
					'dark'  => esc_html__( 'Light', 'rkt_builder' ),
				),
				'tab_slug'        => 'advanced',
				'toggle_slug'     => 'text',
				'description'     => esc_html__( 'Here you can choose whether your text should be light or dark. If you are working with a dark background, then your text should be light. If your background is light, then your text should be set to dark.', 'rkt_builder' ),
			),

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
		$module_id           = $this->shortcode_atts['module_id'];
		$module_class        = $this->shortcode_atts['module_class'];
		$posts_number        = $this->shortcode_atts['posts_number'];
		$color_layout        = $this->shortcode_atts['color_layout'];
		$wptitle             = $this->shortcode_atts['title'];
		global $project_iterms;
		$module_class = ET_Builder_Element::add_module_order_class( $module_class, $function_name );
		$tbs_header = $tbs_content = $tbs_carousel ='';
		$output = '';
		if (!empty($project_iterms)):
			foreach ($project_iterms as $key => $project) {
				$project = (OBJECT) $project;
				$term = get_term( $project->term_id, 'project_category', OBJECT );
				$title = ($project->title!='')?$project->title:$term->name;
				$tbs_ctid = 'tbs_content'.$key.''.$project->term_id;
				$tbs_crid = 'tbs_crid'.$key.''.$project->term_id;
				$clactive = ($key==0)?'active':'';
				$all_project = $this->get_project_post($project->term_id,$posts_number);

				$tbs_header .= '<li>
									<a data-termid="'.$project->term_id.'" class="rkt_tbs_tab '.$clactive.'" data-tbs_content="'.$tbs_ctid.'" data-tbs_carousel="'.$tbs_crid.'">'.$title.'</a>
								</li>';
				$tbs_content .= '<div id="'.$tbs_ctid.'" class="rkt_tbs_content '.$clactive.'">
									'.$project->content.'
								</div>';

				$tbj_content .= '<div id="'.$tbs_crid.'" class="rkt_tpc_carousel '.$clactive.'">
									<div class="rkt_project_carousel">
										'.$all_project.'
									</div>
								</div>';
			}
			$output = sprintf('<div class="rkt-projects">
									<div class="rkt-projects-inner">
										<div class="row_fl">
											<div class="col-xs-12 col-md-5 col-lg-4 pull-right">
												<div class="rkt-projects-tabs">
													%s
													<div class="rkt-prt-header">
														<ul class="rkt-prt-tabs">
															'.$tbs_header.'
														</ul>
													</div>
													<div class="rkt-prt-content">
														'.$tbs_content.'
													</div>
													<div class="prt-btn-group text-right">
														<a class="rkt-btn btn-showpr btn-color" href="#">See portfolio</a>
													</div>
												</div>
											</div>
											<div class="col-xs-12 col-md-7 col-lg-8">
												<div class="rkt-projects-carousels">
													<div class="rkt-prjc-inner">
														'.$tbj_content.'
													</div>
												</div>
											</div>
										</div>
									</div>
									<div id="rkt_project_popup_wp" style="display: none;">
										<div class="rkt-pp_content"></div>
										<div class="rkt-pp_close"><i class="fa fa-times-circle-o"></i>
										</div>
									</div>
								</div>',
								($wptitle!= '')?'<h2 class="rkt-projects-title">'.$wptitle.'</h2>':''	
							);
			$project_iterms = array();
		endif;


		$output = sprintf('<div id="%s" class="%s rktpj-layout-%s et_pb_rkt_project_iterm">%s</div>',
							$module_id,
							$module_class,
							$color_layout,
							$output);
		return $output;

	}

	public function get_project_post($term_id,$numpost = 6)
	{
		$args = array('post_type' => 'project',
						'posts_per_page' => ($numpost!='')?$numpost:6 ,
						'post_status' => 'publish',
						'tax_query' => array(
										array(
											'taxonomy' => 'project_category',
											'terms' => $term_id,
											'field' => 'term_id'
										)
									),
					);
		$project_query = new WP_Query( $args );
		$output = '';
		if ($project_query->have_posts()) {
			while ($project_query->have_posts()) {
				$project_query->the_post();
				$output .= '<div class="rkt_prc-iterm" data-pitem="'.get_the_ID().'">
								<div class="rkt_prc-image">
									'.get_the_post_thumbnail(get_the_ID(),'full').'
								</div>
								<div class="rkt_prc-info">
									<div class="rkt_prc-title_group">
										<a href="'.get_the_permalink().'" >
											<h3 class="portfolio_title">'.get_the_title().'</h3>
										</a>
										<span class="portfolio_author">
											By '.get_the_author().'
										</span>
									</div>
									<div class="rkt_prc-content">
										'.wp_trim_words( get_the_content(), 15,'.' ).'
									</div>
								</div>
							</div>';	
			}
			wp_reset_query();
		}
		return $output;
	}

}

new ET_Builder_Module_Rocket_Project;




class ET_Builder_Module_Project_Iterm extends ET_Builder_Module {
	function init() {
		$this->name                        = esc_html__( 'Project Iterm', 'rkt_builder' );
		$this->slug                        = 'et_pb_rkt_project_iterm';
		$this->fb_support                  = true;
		$this->type                        = 'child';
		$this->child_title_var             = 'title';

		$this->whitelisted_fields = array(
			'title',
			'include_category',
			'content_new',
		);

		$this->advanced_setting_title_text = esc_html__( 'Project Iterm', 'rkt_builder' );
		$this->settings_text               = esc_html__( 'Project Iterm Settings', 'rkt_builder' );
		$this->main_css_element = '%%order_class%%';

		$this->options_toggles = array(
			'general'  => array(
				'toggles' => array(
					'main_content' => esc_html__( 'Main Content', 'rkt_builder' ),
				),
			),
		);

		$this->advanced_options = array();

		$this->custom_css_options = array();
	}


	function get_fields() {
		/* Add option custom taxonomy */
		$terms = get_terms( 'project_category', array(
			'hide_empty' => false,
		));
		$option = array();
		if (isset($terms[0]->term_id)) {
			foreach ($terms as $key => $term) {
				$option[$term->term_id] = $term->name;
			}
		}

		$fields = array(
			'title' => array(
				'label'       => esc_html__( 'Title', 'rkt_builder' ),
				'type'        => 'text',
				'description' => esc_html__( 'The title will be used within the tab button for this tab.','rkt_builder' ),
				'toggle_slug' => 'main_content',
			),
			'include_category' => array(
				'label'           => esc_html__( 'Project Category', 'rkt_builder' ),
				'type'            => 'select',
				'option_category' => 'basic_option',
				'options'         => $option,
				'toggle_slug'     => 'main_content',
				'description'     => esc_html__('Choose which Project Category you would like to include.','rkt_builder'),
			),
			'content_new' => array(
				'label'       => esc_html__( 'Content', 'rkt_builder' ),
				'type'        => 'tiny_mce',
				'description' => esc_html__( 'Here you can define the content that will be placed within the current tab.', 'rkt_builder' ),
				'toggle_slug' => 'main_content',
			),
		);
		return $fields;
	}

	function shortcode_callback( $atts, $content = null, $function_name ) {
		global $project_iterms;
		$project_iterms = (empty($project_iterms))?array():$project_iterms;

		$count = (count($project_iterms)>0)?count($project_iterms):0;

		$title     = $this->shortcode_atts['title'];
		$category  = $this->shortcode_atts['include_category'];
		$content   = $this->shortcode_content;

		$project_iterms[$count]['title']	 = $title;
		$project_iterms[$count]['content'] = $content;
		$project_iterms[$count]['term_id'] = $category;
	}

}
new ET_Builder_Module_Project_Iterm;