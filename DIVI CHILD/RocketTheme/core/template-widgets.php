<?php
/*
* All Rocket theme widgets
*/


/*
* Rocket Recent Posts
*/
function register_rocket_recent_widget() {
    register_widget( 'Rocket_Recent_Posts' );
}
add_action( 'widgets_init', 'register_rocket_recent_widget' );
class Rocket_Recent_Posts extends WP_Widget {


	public function __construct() {
		$widget_ops = array(
			'classname' => 'rocket_recent_posts',
			'description' => __( 'Your site&#8217;s most recent Posts.' ),
			'customize_selective_refresh' => true,
		);
		parent::__construct( 'rocket-recent-posts', __( 'Rocket Recent Posts' ), $widget_ops );
		$this->alt_option_name = 'rocket_recent_posts';
	}


	public function widget( $args, $instance ) {
		if ( ! isset( $args['widget_id'] ) ) {
			$args['widget_id'] = $this->id;
		}

		$title = ( ! empty( $instance['title'] ) ) ? $instance['title'] : __( 'Recent Posts' );
		$title = apply_filters( 'widget_title', $title, $instance, $this->id_base );
		$number = ( ! empty( $instance['number'] ) ) ? absint( $instance['number'] ) : 5;
		if ( ! $number )$number = 5;
		$show_date = isset( $instance['show_date'] ) ? $instance['show_date'] : false;
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
		<div class="rkt_recent_post">
		<?php while ( $r->have_posts() ) : $r->the_post(); ?>
			<?php 
				if ($show_thum == true && has_post_thumbnail(get_the_ID())):
			?>
				<div class="rkt_piterm has_thumb">
					<div class="rkt_piterm_inner">
						<div class="rkt_prc_left">
							<div class="rkt_pthumb">
								<?php the_post_thumbnail(array(150,150)); ?>
							</div>
						</div>
						<div class="rkt_prc_right">
							<?php if ( $show_date ) : ?>
								<div class="rkt_pmeta">
									<span>on <?php echo get_the_date(); ?></span>
								</div>
							<?php endif; ?>
							<h3 class="rkt_ptitle">
								<a href="<?php the_permalink(); ?>"><?php get_the_title() ? the_title() : the_ID(); ?></a>
							</h3>
							<div class="rkt_pcontent">
								<?php 
									print wp_trim_words( get_the_content(), 8, '.' );
								?>
							</div>
							<div class="rkt_btn_more">
								<a class="rkt-btn btn-color" href="<?php the_permalink(); ?>">Read more</a>
							</div>
						</div>
					</div>
				</div>
			<?php else: ?>
				<div class="rkt_piterm rkt_iterm_rclist">
					<div class="rkt_piterm_inner">
						<?php if ( $show_date ) : ?>
							<div class="rkt_pmeta">
								<span>on <?php echo get_the_date(); ?></span>
								<span class="rkt_pauthor">By <?php the_author(); ?></span>
							</div>
						<?php endif; ?>
						<h3 class="rkt_ptitle">
							<a href="<?php the_permalink(); ?>"><?php get_the_title() ? the_title() : the_ID(); ?></a>
						</h3>
						<div class="rkt_pcontent">
							<?php 
								print wp_trim_words( get_the_content(), 15, '.' );
							?>
						</div>
					</div>
					<?php 
						if (has_post_thumbnail(get_the_ID())):
							$bg_url = get_the_post_thumbnail_url( get_the_ID(), 'full' );
					?>
						<div class="rkt_piterm_overlay" style="background-image: url('<?php print $bg_url; ?>');">
							<div class="rkt_piterm_overlay-inner">
								<?php if ( $show_date ) : ?>
									<div class="rkt_pmeta">
										<span>on <?php echo get_the_date(); ?></span>
									</div>
								<?php endif; ?>
								<h3 class="rkt_ptitle">
									<a href="<?php the_permalink(); ?>"><?php get_the_title() ? the_title() : the_ID(); ?></a>
								</h3>
								<?php if ( $show_date ) : ?>
									<div class="rkt_pmeta">
										<span class="rkt_pauthor">By <?php the_author(); ?></span>
									</div>
								<?php endif; ?>
							</div>
						</div>
					<?php endif; ?>
				</div>
			<?php endif; ?>
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
		$instance['show_date'] = isset( $new_instance['show_date'] ) ? (bool) $new_instance['show_date'] : false;
		$instance['show_thum'] = isset( $new_instance['show_thum'] ) ? (bool) $new_instance['show_thum'] : false;
		return $instance;
	}

	public function form( $instance ) {
		$title     = isset( $instance['title'] ) ? esc_attr( $instance['title'] ) : '';
		$number    = isset( $instance['number'] ) ? absint( $instance['number'] ) : 5;
		$show_date = isset( $instance['show_date'] ) ? (bool) $instance['show_date'] : false;
		$show_thum = isset( $instance['show_thum'] ) ? (bool) $instance['show_thum'] : false;
?>
		<p><label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title:' ); ?></label>
		<input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo $title; ?>" /></p>

		<p><label for="<?php echo $this->get_field_id( 'number' ); ?>"><?php _e( 'Number of posts to show:' ); ?></label>
		<input class="tiny-text" id="<?php echo $this->get_field_id( 'number' ); ?>" name="<?php echo $this->get_field_name( 'number' ); ?>" type="number" step="1" min="1" value="<?php echo $number; ?>" size="3" /></p>

		<p><input class="checkbox" type="checkbox"<?php checked( $show_date ); ?> id="<?php echo $this->get_field_id( 'show_date' ); ?>" name="<?php echo $this->get_field_name( 'show_date' ); ?>" />
		<label for="<?php echo $this->get_field_id( 'show_date' ); ?>"><?php _e( 'Display post date?' ); ?></label></p>

		<p><input class="checkbox" type="checkbox"<?php checked( $show_thum ); ?> id="<?php echo $this->get_field_id( 'show_thum' ); ?>" name="<?php echo $this->get_field_name( 'show_thum' ); ?>" />
		<label for="<?php echo $this->get_field_id( 'show_thum' ); ?>"><?php _e( 'Display post thumbnail?' ); ?></label></p>
<?php
	}
}
