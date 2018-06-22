<?php
/*
* All Magazine theme widgets
*/
function register_mz_widgets() {
    register_widget( 'Magazine_Recent_Posts' );
    register_widget( 'Magazine_Random_Posts' );
    register_widget( 'Magazine_Author_Me' );
}
add_action( 'widgets_init', 'register_mz_widgets' );

/*
* Magazine Recent Posts
*/
class Magazine_Recent_Posts extends WP_Widget 
{
	public function __construct() {
		$widget_ops = array(
			'classname' => 'mz_recent_posts',
			'description' => __( 'Your site&#8217;s most recent Posts.' ),
			'customize_selective_refresh' => true,
		);
		parent::__construct( 'mz-recent-posts', __( 'Magazine Recent Posts' ), $widget_ops );
		$this->alt_option_name = 'mz_recent_posts';
	}


	public function widget( $args, $instance ) {
		if ( ! isset( $args['widget_id'] ) ) {
			$args['widget_id'] = $this->id;
		}
		$title = ( ! empty( $instance['title'] ) ) ? $instance['title'] : __( 'Recent Posts' );
		$title = apply_filters( 'widget_title', $title, $instance, $this->id_base );
		$number = ( ! empty( $instance['number'] ) ) ? absint( $instance['number'] ) : 5;
		if ( ! $number )$number = 5;
		$show_thum = isset( $instance['show_thum'] ) ? $instance['show_thum'] : false;


		$r = new WP_Query( apply_filters( 'widget_posts_args', array(
			'posts_per_page'      => $number,
			'no_found_rows'       => true,
			'post_status'         => 'publish',
			'ignore_sticky_posts' => true
		)));

		if ($r->have_posts()) :
		?>
		<?php echo $args['before_widget']; ?>
		<?php if ( $title ) {
			echo $args['before_title'] . $title . $args['after_title'];
		} ?>
		<div class="mz_recent_posts">
		<?php while ( $r->have_posts() ) : $r->the_post(); ?>
				<div class="mz-post-iterm">
					<div class="mz_piterm_inner">
						<div class="mz_prc_left">
							<div class="mz_pthumb">
								<?php print  get_image_size(array(80,75),'',get_the_post_thumbnail_url(get_the_ID())); ?>
							</div>
						</div>
						<div class="mz_prc_right">
							<a href="<?php the_permalink(); ?>">
								<h3 class="mz_ptitle">
									<?php get_the_title() ? the_title() : the_ID(); ?>
								</h3>
							</a>
							<div class="mz_author">By: <span><?php the_author(); ?></span></div>
						</div>
					</div>
				</div>
		<?php endwhile; ?>
		</div>
		<?php echo $args['after_widget']; ?>
		<?php
		wp_reset_postdata();
		endif;
	}


	public function update( $new_instance, $old_instance ) {
		$instance = $old_instance;
		$instance['title'] = sanitize_text_field( $new_instance['title'] );
		$instance['number'] = (int) $new_instance['number'];
		$instance['show_thum'] = isset( $new_instance['show_thum'] ) ? (bool) $new_instance['show_thum'] : false;
		return $instance;
	}

	public function form( $instance ) {
		$title     = isset( $instance['title'] ) ? esc_attr( $instance['title'] ) : '';
		$number    = isset( $instance['number'] ) ? absint( $instance['number'] ) : 5;
		$show_thum = isset( $instance['show_thum'] ) ? (bool) $instance['show_thum'] : false;
		?>
			<p><label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title:' ); ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo $title; ?>" /></p>

			<p><label for="<?php echo $this->get_field_id( 'number' ); ?>"><?php _e( 'Number of posts to show:' ); ?></label>
			<input class="tiny-text" id="<?php echo $this->get_field_id( 'number' ); ?>" name="<?php echo $this->get_field_name( 'number' ); ?>" type="number" step="1" min="1" value="<?php echo $number; ?>" size="3" /></p>
			<p><input class="checkbox" type="checkbox"<?php checked( $show_thum ); ?> id="<?php echo $this->get_field_id( 'show_thum' ); ?>" name="<?php echo $this->get_field_name( 'show_thum' ); ?>" />
			<label for="<?php echo $this->get_field_id( 'show_thum' ); ?>"><?php _e( 'Display post thumbnail?' ); ?></label></p>
		<?php
	}
}

/*
* Magazine Random Posts
*/
class Magazine_Random_Posts extends WP_Widget 
{
	public function __construct() {
		$widget_ops = array(
			'classname' => 'mz_random_posts',
			'description' => __( 'Your site&#8217;s most random Posts.' ),
			'customize_selective_refresh' => true,
		);
		parent::__construct( 'mz-random-posts', __( 'Magazine Random Posts' ), $widget_ops );
		$this->alt_option_name = 'mz_random_posts';
	}


