<?php
	if ( ! defined( 'ABSPATH' ) ) {
		exit; // Exit if accessed directly
	}
	$shop_page_url = get_permalink( woocommerce_get_page_id( 'shop' ) );
	if ($_SERVER['QUERY_STRING'] !='') {
		$shop_page_url = $shop_page_url.'?'.$_SERVER['QUERY_STRING'];
	}
?>
<div class="sa_shop_url" style="display: none;" surl="<?php print $shop_page_url; ?>"></div>
<div class="sa-filters" >
	<div class="sa-filters_inner">
		<div class="row_fl">
			<div class="col-xs-12 col-sm-7  col-lg-4">
				<?php 
					$product_cat = get_terms('product_cat', array(
									    'hide_empty' => false,
									));
					if (isset($product_cat[0])):
				?>
					<div class="sa-procat">
						 <select name="procat" class="procat" >
						 	<option value="">More Subcategories</option>
					        <?php
					        $page_count = ($_GET['procat'])?$_GET['procat']:'';
					         foreach ( $product_cat as $cat ) : ?>
					            <option value="<?php echo esc_attr( $cat->term_id ); ?>" <?php selected( $page_count, $cat->term_id ); ?>><?php echo esc_html( $cat->name ); ?></option>
					        <?php endforeach; ?>
					    </select>
					</div>
				<?php endif; ?>

				<div class="woocommerce-viewing" method="get">
				    <label><?php echo __('View:', '') ?> </label>
				    <select name="count" class="count">
				        <?php
				        $page_count = ($_GET['count'])?$_GET['count']:4;
				        $per_page = explode(',', '8,12,24,36');
				         foreach ( $per_page as $count ) : ?>
				            <option value="<?php echo esc_attr( $count ); ?>" <?php selected( $page_count, $count ); ?>><?php echo esc_html( $count ); ?></option>
				        <?php endforeach; ?>
				    </select>
				</div>
			</div>

			<div class="col-xs-12 col-sm-5 col-lg-4">
				<div class="sa_price">
					<?php $price_all = sa_get_filtered_price(); ?>
					<div class="price_slider_amount">
						<span class="sa_price_min">$0</span>
						<div id="sa-range" data-max_price="<?php print $price_all->max_price; ?>"></div>
						<span class="sa_price_max">$<?php print $price_all->max_price; ?></span>

						<input type="hidden" value="<?php print ($_GET['min_price'])?$_GET['min_price']:0; ?>" id="sa_min_price">
						<input type="hidden" value="<?php print ($_GET['max_price'])?$_GET['max_price']:$price_all->max_price; ?>"  id="sa_max_price">
					</div>
				</div>
			</div>

			<div class="col-xs-12 col-lg-4 col-sm-12">
				<div class="sa-color">
					<label>Color:</label>
					<div class="sa-color_option">
						<?php 
							$terms = get_terms('pa_color', array(
									    'hide_empty' => false,
									 ));
							$swatches ='';
							foreach ( $terms as $term ) {
								$selected = ($_GET['filter_color'] && $_GET['filter_color'] == $term->slug) ? 'selected' : '';
								$name     = esc_html( apply_filters( 'woocommerce_variation_option_name', $term->name ) );
								$color = get_term_meta( $term->term_id, 'color', true );

								list($r,$g,$b) = sscanf( $color, "#%02x%02x%02x" );

								$swatches .= sprintf(
									'<span class="sa-swatch-color swatch-%s %s" style="background-color:%s;color:%s;" title="%s" data-value="%s">%s</span>',
									esc_attr( $term->slug ),
									$selected,
									esc_attr( $color ),
									"rgba($r,$g,$b,0.5)",
									esc_attr( $name ),
									esc_attr( $term->slug ),
									$name
								);
							}
							print $swatches;
						?>
					</div>
				</div>
				<?php wc_get_template_part( 'loop/orderby', '' ); ?>	
			</div>
			
		</div>
	</div>
</div>
