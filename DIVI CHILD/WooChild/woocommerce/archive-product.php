<?php
	if ( ! defined( 'ABSPATH' ) ) {
		exit; // Exit if accessed directly
	}
	get_header('shop'); 
?>

<?php
	do_action( 'sa_header_shop' );
	
?> 


	<?php
		do_action( 'woocommerce_before_main_content' );
	?>
	
	<?php if (is_active_sidebar('sa-prolist')): ?>
		<div class="prolist-top">
			<?php dynamic_sidebar('sa-prolist'); ?> 
		</div>	
	<?php endif; ?>

		
		<?php 
			// SA Filter product
			wc_get_template_part( 'loop/filter', '' ); 
		?>

		<div class="sa_products">
			<?php if ( have_posts() ) : ?>

					<?php
						/**
						 * woocommerce_before_shop_loop hook.
						 *
						 * @hooked wc_print_notices - 10
						 * @hooked woocommerce_result_count - 20
						 * @hooked woocommerce_catalog_ordering - 30
						 */
						do_action( 'woocommerce_before_shop_loop' );
					?>
					
					<?php woocommerce_product_loop_start(); ?>
						<?php woocommerce_product_subcategories(); ?>
						<?php while ( have_posts() ) : the_post(); ?>

							<?php
								/**
								 * woocommerce_shop_loop hook.
								 *
								 * @hooked WC_Structured_Data::generate_product_data() - 10
								 */
								do_action( 'woocommerce_shop_loop' );
							?>

							<?php wc_get_template_part( 'content', 'product' ); ?>

						<?php endwhile; // end of the loop. ?>

					<?php woocommerce_product_loop_end(); ?>

					<?php
						/**
						 * woocommerce_after_shop_loop hook.
						 *
						 * @hooked woocommerce_pagination - 10
						 */
						do_action( 'woocommerce_after_shop_loop' );
					?>

				<?php elseif ( ! woocommerce_product_subcategories( array( 'before' => woocommerce_product_loop_start( false ), 'after' => woocommerce_product_loop_end( false ) ) ) ) : ?>
					<?php
						/**
						 * woocommerce_no_products_found hook.
						 *
						 * @hooked wc_no_products_found - 10
						 */
						do_action( 'woocommerce_no_products_found' );
					?>
				<?php endif; ?>
		</div>


	<?php
		/**
		 * woocommerce_after_main_content hook.
		 *
		 * @hooked woocommerce_output_content_wrapper_end - 10 (outputs closing divs for the content)
		 */
		do_action( 'woocommerce_after_main_content' );
	?>

<?php get_footer( 'shop' ); ?>
