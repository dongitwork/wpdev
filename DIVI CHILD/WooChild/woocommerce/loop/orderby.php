<?php
/**
 * Show options for ordering
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/loop/orderby.php.
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
 * @version     2.2.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}
	$catalog_orderby_options = apply_filters( 'woocommerce_catalog_orderby', array(
	    'menu_order' => __( 'Default sorting', '' ),
	    'popularity' => __( 'Popularity', '' ),
	    'rating'     => __( 'Average rating', '' ),
	    'date'       => __( 'Newness', '' ),
	    'price'      => __( 'Price', '' ),
	));
?>
<div class="sa-ordering" >
	<label for="orderby">Sort By:</label>
	<select id="orderby" name="orderby" class="sa-orderby">
		<?php foreach ( $catalog_orderby_options as $id => $name ) : ?>
			<option value="<?php echo esc_attr( $id ); ?>" <?php selected( $orderby, $id ); ?>><?php echo esc_html($name); ?></option>
		<?php endforeach; ?>
	</select>
</div>
