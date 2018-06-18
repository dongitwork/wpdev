<?php 

class WP_Widget_News_Posts extends WP_Widget {

	/**
	 * Sets up a new Recent Posts widget instance.
	 *
	 * @since 2.8.0
	 */
	public function __construct() {
		$widget_ops = array(
			'classname' => 'dns_recent_entries col-xs-12 col-sm-5 col-md-4',
			'description' => __( 'Bài viết mới nhất.' ),
			'customize_selective_refresh' => true,
		);
		parent::__construct( 'news-posts', __( 'Bài viết mới nhất.' ), $widget_ops );
		$this->alt_option_name = 'dns_recent_entries';
	}

	/**
	 * Outputs the content for the current Recent Posts widget instance.
	 *
	 * @since 2.8.0
	 *
	 * @param array $args     Display arguments including 'before_title', 'after_title',
	 *                        'before_widget', and 'after_widget'.
	 * @param array $instance Settings for the current Recent Posts widget instance.
	 */
	public function widget( $args, $instance ) {
		if ( ! isset( $args['widget_id'] ) ) {
			$args['widget_id'] = $this->id;
		}

		$title = ( ! empty( $instance['title'] ) ) ? $instance['title'] : __( 'Bài viết mới nhất' );

		/** This filter is documented in wp-includes/widgets/class-wp-widget-pages.php */
		$title = apply_filters( 'widget_title', $title, $instance, $this->id_base );

		$number = ( ! empty( $instance['number'] ) ) ? absint( $instance['number'] ) : 5;
		if ( ! $number ) {
			$number = 5;
		}
		$show_date = isset( $instance['show_date'] ) ? $instance['show_date'] : false;
		$show_image = isset( $instance['show_image'] ) ? $instance['show_image'] : false;
		$show_rand = isset( $instance['show_rand'] ) ? $instance['show_rand'] : false;
		$incat = isset( $instance['incat'] ) ?  $instance['incat'] : '';
		$link_more = isset( $instance['link_more'] ) ?  $instance['link_more'] : '';

		/**
		 * Filters the arguments for the Recent Posts widget.
		 *
		 * @since 3.4.0
		 * @since 4.9.0 Added the `$instance` parameter.
		 *
		 * @see WP_Query::get_posts()
		 *
		 * @param array $args     An array of arguments used to retrieve the recent posts.
		 * @param array $instance Array of settings for the current widget.
		*/
			$qargs = array(
				'posts_per_page'      => $number,
				'no_found_rows'       => true,
				'post_status'         => 'publish',
				'ignore_sticky_posts' => true,
			);

			// Check category
			if (isset($incat) && is_numeric($incat)) {
				$qargs['cat'] = $incat;
			}	

			// Check order
			if ($show_rand == true) {
				$qargs['orderby'] = 'rand';
			}

			$r = new WP_Query( apply_filters( 'widget_posts_args', $qargs, $instance ) );

			if ( ! $r->have_posts() ) {
				return;
			}
		?>
		<?php echo $args['before_widget']; ?>
		<?php
			if ( $title ) {
				echo $args['before_title'] . $title . $args['after_title'];
			}
		?>
		<?php if ($show_image == true): ?>
			<div class="news_recent_posts">
				<?php foreach ( $r->posts as $recent_post ) : ?>
					<?php
						$post_title = get_the_title( $recent_post->ID );
						$title      = ( ! empty( $post_title ) ) ? $post_title : __( '(no title)' );
						
					?>

						<div class="crpost-iterm ">
						    <div class="row">
						    	<div class="col-xs-4">
						    		<a href="<?php the_permalink($recent_post->ID); ?>" class="d_block photoframe ">
										<?php 
											the_dns_image(array(225,300),'img-responsive tr_all_long_hover',get_the_post_thumbnail_url( $recent_post->ID, 'full' )) ;
										?>
									</a>
						    	</div>
						    	<div class="col-xs-8">
						    		 <div class="mini_post_content">
								        <h2 class="post-title ">
								        	<a href="<?php the_permalink($recent_post->ID); ?>" class="color_dark">
								        		<?=$title; ?>
								        	</a>
								        </h2>
								        <div class="post_meta">
								        	<span class="fa fa-calendar "></span> <?php print get_the_date('d/m/Y', $recent_post->ID ); ?>
								        </div>
								        <div class="post_content">
								        	<?php print wp_trim_words(get_the_content($recent_post->ID),15,'...'); ?>
								        </div>
								        <div class="post_more text-right">
								        	<a class="more-btn" href="<?php the_permalink($recent_post->ID); ?>">Xem thêm <i class="fa fa-angle-double-right"></i></a>
								        </div>
								    </div>
						    	</div>
						    </div>
                        </div>
				<?php endforeach; ?>
			</div>
		<?php else: ?>
			<ul class="dns_recent_posts dns_list_style">
				<?php foreach ( $r->posts as $recent_post ) : ?>
					<?php
					$post_title = get_the_title( $recent_post->ID );
					$title      = ( ! empty( $post_title ) ) ? $post_title : __( '(no title)' );
					?>
					<li>
						<a href="<?php the_permalink( $recent_post->ID ); ?>"><?php echo $title ; ?></a>
						<?php if ( $show_date ) : ?>
							<span class="post-date"><?php echo get_the_date( '', $recent_post->ID ); ?></span>
						<?php endif; ?>
					</li>
				<?php endforeach; ?>
			</ul>
		<?php endif; ?>
		<?php if($link_more != ''): ?>
				<div class="views_more">
					<a href="<?=$link_more?>" class="btn-site btn-border">Xem thêm</a>
				</div>
			<?php endif; ?>
		<?php
		echo $args['after_widget'];
	}

