<?php
/**
 * The Template for displaying all single products
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/single-product.php.
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
 * @version     1.6.4
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

get_header(); ?>

<div id="main-content" class="sa-pro_detaill">
	<?php while ( have_posts() ) : the_post(); ?>
		<?php wc_get_template_part( 'content', 'single-product' ); ?>
	<?php endwhile; // end of the loop. ?>
</div>

<div class="sa-product_similar">
	<div class="container">
		<?php 
			$args = array(
				'post_type' => 'product',
				'orderby' => 'rand',
				'posts_per_page' =>4,
				'post__not_in' => array(get_the_ID())
			);
			$products = new WP_Query( $args );
			if ( $products->have_posts() ) :
		?>
			<div class="sa-ps_header">
				<h2 class="sa-ps_title">Take A Look At Some Similar Products</h2>
				<div class="sa-ps_desc">Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation.
				</div>
			</div>

			<div class="sa-pro_list">
				<div class="row_fl">
					<?php 
						while ( $products->have_posts() ) : $products->the_post();
							wc_get_template_part( 'content', 'product' ); 
						endwhile;
					?>
				</div>
			</div>
		<?php 
			wp_reset_postdata();
			endif;
		?>
	</div>
</div>

<?php get_footer( 'shop' );

/* Omit closing PHP tag at the end of PHP files to avoid "headers already sent" issues. */
