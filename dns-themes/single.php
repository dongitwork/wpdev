<?php
/**
 * Template for displaying single post.
 * 
 * @package flex-theme
 */

get_header();

?> 

<section id="main-content" class="main-content" role="main">
	<div class="container">
		<div class="row">
			<?php get_sidebar('left'); ?>
			<div id="main-column" class="<?php flex_col(); ?>" >
				<?php 
					if (have_posts()) {
						while (have_posts()) {
							the_post();
							get_template_part('template_part/content', 'single');
						}
					}else { 
						get_template_part('template_part/content', 'none');
					}  
				?> 
				<?php edit_post_link('edit', '<p>', '</p>'); ?>
			</div>
			<?php get_sidebar('right'); ?>
		</div>
	</div>
</section>


<div id="procat_byid">
		<?php 
			$terms = get_terms( array(
			    'taxonomy' => 'product_cat',
			    'hide_empty' => true,
			) );
			if (isset($terms[0]->term_id)) {
				foreach ($terms as $key => $term) {
					$title = get_field('title_display',$term);
					$subtitle = get_field('subtitle_display',$term);
					if (!empty($term)) {
						$args = array('post_type' => 'product',
					          'post_status' => 'publish',
					          'tax_query' => array(
									'relation' => 'AND',
									array(
										'taxonomy' => 'product_cat',
										'field'    => 'term_id',
										'terms'    => $term->term_id,
									),
								),
					          'posts_per_page'=>15);
					  	$pl_query = new WP_Query( $args );
					  	if ( $pl_query->have_posts() ) {
							?>
							<div id="dns-list_product-<?=rand();?>"  class="dns-list_product dns-owl_list ">
								<div class="container">
			                        <div class="group-title text-left">
			                            <h3 class="block-title "><?=$title; ?></h3>
			                            <?php if($subtitle != ''): ?>
			                            	<div class="desc">
			                            		<?=$subtitle;?>
			                            	</div>
			                            <?php endif; ?>
			                        </div>
			                            
									<div class="dns-crpost_wp">
										<div class="dns-cr_product row">
											<?php 
												while ( $pl_query->have_posts() ) :
													$pl_query->the_post();
											?>
												<div class="crproduct-iterm col-xxs-6 col-xs-4 col-sm-3 col-md-3 col-lg-5">
												 	<?php 
				                                        get_template_part('template_part/product', 'loop');
												 	?>
					                            </div>
									        <?php 
									        	endwhile;
									        	wp_reset_postdata();
									        ?>
										</div>
									</div>
								</div>
							</div>
							<?php
						}
					}
				}
			}
		?>
</div>
<?php 
	$cats = wp_get_post_categories(get_the_ID());
	$args = array('post_type' => 'post',
          'post_status' => 'publish',
          'category__in' => $cats ,
          'posts_per_page'=>5);
  	$pl_query = new WP_Query( $args );
  	the_post_by($pl_query, 'Tin cùng chuyên mục','slider_image',1,0);
?>
<div id="news_byid">
	<div class="container">
		<?php 
			$allshows = array(
				'by_tags' 		=> __( 'Bài viết cùng Tags', '' ),
				'by_newid'   	=> __( 'Bài Viết Mới Hơn', '' ),
				'by_oldid'   	=> __( 'Bài Viết Cũ Hơn', '' ),
				'views_more'   	=> __( 'Xem Nhiều Nhất', '' ),
				'views_recent'	=> __( 'Bài Viết mới nhất', '' ),
				'views_old'   	=> __( 'Bài Viết Cũ nhất', '' ),
			);
			foreach ($allshows as $type => $title) {
				$news_html =  do_shortcode('[news_by_id title="'.$title.'" type="'.$type.'" layout="list_style" has_container=0 ]');
				if (strip_tags($news_html) != '') {
					print '<div class="news_byid-iterm col-xs-12 col-sm-6 col-md-4">'.$news_html.'</div>';
				}
			}
		?>
	</div>
</div>
<?php get_footer(); ?> 