	/**
	 * Handles updating the settings for the current Recent Posts widget instance.
	 *
	 * @since 2.8.0
	 *
	 * @param array $new_instance New settings for this instance as input by the user via
	 *                            WP_Widget::form().
	 * @param array $old_instance Old settings for this instance.
	 * @return array Updated settings to save.
	 */
	public function update( $new_instance, $old_instance ) {
		$instance = $old_instance;
		$instance['title'] = sanitize_text_field( $new_instance['title'] );
		$instance['link_more'] = sanitize_text_field( $new_instance['link_more'] );
		$instance['number'] = (int) $new_instance['number'];
		$instance['show_date'] = isset( $new_instance['show_date'] ) ? (bool) $new_instance['show_date'] : false;
		$instance['show_image'] = isset( $new_instance['show_image'] ) ? (bool) $new_instance['show_image'] : false;
		$instance['show_rand'] = isset( $new_instance['show_rand'] ) ? (bool) $new_instance['show_rand'] : false;
		$instance['incat'] = isset( $new_instance['incat'] ) ?  $new_instance['incat'] : '';
		return $instance;
	}

	/**
	 * Outputs the settings form for the Recent Posts widget.
	 *
	 * @since 2.8.0
	 *
	 * @param array $instance Current settings.
	 */
	public function form( $instance ) {
		$title     = isset( $instance['title'] ) ? esc_attr( $instance['title'] ) : '';
		$link_more     = isset( $instance['link_more'] ) ? esc_attr( $instance['link_more'] ) : '';
		$number    = isset( $instance['number'] ) ? absint( $instance['number'] ) : 5;
		$show_date = isset( $instance['show_date'] ) ? (bool) $instance['show_date'] : false;
		$show_image = isset( $instance['show_image'] ) ? (bool) $instance['show_image'] : false;
		$show_rand = isset( $instance['show_rand'] ) ? (bool) $instance['show_rand'] : false;
		$incat 	   = isset( $instance['incat'] ) ? $instance['incat'] : '';
	?>
				<p><label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title:' ); ?></label>
				<input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo $title; ?>" /></p>


				<p><label for="<?php echo $this->get_field_id( 'number' ); ?>"><?php _e( 'Number of posts to show:' ); ?></label>
				<input class="tiny-text" id="<?php echo $this->get_field_id( 'number' ); ?>" name="<?php echo $this->get_field_name( 'number' ); ?>" type="number" step="1" min="1" value="<?php echo $number; ?>" size="3" /></p>

				<p><input class="checkbox" type="checkbox" <?php checked( $show_date ); ?> id="<?php echo $this->get_field_id( 'show_date' ); ?>" name="<?php echo $this->get_field_name( 'show_date' ); ?>" />
				<label for="<?php echo $this->get_field_id( 'show_date' ); ?>"><?php _e( 'Display post date?' ); ?></label></p>

				<p><input class="checkbox" type="checkbox" <?php checked( $show_image ); ?> id="<?php echo $this->get_field_id( 'show_image' ); ?>" name="<?php echo $this->get_field_name( 'show_image' ); ?>" />
				<label for="<?php echo $this->get_field_id( 'show_image' ); ?>"><?php _e( 'Display post image?' ); ?></label></p>
				<p><input class="checkbox" type="checkbox" <?php checked( $show_rand ); ?> id="<?php echo $this->get_field_id( 'show_rand' ); ?>" name="<?php echo $this->get_field_name( 'show_rand' ); ?>" />
				<label for="<?php echo $this->get_field_id( 'show_rand' ); ?>"><?php _e( 'Display post Random?' ); ?></label></p>
				<p>
					<label for="<?php echo $this->get_field_id( 'incat' ); ?>"><?php _e( 'Select Category' ); ?></label>
					 <select class='widefat' id="<?php echo $this->get_field_id( 'incat' ); ?>" name="<?php echo $this->get_field_name( 'incat' ); ?>" type="text">
			            <?php  
				           	$option = '<option value="">Select Category</option>'; 
					        $categories = get_categories(array('hide_empty'       => 0)); 
					        foreach ($categories as $category) {
					            $option .= '<option value="'.$category->term_id.'" '.selected( $incat, $category->term_id ).'>';
					            $option .= $category->cat_name;
					            $option .= ' ('.$category->category_count.')';
					            $option .= '</option>';
					        }
					        echo $option; 
				        ?> 
			        </select>      
		        </p>       
		        <p><label for="<?php echo $this->get_field_id( 'link_more' ); ?>"><?php _e( 'Link Xem thêm:' ); ?></label>
				<input class="widefat" id="<?php echo $this->get_field_id( 'link_more' ); ?>" name="<?php echo $this->get_field_name( 'link_more' ); ?>" type="text" value="<?php echo $link_more; ?>" /></p>

		<?php
	}
}
add_action( 'widgets_init', function(){
	register_widget( 'WP_Widget_News_Posts' );
	register_widget( 'DNS_Widget_News_by_ID' );
	register_widget( 'DNS_Widget_Products' );
	register_widget( 'DNS_Widget_Tags' );
});

