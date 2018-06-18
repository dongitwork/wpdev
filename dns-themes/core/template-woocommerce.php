<?php

remove_action( 'woocommerce_after_single_product_summary', 'woocommerce_output_related_products',20);
remove_action( 'woocommerce_after_single_product', 'woocommerce_output_related_products',10);

add_filter( 'woocommerce_cart_item_name', 'add_sku_in_cart', 20, 3);
function add_sku_in_cart( $title, $values, $cart_item_key ) {
	$sku = $values['data']->get_sku();
	$url = $values['data']->get_permalink( $product->ID );
	$final = '<a href="'. $url .'">'. $title .'</a>';
	$sku =  ($sku)?'<br> Mã SP: <strong>'.$sku.'</strong>':'';
	return $sku ?  sprintf("%s", $final) .$sku : $final;
}   

/* Add new reviews tabs */
add_filter( 'woocommerce_product_tabs', 'dns_new_product_tab' );
function dns_new_product_tab( $tabs ) {
    unset($tabs['additional_information']);
    $tabs['description']['title'] = 'Chi tiết';
    if (get_toption('page_doitra') != '') {
        $tabs['dt_tab'] = array(
            'title'     => __( 'Đổi trả', 'woocommerce' ),
            'priority'  => 100,
            'callback'  => 'dns_doitra_tab_content'
        );
    }
    

    // $tabs['reviews_tab'] = array(
    //     'title'     => __( 'Đánh Giá', 'woocommerce' ),
    //     'priority'  => 200,
    //     'callback'  => 'dns_reviews_tab_content'
    // );

    return $tabs;
}

function dns_doitra_tab_content()
{
    $page_doitra = get_post(get_toption('page_doitra'));
    print wpautop($page_doitra->post_content);
}

function dns_reviews_tab_content() {
    comments_template('', true);
}


add_filter( 'woocommerce_breadcrumb_defaults', 'dns_change_breadcrumb_home_text' );
function dns_change_breadcrumb_home_text( $defaults ) {
    $defaults['home'] = 'Đầm maxi';
    return $defaults;
}



add_filter('woocommerce_sale_flash', 'dns_sale_flash');
function dns_sale_flash($text) {
    global $product;
    $percentage = round( ( ( $product->regular_price - $product->sale_price ) / $product->regular_price ) * 100 );
    return '<span class="onsale">Giảm '.$percentage.'%</span>';  
}   

function get_percen_price(){
    global $product;
    if ( ! $product->is_in_stock() ) return;
    $sale_price = get_post_meta( $product->id, '_price', true);
    $regular_price = get_post_meta( $product->id, '_regular_price', true);
    if (empty($regular_price)){ //then this is a variable product
        $variation_id=$available_variations[0]['variation_id'];
        $variation= new WC_Product_Variation( $variation_id );
        $regular_price = $variation ->regular_price;
        $sale_price = $variation ->sale_price;
    }
    if ($regular_price != '') {
        $sale = ceil(( ($regular_price - $sale_price) / $regular_price ) * 100);

        if ($sale != 0) {
            return  '<span class="sale-off">'.$sale.'%</span>';
        }
    }
}

