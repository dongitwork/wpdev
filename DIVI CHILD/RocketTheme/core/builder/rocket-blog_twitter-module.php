<?php
/*
* Module Rocket Blogs Twitter
*/
class Module_Rocket_Blog_Twitter extends ET_Builder_Module_Type_PostBased {
	function init() {
		$this->name       = esc_html__( 'Rocket Blogs Twitter', 'rkt_builder' );
		$this->slug       = 'et_pb_rkt_blog_twitter';
		$this->fb_support = true;

		$this->whitelisted_fields = array(
			'title',
			'posts_number',
			'include_categories',
			'user_icon',
			'content_new',
			'url',
			'date',
			'btn_text',
			'admin_label',
			'module_id',
			'module_class',
		);

		$this->fields_defaults = array();

		$this->options_toggles = array(
			'general'  => array(
				'toggles' => array(
					'main_content' => esc_html__( 'Main Content', 'rkt_builder' ),
					'link'         => esc_html__( 'Link', 'rkt_builder' ),
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
				'description'       => esc_html__( 'Choose how much posts you would like to display per page.', 'rkt_builder' ),
				'computed_affects'   => array(
					'__posts',
				),
				'toggle_slug'       => 'main_content',
			),
			'include_categories' => array(
				'label'            => esc_html__( 'Include Categories', 'rkt_builder' ),
				'renderer'         => 'et_builder_include_categories_option',
				'option_category'  => 'basic_option',
				'renderer_options' => array(
					'use_terms' => false,
				),
				'description'      => esc_html__( 'Choose which categories you would like to include in the feed.', 'rkt_builder' ),
				'toggle_slug'      => 'main_content',
				'computed_affects' => array(
					'__posts',
				),
			),
			'content_new' => array(
				'label'             => esc_html__( 'Content', 'rkt_builder' ),
				'type'              => 'tiny_mce',
				'option_category'   => 'basic_option',
				'description'       => esc_html__( 'Input the main text content for your module here.', 'rkt_builder' ),
				'toggle_slug'       => 'main_content',
			),
			'date' => array(
				'label'           => esc_html__( 'Date', 'rkt_builder' ),
				'type'            => 'text',
				'option_category' => 'basic_option',
				'description'     => esc_html__( 'Input your Date here. Ex: July 06.2017', 'rkt_builder' ),
				'toggle_slug'     => 'link',
			),
			'btn_text' => array(
				'label'           => esc_html__( 'Button Text', 'rkt_builder' ),
				'type'            => 'text',
				'option_category' => 'basic_option',
				'description'     => esc_html__( 'Input your Text here. Ex: READ ALL TWEETS', 'rkt_builder' ),
				'toggle_slug'     => 'link',
			),
			'url' => array(
				'label'           => esc_html__( 'Url', 'rkt_builder' ),
				'type'            => 'text',
				'option_category' => 'basic_option',
				'description'     => esc_html__( 'Input your URL here.', 'rkt_builder' ),
				'toggle_slug'     => 'link',
			),
			'user_icon' => array(
				'label'               => esc_html__( 'Icon Picker', 'rkt_builder' ),
				'type'                => 'text',
				'option_category'     => 'configuration',
				'class'               => array( 'et-pb-font-icon' ),
				'renderer'            => 'et_pb_get_font_icon_list',
				'renderer_with_field' => true,
				'description'         => esc_html__( 'Here you can define a custom icon for the title.', 'rkt_builder' ),
				'toggle_slug'         => 'main_content',
				'computed_affects'    => array(
					'__posts',
				),
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
		$include_categories  = $this->shortcode_atts['include_categories'];
		$user_icon           = $this->shortcode_atts['user_icon'];
		$url             	 = $this->shortcode_atts['url'];
		$title             	 = $this->shortcode_atts['title'];
		$date             	 = $this->shortcode_atts['date'];
		$btn_text            = $this->shortcode_atts['btn_text'];
		if ($user_icon !=='') {
			$user_icon = esc_attr( et_pb_process_font_icon( $user_icon ) );
		}
		$module_class = ET_Builder_Element::add_module_order_class( $module_class, $function_name );
		$output = '';
		$post_data = $this->get_project_post($include_categories,$user_icon,$posts_number);

		$rkt_text = '<div class="col-xs-6 col-xs-full col-sm-6 col-md-6">
						<div class="rkt-blog-text">
							<div class="rkt-bgt-info">
								<span class="et-pb-icon rkt-bgt-icon">'.$user_icon.'</span>
								<span class="rkt-bgt-date">'.$date.'</span>
							</div>
							<div class="rkt-bgt-content">
								'.$this->shortcode_content.'
							</div>
							<div class="rkt-bgt-btn">
								<a class="rkt-btn btn-color" href="'.$url.'" >'.$btn_text.'</a>
							</div>
						</div>
					</div>';

		if (!empty($post_data)) {
			$output = sprintf('<div id="'.$module_id.'" class="'.$module_class.'">
								<div class="rkt_blog_twitter_wp">
								    <div class="row_fl">
								        <div class="col-xs-12 col-md-6">
								            %s
								        </div>
								        <div class="col-xs-12 col-md-6">
								            <div class="row_fl">
								                %s %s
								            </div>
								        </div>
								    </div>
								</div>
							</div>',
							$post_data['post_first'],
							$post_data['all_post'],
							$rkt_text);
		}
		return $output;

	}

	public function get_project_post($term_id,$user_icon,$numpost = 4)
	{
		$args = array('post_type' => 'post',
						'posts_per_page' => $numpost ,
						'post_status' => 'publish',
					);
		if ( '' !== $term_id ){
			$args['cat'] = $term_id;
		}
		$blog_twqr = new WP_Query( $args );
		$post_first = $all_post = '';
		$output = array();
		if ($blog_twqr->have_posts()) {
			$i =1;
			while ($blog_twqr->have_posts()) {
				$blog_twqr->the_post();	
				if ($i == 1) {
					$bg_url = get_the_post_thumbnail_url( get_the_ID(), array(500,375,true));
					$post_first = '<div class="rkt-itermtw-first">
								    <div class="rkt-iterm-img" style="background-image: url(\''.$bg_url.'\');"></div>
								    <div class="rkt-iterm-overlay">
								        <div class="rkt-overlay-inner">
								            <a href="'.get_the_permalink().'">
								                <h3 class="rkt-iterm-title">
													<span class="et-pb-icon rkt-btw-icon">'.$user_icon.'</span> 
													'.get_the_title().'
												</h3>
								            </a>
								            <div class="rkt-iterm-content">
								                '.wp_trim_words( get_the_content(), 20, '.' ).'
								            </div>
								        </div>
								    </div>
								</div>';
				}else{
					$bg_url = get_the_post_thumbnail_url( get_the_ID(),array(240,185,true));
					$all_post .= '<div class="col-xs-6 col-xs-full col-sm-6 col-md-6">
								    <div class="rkt-itermtw">
								        <div class="rkt-iterm-img" style="background-image: url(\''.$bg_url.'\');"> </div>
								        <div class="rkt-iterm-overlay">
								            <div class="rkt-overlay-inner">
								                <a href="'.get_the_permalink().'">
								                    <h3 class="rkt-iterm-title">
														<span class="et-pb-icon rkt-btw-icon">'.$user_icon.'</span>
														'.get_the_title().'
													</h3>
								                </a>
								                <div class="rkt-iterm-content">
								                    '.wp_trim_words( get_the_content(), 8, '.' ).'
								                </div>
								            </div>
								        </div>
								    </div>
								</div>';
					}
				$i++;
			}
			wp_reset_query();
			if ($post_first!= '') {
				$output['post_first'] = $post_first;
				$output['all_post'] = $all_post;
			}
		}
		return $output;
	}

}

new Module_Rocket_Blog_Twitter;