class DNS_Widget_News_by_ID extends WC_Widget {

	/**
	 * Constructor.
	 */
	public function __construct() {
		$this->widget_cssclass    = 'dns_news_by_id';
		$this->widget_description = __( "DNS List News By ID", 'woocommerce' );
		$this->widget_id          = 'dns_news_by_id';
		$this->widget_name        = __( 'DNS List News By ID', 'woocommerce' );
		$this->settings           = array(
			'title'       => array(
				'type'  => 'text',
				'std'   => __( '', 'woocommerce' ),
				'label' => __( 'Title', 'woocommerce' ),
			),
			'number'      => array(
				'type'  => 'number',
				'step'  => 1,
				'min'   => 1,
				'max'   => '',
				'std'   => 5,
				'label' => __( 'Number of news to show', 'woocommerce' ),
			),
			'type'        => array(
				'type'    => 'select',
				'std'     => 'by_cat',
				'label'   => __( 'Box Type', 'woocommerce' ),
				'options' => array(
					'by_cat'		=> __( 'Theo Danh Mục', '' ),
					'by_tags' 		=> __( 'Theo Tags', '' ),
					'by_oldid'   	=> __( 'Bài Viết Cũ Hơn', '' ),
					'by_newid'   	=> __( 'Bài Viết Mới Hơn', '' ),
					'views_more'   	=> __( 'Xem Nhiều Nhất', '' ),
					'views_recent'	=> __( 'Bài mới nhất', '' ),
					'views_old'   	=> __( 'Bài Cũ nhất', '' ),
				),
			),
			'layout'        => array(
				'type'    => 'select',
				'std'     => 'slider_image',
				'label'   => __( 'Layout', 'woocommerce' ),
				'options' => array(
					'slider_image'	=> __( 'Images Slider', 'woocommerce' ),
					'image_text' 	=> __( 'Image Text', 'woocommerce' ),
					'list_style'   	=> __( 'List Only', 'woocommerce' ),
				),
			),
			'hide_title'   => array(
				'type'  => 'checkbox',
				'std'   => 0,
				'label' => __( 'Hide Title', 'woocommerce' ),
			),
			'has_container' => array(
				'type'  => 'checkbox',
				'std'   => 1,
				'label' => __( 'Has Container', 'woocommerce' ),
			),
		);

		parent::__construct();
	}


