<?php

// HOOK FOR WOOCOMMERCE
remove_action( 'woocommerce_before_shop_loop', 'woocommerce_catalog_ordering', 30 );

remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_rating', 10 );
add_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_rating', 4 );

remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_excerpt', 20 );
add_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_excerpt', 9 );

// Remove price Label
add_filter( 'woocommerce_cart_shipping_method_full_label', 'remove_local_pickup_free_label', 10, 2 );
function remove_local_pickup_free_label($full_label, $method){
    $full_label = str_replace($method->label.': ',"",$full_label);
    return $full_label;
}



add_action( 'pre_get_posts', 'sa_custom_posts_per_page', 999  );
function sa_custom_posts_per_page( $query = false ) {
    if (!is_admin() && is_archive() && is_woocommerce() ) {
        parse_str($_SERVER['QUERY_STRING'], $params);
        $per_page = !empty($params['count']) ? $params['count'] : 8;
        $query->set( 'posts_per_page', $per_page ); 

        if ($_GET['procat'] ){
             $tax_query = array('relation' => 'AND',
                                    array(
                                        'taxonomy' => 'product_cat',
                                        'field'    => 'term_id',
                                        'terms'    => explode(',', $_GET['procat']),
                                    ),
                                 );
             $query->set('tax_query',$tax_query);
        }
    }
   
}


function sa_ajax_add_spin() {
    print '<div class="sa_ajax_loadding" style="display: none;">
                <div class="sa_ajax_loadin">
                    <span class="fa fa-spinner fa-pulse fa-3x fa-fw"></span>
                </div>
            </div>';
}
add_action( 'wp_footer', 'sa_ajax_add_spin' );



// ajax products archive display
// /add_filter('pre_option_woocommerce_shop_page_display', 'sa_shop_page_display_ajax');
// function sa_shop_page_display_ajax($value) {
//     $params = array('count', 'orderby', 'min_price', 'max_price');
//     foreach ($params as $param) {
//         if ( ! empty( $_GET[ $param ] ) ) return '';
//     }
//     $attribute_taxonomies = wc_get_attribute_taxonomies();
//     if ( $attribute_taxonomies ) {
//         foreach ( $attribute_taxonomies as $tax ) {
//             $attribute       = wc_sanitize_taxonomy_name( $tax->attribute_name );
//             $taxonomy        = wc_attribute_taxonomy_name( $attribute );
//             $name            = 'filter_' . $attribute;
//             if ( ! empty( $_GET[ $name ] ) && taxonomy_exists( $taxonomy ) ) {
//                 return '';
//             }
//         }
//     }
//     $page_num = get_query_var( 'paged' ) ? intval( get_query_var( 'paged' ) ) : 0;
//     if ($page_num) {
//         return '';
//     }

//     return $value;
// }

//remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_rating', 10 );




//
function sa_get_filtered_price() {
        global $wpdb, $wp_the_query;

        $args       = $wp_the_query->query_vars;
        $tax_query  = isset( $args['tax_query'] ) ? $args['tax_query'] : array();
        $meta_query = isset( $args['meta_query'] ) ? $args['meta_query'] : array();

        if ( ! is_post_type_archive( 'product' ) && ! empty( $args['taxonomy'] ) && ! empty( $args['term'] ) ) {
            $tax_query[] = array(
                'taxonomy' => $args['taxonomy'],
                'terms'    => array( $args['term'] ),
                'field'    => 'slug',
            );
        }

        foreach ( $meta_query + $tax_query as $key => $query ) {
            if ( ! empty( $query['price_filter'] ) || ! empty( $query['rating_filter'] ) ) {
                unset( $meta_query[ $key ] );
            }
        }

        $meta_query = new WP_Meta_Query( $meta_query );
        $tax_query  = new WP_Tax_Query( $tax_query );

        $meta_query_sql = $meta_query->get_sql( 'post', $wpdb->posts, 'ID' );
        $tax_query_sql  = $tax_query->get_sql( $wpdb->posts, 'ID' );

        $sql  = "SELECT min( FLOOR( price_meta.meta_value ) ) as min_price, max( CEILING( price_meta.meta_value ) ) as max_price FROM {$wpdb->posts} ";
        $sql .= " LEFT JOIN {$wpdb->postmeta} as price_meta ON {$wpdb->posts}.ID = price_meta.post_id " . $tax_query_sql['join'] . $meta_query_sql['join'];
        $sql .= "   WHERE {$wpdb->posts}.post_type IN ('" . implode( "','", array_map( 'esc_sql', apply_filters( 'woocommerce_price_filter_post_type', array( 'product' ) ) ) ) . "')
                    AND {$wpdb->posts}.post_status = 'publish'
                    AND price_meta.meta_key IN ('" . implode( "','", array_map( 'esc_sql', apply_filters( 'woocommerce_price_filter_meta_keys', array( '_price' ) ) ) ) . "')
                    AND price_meta.meta_value > '' ";
        $sql .= $tax_query_sql['where'] . $meta_query_sql['where'];

        if ( $search = WC_Query::get_main_search_query_sql() ) {
            $sql .= ' AND ' . $search;
        }

        return $wpdb->get_row( $sql );
}
