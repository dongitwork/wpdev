<?php
/**
 * Description tab
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/single-product/tabs/description.php.
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
 * @version     2.0.0
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit; 
}
global $post;
global $product;
?>
<div id="tab-desc_inner" class="scrollbar-outer">
	<?php the_content(); ?>
</div>
<div class="hide desc_btn-expand" >
	<button class=" desc_btn-more" >XEM THÊM</button>
</div>
<?php 
	if (get_toption('frm_dathang') != '') {
		echo do_shortcode(get_toption('frm_dathang')); 
	}
?>

<?=do_shortcode('[box_contact]'); ?>
<div id="product_meta" class="product_meta">
	<?php do_action( 'woocommerce_product_meta_start' ); ?>
	<?php 
		echo wc_get_product_category_list( $product->get_id(), ', ', '<div class="posted_in">' . _n( '<i class="fa fa-folder-open"></i>', '<i class="fa fa-folder-open"></i>', count( $product->get_category_ids() ), 'woocommerce' ) . ' ', '</div>' ); 
	?>
	<?php echo wc_get_product_tag_list( $product->get_id(), ', ', '<span class="tagged_as">' . _n( '<i class="fa fa-tag"></i>', '<i class="fa fa-tags"></i>', count( $product->get_tag_ids() ), 'woocommerce' ) . ' ', '</span>' ); ?>

	<?php do_action( 'woocommerce_product_meta_end' ); ?>
</div>