	/**
	 * Output widget.
	 *
	 * @see WP_Widget
	 *
	 * @param array $args     Arguments.
	 * @param array $instance Widget instance.
	 */
	public function widget( $args, $instance ) {
		if ( $this->get_cached_widget( $args ) ) {
			return;
		}

		$number = !empty( $instance['number'] ) ? absint( $instance['number'] ) : $this->settings['number']['std'];
		$has_container = !empty( $instance['has_container'] ) ? absint( $instance['has_container'] ) : $this->settings['has_container']['std'];
		$hide_title =!empty($instance['hide_title'])?absint($instance['hide_title']):$this->settings['hide_title']['std'];

		$layout = !empty($instance['layout']) ? sanitize_title($instance['layout']) : $this->settings['layout']['std'];
		$type = !empty($instance['type']) ? sanitize_title($instance['type']) : $this->settings['type']['std'];
		$title = !empty($instance['title']) ? sanitize_title($instance['title']) : $this->settings['title']['std'];

		ob_start();
		echo do_shortcode('[news_by_id title="'.$title.'" number='.$number.' type="'.$type.'" layout="'.$layout.'" hide_title='.$hide_title.' has_container='.$has_container.' ]' );

		echo $this->cache_widget( $args, ob_get_clean() ); // WPCS: XSS ok.
	}
}


/**
 * Widget products.
 */
class DNS_Widget_Products extends WC_Widget {

	/**
	 * Constructor.
	 */
	public function __construct() {
		$this->widget_cssclass    = 'dns_widget_products widget_products';
		$this->widget_description = __( "DNS List Products", 'woocommerce' );
		$this->widget_id          = 'dns_widget_products';
		$this->widget_name        = __( 'DNS List Products', 'woocommerce' );
		$this->settings           = array(
			'title'       => array(
				'type'  => 'text',
				'std'   => __( 'Products', 'woocommerce' ),
				'label' => __( 'Title', 'woocommerce' ),
			),
			'number'      => array(
				'type'  => 'number',
				'step'  => 1,
				'min'   => 1,
				'max'   => '',
				'std'   => 5,
				'label' => __( 'Number of products to show', 'woocommerce' ),
			),
			'show'        => array(
				'type'    => 'select',
				'std'     => '',
				'label'   => __( 'Show', 'woocommerce' ),
				'options' => array(
					''         => __( 'All products', 'woocommerce' ),
					'featured' => __( 'Featured products', 'woocommerce' ),
					'onsale'   => __( 'On-sale products', 'woocommerce' ),
				),
			),
			'orderby'     => array(
				'type'    => 'select',
				'std'     => 'date',
				'label'   => __( 'Order by', 'woocommerce' ),
				'options' => array(
					'date'  => __( 'Date', 'woocommerce' ),
					'price' => __( 'Price', 'woocommerce' ),
					'rand'  => __( 'Random', 'woocommerce' ),
					'sales' => __( 'Sales', 'woocommerce' ),
					'shows' => __( 'Show Views', 'woocommerce' ),
				),
			),
			'order'       => array(
				'type'    => 'select',
				'std'     => 'desc',
				'label'   => _x( 'Sắp xếp', 'Sorting order', 'woocommerce' ),
				'options' => array(
					'asc'  => __( 'ASC', 'woocommerce' ),
					'desc' => __( 'DESC', 'woocommerce' ),
				),
			),
			'hide_free'   => array(
				'type'  => 'checkbox',
				'std'   => 0,
				'label' => __( 'Hide free products', 'woocommerce' ),
			),
			'show_hidden' => array(
				'type'  => 'checkbox',
				'std'   => 0,
				'label' => __( 'Show hidden products', 'woocommerce' ),
			),
		);

		parent::__construct();
	}

