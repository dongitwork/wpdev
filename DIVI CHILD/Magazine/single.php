<?php

get_header();

$show_default_title = get_post_meta( get_the_ID(), '_et_pb_show_title', true );

$is_page_builder_used = et_pb_is_pagebuilder_used( get_the_ID() );

?>

<?php if (has_post_thumbnail()): ?>
	<div class="hero-image">
		<?php the_post_thumbnail('full');?>
	</div>
<?php endif; ?>

<div id="main-content">
	<div class="container">
		<div id="content-area" class="clearfix">
			<div id="left-area">
				<?php while ( have_posts() ) : the_post(); ?>
				<div class="mz_post_info">
					<div class="row_fl">
						<div class="col-xs-12 col-sm-7 col-md-8">
							<div class="post_title_wp">
								<div class="title_group">
									<h1 class="mz-ptitle"><?php the_title(); ?></h1>
									<div class="mz-sub_title">
										Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eius mod tempor incididunt ut labore.
									</div>
								</div>
								<div class="mz-post_date">
									<i class="fa fa-calendar"></i> <?php  the_date('d.m.Y'); ?>
								</div>
							</div>
						</div>
						<div class="col-xs-12 col-sm-5 col-md-4">
							<div class="mz_social_media text-right">
								<?php print get_share(get_the_ID()); ?>
							</div>
							<div class="mz-post_author">
								<div class="post_author_inner">
									<div class="ath_image">
										<img src="<?php print get_author_image(); ?>" width="45" height="45">
									</div>  - By <span>Peulic Milan</span>
								</div>
							</div>
						</div>
					</div>
				</div>
			
				<?php if (et_get_option('divi_integration_single_top') <> '' && et_get_option('divi_integrate_singletop_enable') == 'on') echo(et_get_option('divi_integration_single_top')); ?>
				<article id="post-<?php the_ID(); ?>" <?php post_class( 'et_pb_post' ); ?>>
					<?php the_content(); ?>
				</article> <!-- .et_pb_post -->

			<?php endwhile; ?>

			<!-- Comment Post -->
			<div class="mz-comment">
				<h4 class="mz-title"><span>Comments</span></h4>
					<?php
						if ( ( comments_open() || get_comments_number() ) && 'on' == et_get_option( 'divi_show_postcomments', 'on' ) ) {
							comments_template( '', true );
						}
					?>
			</div>
		

			<!-- END Comment Post -->

				<!-- You Might Also Like -->
				<?php 
					$all_cat = get_the_category( get_the_ID() );
					$cats = array();
					if (isset($all_cat[0])) {
						foreach ($all_cat as $val) {
							$cats[] = $val->term_id;
						}
					}
					$args = array('post_type' => 'post',
						'posts_per_page' => 3,
						'post_status' => 'publish',
					);
					if ( !empty($cats) ){
						$args['cat'] = implode(',', $cats);
					}
					$blog_ymal = new WP_Query( $args );
					if ($blog_ymal->have_posts()):
				?>
					<div class="mz-ymal">
						<h2 class="mz-ymal-title text-center">You Might Also Like</h2>
						<div class="mz-ymal-posts">
							<div class="mz-ymal-posts_list">
								<div class="row_fl">
									<?php 
										while ($blog_ymal->have_posts()):
										$blog_ymal->the_post();	
									?>
										<div class="col-xs-12 col-sm-4 col-md-4">
											<div class="mz-ymal-piterm">
												<div class="mz-ymal-pimages">
													<?php 
														print get_blog_image('imgblog_3','center-block');
													?>
												</div>
												<a href="<?php the_permalink(); ?>">
													<h3 class="mz-ymal-ptitle">
														<?php the_title(); ?>
													</h3>
												</a>
												<div class="mz-ymal-pcontent">
													<?php 
														print wp_trim_words( get_the_excerpt(), 20, '.' );
													 ?>
												</div>
												<div class="mz-ymal-pmore text-right">
													<a href="<?php the_permalink(); ?>">Read Article <i class="fa fa-long-arrow-right"></i></a>
												</div>
											</div>
										</div>
									<?php endwhile; ?>
								</div>
							</div>
						</div>
					</div>
				<?php endif; ?>
				<!-- END You Might Also Like -->

			</div> <!-- #left-area -->

			<?php get_sidebar(); ?>
		</div> <!-- #content-area -->
	</div> <!-- .container -->
</div> <!-- #main-content -->

<?php get_footer(); ?>
