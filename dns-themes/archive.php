<?php
/**
 * The main template file
 * 
 * @package flex-theme
 */
	get_header();
?>

<section id="main-content" class="archive-content" role="main">
	<div class="container">
		<div class="row">
			<?php get_sidebar('left'); ?> 
				<div id="main-column" class="<?php flex_col(); ?>" >
					<header class="archive-header">
						<h1 class="page-title"><?php print get_the_archive_title() ?></h1>
						<?php if(category_description( get_category_by_slug('category-slug')->term_id ) != ''): ?>
							<div class="category_description">
								 <?php echo category_description( get_category_by_slug('category-slug')->term_id ); ?> 
							</div>
						<?php endif; ?>
					</header>
					<div>
						<?=do_shortcode('[lienhe_tuvan]' ); ?>
					</div>
					<?php 
						if (have_posts()) {
					?>
						<div class="archive_list row">
							<?php 
								while (have_posts()) {
									the_post();
									get_template_part('template_part/content', get_post_format());
								}
							?>
						</div>
					<?php 
						}else { 
							get_template_part('template_part/content', 'none');
						}  
					?> 
					<?php fx_nav_pager(); ?>

				</div>
			<?php get_sidebar('right'); ?>
		</div>
	</div>
</section>

<div class="frm_tv_contact">
	<div class="container">
		<?=do_shortcode('[lienhe_tuvan]' ); ?>
		<?=do_shortcode(get_toption('after_ncat')); ?>
	</div>
</div>

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
<?php get_footer(); ?> 