	/**
	 * Query the products and return them.
	 *
	 * @param  array $args     Arguments.
	 * @param  array $instance Widget instance.
	 * @return WP_Query
	 */
	public function get_products( $args, $instance ) {
		$number                      = ! empty( $instance['number'] ) ? absint( $instance['number'] ) : $this->settings['number']['std'];
		$show                        = ! empty( $instance['show'] ) ? sanitize_title( $instance['show'] ) : $this->settings['show']['std'];
		$orderby                     = ! empty( $instance['orderby'] ) ? sanitize_title( $instance['orderby'] ) : $this->settings['orderby']['std'];
		$order                       = ! empty( $instance['order'] ) ? sanitize_title( $instance['order'] ) : $this->settings['order']['std'];
		$product_visibility_term_ids = wc_get_product_visibility_term_ids();

		$query_args = array(
			'posts_per_page' => $number,
			'post_status'    => 'publish',
			'post_type'      => 'product',
			'no_found_rows'  => 1,
			'order'          => $order,
			'meta_query'     => array(),
			'tax_query'      => array(
				'relation' => 'AND',
			),
		); // WPCS: slow query ok.

		if ( empty( $instance['show_hidden'] ) ) {
			$query_args['tax_query'][] = array(
				'taxonomy' => 'product_visibility',
				'field'    => 'term_taxonomy_id',
				'terms'    => is_search() ? $product_visibility_term_ids['exclude-from-search'] : $product_visibility_term_ids['exclude-from-catalog'],
				'operator' => 'NOT IN',
			);
			$query_args['post_parent'] = 0;
		}

		if ( 'yes' === get_option( 'woocommerce_hide_out_of_stock_items' ) ) {
			$query_args['tax_query'] = array(
				array(
					'taxonomy' => 'product_visibility',
					'field'    => 'term_taxonomy_id',
					'terms'    => $product_visibility_term_ids['outofstock'],
					'operator' => 'NOT IN',
				),
			); // WPCS: slow query ok.
		}

		switch ( $show ) {
			case 'featured':
				$query_args['tax_query'][] = array(
					'taxonomy' => 'product_visibility',
					'field'    => 'term_taxonomy_id',
					'terms'    => $product_visibility_term_ids['featured'],
				);
				break;
			case 'onsale':
				$product_ids_on_sale    = wc_get_product_ids_on_sale();
				$product_ids_on_sale[]  = 0;
				$query_args['post__in'] = $product_ids_on_sale;
				break;
		}

		switch ( $orderby ) {
			case 'price':
				$query_args['meta_key'] = '_price'; // WPCS: slow query ok.
				$query_args['orderby']  = 'meta_value_num';
				break;
			case 'rand':
				$query_args['orderby'] = 'rand';
				break;
			case 'sales':
				$query_args['meta_key'] = 'total_sales'; // WPCS: slow query ok.
				$query_args['orderby']  = 'meta_value_num';
			case 'shows':
				$query_args['meta_key'] = 'post_views_count'; // WPCS: slow query ok.
				$query_args['orderby']  = 'post_views_count';
				break;
			default:
				$query_args['orderby'] = 'date';
		}

		return new WP_Query( apply_filters( 'woocommerce_products_widget_query_args', $query_args ) );
	}

