<?php
/**
 * Cart Page
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}



do_action( 'woocommerce_before_cart' ); ?>
<div class="sa-cart_page">
	<div class="container">
			<?php wc_print_notices(); ?>
		<div class="sa-pcart_top">
			<div class="sa-pcartt_content text-center">
				Review <span>of <?php print count(WC()->cart->get_cart()); ?></span> items <span><?php print WC()->cart->get_cart_total(); ?></span>
			</div>
		</div>

		<form class="woocommerce-cart-form" action="<?php echo esc_url( wc_get_cart_url() ); ?>" method="post">
			<?php do_action( 'woocommerce_before_cart_table' ); ?>

			<div class="shop_table shop_table_responsive cart woocommerce-cart-form__contents" cellspacing="0">
					<?php do_action( 'woocommerce_before_cart_contents' ); ?>

					<?php
					foreach ( WC()->cart->get_cart() as $cart_item_key => $cart_item ) {
						$_product   = apply_filters( 'woocommerce_cart_item_product', $cart_item['data'], $cart_item, $cart_item_key );
						$product_id = apply_filters( 'woocommerce_cart_item_product_id', $cart_item['product_id'], $cart_item, $cart_item_key );

						if ( $_product && $_product->exists() && $cart_item['quantity'] > 0 && apply_filters( 'woocommerce_cart_item_visible', true, $cart_item, $cart_item_key ) ) {
							$product_permalink = apply_filters( 'woocommerce_cart_item_permalink', $_product->is_visible() ? $_product->get_permalink( $cart_item ) : '', $cart_item, $cart_item_key );
							?>
							
				<div class="sa-cart_item">
					<div class="row_fl">
						<div class="col-xs-12 col-sm-3">
							<div class="sa-cart_thumn">
								<?php
									$thumbnail = get_the_post_thumbnail( $cart_item['product_id'], 'full', '' );
									if ( ! $product_permalink ) {
										echo $thumbnail;
									} else {
										printf( '<a href="%s">%s</a>', esc_url( $product_permalink ), $thumbnail );
									}
								?>
							</div>
						</div>
						<div class="col-xs-12 col-sm-7">
							<div class="sa-cart_gtitle">
								<h2 class="sa-cart_title">
									<?php
										echo $_product->get_name();
									?>
								</h2>
								<div class="sa-cart_sku">
									<?php echo ( $sku = $_product->get_sku() ) ? $sku : esc_html__( 'N/A', 'woocommerce' ); ?>
								</div>
							</div>
							
							<div class="sa-cart_atb">
								<div class="row_fl">
									<?php 
										if (isset($cart_item['variation'])):
										$atb = 	$cart_item['variation'];
									?>
									<?php if (isset($atb['attribute_pa_color'])): ?>
										<div class="col-xs-4">
											<span><i class="fa fa-tint"></i> 
												<?php 
													$color = get_term_by('slug',$atb['attribute_pa_color'], 'pa_color');
													echo $color->name;
												?>
											</span>
										</div>
									<?php endif; ?>

									<?php if (isset($atb['attribute_pa_size'])): ?>
										<div class="col-xs-4">
											<span><i class="fa fa-arrows-h"></i> 
												<?php 
													$pa_size = get_term_by('slug',$atb['attribute_pa_size'], 'pa_size');

													echo ($pa_size->description)?$pa_size->description:$pa_size->name;
												?>
											</span>
										</div>
									<?php endif; ?>

									<?php endif; ?>
									<div class="col-xs-4">
										<span><i class="fa fa-shopping-bag"></i> <?php print $cart_item['quantity']; ?>Item(s)</span>
									</div>
								</div>
							</div>
							
						</div>
						<div class="col-xs-12 col-sm-2">
							<div class="sa-cart_price">
								<?php
									echo apply_filters( 'woocommerce_cart_item_price', WC()->cart->get_product_price( $_product ), $cart_item, $cart_item_key );
								?>
							</div>
							<div class="sa-cart_remove">
								<?php
									echo apply_filters( 'woocommerce_cart_item_remove_link', sprintf(
										'<a href="%s" class="remove" aria-label="%s" data-product_id="%s" data-product_sku="%s">&times;</a>',
										esc_url( WC()->cart->get_remove_url( $cart_item_key ) ),
										__( 'Remove this item', 'woocommerce' ),
										esc_attr( $product_id ),
										esc_attr( $_product->get_sku() )
									), $cart_item_key );
								?>
							</div>
						</div>
					</div>
				</div>

							<?php
						}// Endif
					}// End foreach
					?>

					<?php do_action( 'woocommerce_cart_contents' ); ?>
					<?php if ( wc_coupons_enabled() ): ?>
						<div class="sa-cart_coupons">
							<div class="row_fl">
								<div class="col-xs-12 col-sm-6">
									<div class="sa-cart_cpgroup">
										<h3 class="sa-cart_dctitle">Discount Promo Code</h3>
										<div class="sa-cart_cpdesc">
											Dont have it yet? <a href="#">Check our discount programs</a> and get it now!
										</div>
									</div>
								</div>
								<div class="col-xs-12 col-sm-6">
									<div class="sa-ip_coupon"> <input type="text" name="coupon_code" class="input-text" id="coupon_code" value="" placeholder="<?php esc_attr_e( 'xxx-xxx-xxxx-xx', 'woocommerce' ); ?>" /> <input type="submit" class="sa-btn_cart" name="apply_coupon" value="<?php esc_attr_e( 'Enter', 'woocommerce' ); ?>" />
									<?php do_action( 'woocommerce_cart_coupon' ); ?>
								</div>
								</div>
							</div>
						</div>
					<?php endif; ?>
					<?php do_action( 'woocommerce_after_cart_contents' ); ?>

			</div>

			<?php do_action( 'woocommerce_after_cart_table' ); ?>
		</form>
	</div>
	<div class="sa-cart_totals">
		<div class="container">
			<?php
				/**
				 * woocommerce_cart_collaterals hook.
				 *
				 * @hooked woocommerce_cross_sell_display
				 * @hooked woocommerce_cart_totals - 10
				 */
			 	do_action( 'woocommerce_cart_collaterals' );
			?>
		</div>
	</div>
</div>
<?php do_action( 'woocommerce_after_cart' ); ?>