	public function widget( $args, $instance ) {
		if ( ! isset( $args['widget_id'] ) ) {
			$args['widget_id'] = $this->id;
		}
		$title = ( ! empty( $instance['title'] ) ) ? $instance['title'] : __( 'Random Posts' );
		$title = apply_filters( 'widget_title', $title, $instance, $this->id_base );
		$number = ( ! empty( $instance['number'] ) ) ? absint( $instance['number'] ) : 5;
		if ( ! $number )$number = 5;
		$show_thum = isset( $instance['show_thum'] ) ? $instance['show_thum'] : false;


		$r = new WP_Query( apply_filters( 'widget_posts_args', array(
			'posts_per_page'      => $number,
			'no_found_rows'       => true,
			'orderby'        => 'rand',
			'post_status'         => 'publish',
			'ignore_sticky_posts' => true
		)));

		if ($r->have_posts()) :
		?>
		<?php echo $args['before_widget']; ?>
		<?php if ( $title ) {
			echo $args['before_title'] . $title . $args['after_title'];
		} ?>
		<?php if ($show_thum): ?>
			<div class="mz_recent_posts">
			<?php while ( $r->have_posts() ) : $r->the_post(); ?>
					<div class="mz-post-iterm">
						<div class="mz_piterm_inner">
							<div class="mz_prc_left">
								<div class="mz_pthumb">
									<?php the_post_thumbnail(array(90,80)); ?>
								</div>
							</div>
							<div class="mz_prc_right">
								<a href="<?php the_permalink(); ?>">
									<h3 class="mz_ptitle">
										<?php get_the_title() ? the_title() : the_ID(); ?>
									</h3>
								</a>
								<div class="mz_author">By: <span><?php the_author(); ?></span></div>
							</div>
						</div>
					</div>
			<?php endwhile; ?>
			</div>
		<?php else: ?>
			<div class="mz-topic">
				<?php while ( $r->have_posts() ) : $r->the_post();
					$categories = get_the_category();
				 ?>
					<div class="mz-topic-iterm">
						<?php 
							if ( ! empty( $categories ) ) {
							    print '<div class="mz-topic-title">'.esc_html( $categories[0]->name ).'</div>' ;   
							}
						?>
						<a href="<?php the_permalink(); ?>">
							<div class="mz-topic-desc">
								<?php get_the_title() ? the_title() : the_ID(); ?>
							</div>
						</a>
						
						<div class="mz-topic-author"><?php the_author(); ?></div>
					</div>
				<?php endwhile; ?>
			</div>
		<?php endif; ?>
		<?php echo $args['after_widget']; ?>
		<?php
		wp_reset_postdata();
		endif;
	}


	public function update( $new_instance, $old_instance ) {
		$instance = $old_instance;
		$instance['title'] = sanitize_text_field( $new_instance['title'] );
		$instance['number'] = (int) $new_instance['number'];
		$instance['show_thum'] = isset( $new_instance['show_thum'] ) ? (bool) $new_instance['show_thum'] : false;
		return $instance;
	}

	public function form( $instance ) {
		$title     = isset( $instance['title'] ) ? esc_attr( $instance['title'] ) : '';
		$number    = isset( $instance['number'] ) ? absint( $instance['number'] ) : 5;
		$show_thum = isset( $instance['show_thum'] ) ? (bool) $instance['show_thum'] : false;
		?>
			<p><label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title:' ); ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo $title; ?>" /></p>

			<p><label for="<?php echo $this->get_field_id( 'number' ); ?>"><?php _e( 'Number of posts to show:' ); ?></label>
			<input class="tiny-text" id="<?php echo $this->get_field_id( 'number' ); ?>" name="<?php echo $this->get_field_name( 'number' ); ?>" type="number" step="1" min="1" value="<?php echo $number; ?>" size="3" /></p>
			<p><input class="checkbox" type="checkbox"<?php checked( $show_thum ); ?> id="<?php echo $this->get_field_id( 'show_thum' ); ?>" name="<?php echo $this->get_field_name( 'show_thum' ); ?>" />
			<label for="<?php echo $this->get_field_id( 'show_thum' ); ?>"><?php _e( 'Display post thumbnail?' ); ?></label></p>
		<?php
	}
}

/*
* Magazine Author Me
*/
class Magazine_Author_Me extends WP_Widget
{
	public function __construct() {
		$widget_ops = array(
			'classname' => 'mz_author_me',
			'description' => __( '' ),
			'customize_selective_refresh' => true,
		);
		parent::__construct( 'mz-author-me', __( 'Magazine Author' ), $widget_ops );
		$this->alt_option_name = 'mz_author_me';
	}


	public function widget( $args, $instance ) {
		if ( ! isset( $args['widget_id'] ) ) {
			$args['widget_id'] = $this->id;
		}
		$title = ( ! empty( $instance['title'] ) ) ? $instance['title'] : __( 'Author' );
		$title = apply_filters( 'widget_title', $title, $instance, $this->id_base );
		if (is_singular('post')):
			echo $args['before_widget']; 
			if ( $title ) {
				echo $args['before_title'] . $title . $args['after_title'];
			} 
			print sprintf('<div class="mz-author_box">
					<div class="mz-author_inner text-center">
						<div class="mz-authorimg">
							<img src="'.get_author_image().'">
						</div>
						<div class="mz-description">
							<div class="mz-atname">
								'.get_the_author().'
							</div>
							<div class="mz-author_info">
								'.get_the_author_meta('user_description').'
							</div>
							<div class="mz-author_more">
								<a href="'.get_the_author_meta('user_url').'">Read More</a>
							</div>
						</div>
					</div>
				</div>');
			
			echo $args['after_widget']; 
		endif;
	}


	public function update( $new_instance, $old_instance ) {
		$instance = $old_instance;
		$instance['title'] = sanitize_text_field( $new_instance['title'] );
		return $instance;
	}

	public function form( $instance ) {
		$title     = isset( $instance['title'] ) ? esc_attr( $instance['title'] ) : '';
		?>
			<p><label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title:' ); ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo $title; ?>" /></p>
		<?php
	}
}
