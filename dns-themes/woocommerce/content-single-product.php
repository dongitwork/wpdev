<?php
/**
 * The template for displaying product content in the single-product.php template
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/content-single-product.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see 	    https://docs.woocommerce.com/document/template-structure/
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     3.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Hook Woocommerce_before_single_product.
 *
 * @hooked wc_print_notices - 10
 */
do_action( 'woocommerce_before_single_product' );

if ( post_password_required() ) {
	echo get_the_password_form(); // WPCS: XSS ok.
	return;
}
global $product;
?>
<div id="product-<?php the_ID(); ?>" <?php post_class(); ?>>

	<div id="product_info">
		<div class="row">
			<div class="col-xs-12 col-sm-6 col-md-5 col-lg-4">
				<?php
					/**
					 * Hook: woocommerce_before_single_product_summary.
					 *
					 * @hooked woocommerce_show_product_sale_flash - 10
					 * @hooked woocommerce_show_product_images - 20
					 */
					do_action( 'woocommerce_before_single_product_summary' );
				?>
			</div>
			<div class="col-xs-12 col-sm-6 col-md-7 col-lg-8">
				<div class="summary entry-summary">
					<div>
						<?php
							
							the_title( '<h1 class="product_title entry-title">', '</h1>' );
						?>
					</div>
					<div class="row">
						<div class="col-xs-12 col-sm-12 col-md-6">
							<span class="btn-hotline" > HotLine : <a href="tel:<?=get_toption('site_phone');?>" ><?=get_toption('site_phone');?></a></span>

							<?php if ( wc_product_sku_enabled() && ( $product->get_sku() || $product->is_type( 'variable' ) ) ) : ?>
								<div class="sku_wrapper">
									<span ><?php esc_html_e( 'Mã sản phẩm:', 'woocommerce' ); ?> <strong class="sku"><?php echo ( $sku = $product->get_sku() ) ? $sku : esc_html__( 'N/A', 'woocommerce' ); ?></strong></span>
								</div>
							<?php endif; ?>

							<p class="price"><?php echo $product->get_price_html(); ?></p>

							
							<?php 
								if (get_toption('frm_dathang') != ''):
							?>
								<div class="data_quick_buy">
									<div class="group_quick_buy">
										<div class="quick_buy_form" >
											<?=do_shortcode(get_toption('frm_dathang')); ?>
										</div>
									</div>
								</div>
							<?php endif; ?>

						</div>
						<div class="col-xs-12 col-sm-12 col-md-6">
							<div class="group_right_info">
								<div class="product_addinfo">
									<?php do_action( 'woocommerce_product_additional_information', $product ); ?>
								</div>

								<?php
									/**
									 * Hook: Woocommerce_single_product_summary.
									 *
									 * @hooked woocommerce_template_single_title - 5
									 * @hooked woocommerce_template_single_rating - 10
									 * @hooked woocommerce_template_single_price - 10
									 * @hooked woocommerce_template_single_excerpt - 20
									 * @hooked woocommerce_template_single_meta - 40
									 * @hooked woocommerce_template_single_add_to_cart - 30
									 * @hooked woocommerce_template_single_sharing - 50
									 * @hooked WC_Structured_Data::generate_product_data() - 60
									 remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_price', 10 );

									add_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_price', 20 );
									 */
									do_action( 'woocommerce_single_product_summary' );
								?>
								
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>

	<div class="row">
		<?php get_sidebar('left'); ?> 
		<div  class="<?php flex_col(); ?>" >
			<?php
				/**
				 * Hook: woocommerce_after_single_product_summary.
				 *
				 * @hooked woocommerce_output_product_data_tabs - 10
				 * @hooked woocommerce_upsell_display - 15
				 * @hooked woocommerce_output_related_products - 20
				 */
				do_action( 'woocommerce_after_single_product_summary' );
			?>
			
		</div>
		<?php get_sidebar('right'); ?>
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
<div id="procat_byid">
	<?php 
		// $args = array(
	 //      'posts_per_page' => 5,
	 //      'orderby'        => 'DESC', 
	 //    );
	 //    woocommerce_related_products( apply_filters( 'woocommerce_output_related_products_args', $args ) );
	print do_shortcode( '[product_by_id number="12" title="Sản phẩm cùng tags"]');
	?>
</div>

<div id="news_byid">
	<div class="container">
		<?php 
			$allshows = array(
				'views_more'   	=> __( 'Xem Nhiều Nhất', '' ),
				'views_recent'	=> __( 'Có thể bạn sẽ thích', '' ),
				'views_old'   	=> __( 'Thời trang dành cho bạn', '' ),
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

<?php do_action( 'woocommerce_after_single_product' ); ?>