	/**
	 * Output widget.
	 *
	 * @see WP_Widget
	 *
	 * @param array $args     Arguments.
	 * @param array $instance Widget instance.
	 */
	public function widget( $args, $instance ) {
		if ( $this->get_cached_widget( $args ) ) {
			return;
		}

		ob_start();

		$products = $this->get_products( $args, $instance );
		if ( $products && $products->have_posts() ) {
			$this->widget_start( $args, $instance );

			echo wp_kses_post( apply_filters( 'woocommerce_before_widget_product_list', '<ul class="product_list_widget row">' ) );

			$template_args = array(
				'widget_id'   => $args['widget_id'],
				'show_rating' => true,
			);

			while ( $products->have_posts() ) {
				$products->the_post();
				wc_get_template( 'content-widget-product.php', $template_args );
			}

			echo wp_kses_post( apply_filters( 'woocommerce_after_widget_product_list', '</ul>' ) );

			$this->widget_end( $args );
		}

		wp_reset_postdata();

		echo $this->cache_widget( $args, ob_get_clean() ); // WPCS: XSS ok.
	}
}


/**
 * Widget Loop products.
 */
class DNS_Widget_Tags extends WC_Widget {

	/**
	 * Constructor.
	 */
	public function __construct() {
		$this->widget_cssclass    = 'dns_widget_tags widget_products';
		$this->widget_description = __( "DNS Tags Cloud", 'woocommerce' );
		$this->widget_id          = 'dns_widget_tags';
		$this->widget_name        = __( 'DNS Tags Cloud', 'woocommerce' );

		$this->settings           = array(
			'title'       => array(
				'type'  => 'text',
				'std'   => __( 'Tags Cloud', 'woocommerce' ),
				'label' => __( 'Title', 'woocommerce' ),
			),
			'number'      => array(
				'type'  => 'number',
				'step'  => 1,
				'min'   => 1,
				'max'   => '',
				'std'   => 15,
				'label' => __( 'Number of tags to show', 'woocommerce' ),
			),
			'show'        => array(
				'type'    => 'select',
				'std'     => '',
				'label'   => __( 'Show', 'woocommerce' ),
				'options' => array(
					'product_tag'   => __( 'Product', 'woocommerce' ),
					'post_tag' 		=> __( 'Post', 'woocommerce' ),
				),
			),
			'order'       => array(
				'type'    => 'select',
				'std'     => 'desc',
				'label'   => _x( 'Sorting', 'Sorting order', 'woocommerce' ),
				'options' => array(
					'asc'  => __( 'ASC', 'woocommerce' ),
					'desc' => __( 'DESC', 'woocommerce' ),
				),
			),
			
		);

		parent::__construct();
	}

	/**
	 * Query the Tags and return them.
	 *
	 * @param  array $args     Arguments.
	 * @param  array $instance Widget instance.
	 * @return WP_Query
	 */
	public function get_dns_tags( $args, $instance ) {
		$number	= ! empty( $instance['number'] ) ? absint( $instance['number'] ) : $this->settings['number']['std'];
		$show	= ! empty( $instance['show'] ) ? sanitize_title( $instance['show'] ) : $this->settings['show']['std'];
		$order	= ! empty( $instance['order'] ) ? sanitize_title( $instance['order'] ) : $this->settings['order']['std'];

		$terms = get_terms( array( 
			    'taxonomy' => $show,
			    'orderby' => 'count',
            	'order' => $order,
			) );
		if (isset($terms[0])) {
			return $terms;
		}
		return ;
	}

	/**
	 * Output widget.
	 *
	 * @see WP_Widget
	 *
	 * @param array $args     Arguments.
	 * @param array $instance Widget instance.
	 */
	public function widget( $args, $instance ) {
		if ( $this->get_cached_widget( $args ) ) {
			return;
		}

		//ob_start();
		if ( ! isset( $args['widget_id'] ) ) {
			$args['widget_id'] = $this->id;
		}

		$title = ( ! empty( $instance['title'] ) ) ? $instance['title'] : __( '' );
		echo $args['before_widget'];
		$number	= ! empty( $instance['number'] ) ? absint( $instance['number'] ) : $this->settings['number']['std'];
		$terms = $this->get_dns_tags( $args, $instance );
		if ($terms != '') {
			print '<span class="tagstitle">'.$title.'</span><ul>';
			foreach ($terms as $key => $term) {
				print sprintf('<li><a href="%s">%s</a></li>',get_term_link($term),$term->name);
				if ($key == $number - 1) {
					break;
				}				
			}
			print '</ul>';
		}
		echo $args['after_widget'];

		//echo $this->cache_widget( $args, ob_get_clean() ); 
	}
}
