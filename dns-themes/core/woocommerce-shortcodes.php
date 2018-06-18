<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/* List product */
if(function_exists('vc_map')){
	vc_map(
		array(
			"name" => __("Danh Sách Sản Phẩm", 'flex-theme'),
		    "base" => "list_product",
		    "class" => "vc-list_product",
		    "category" => __("DongNam Solutions", 'flex-theme'),
		    "params" => array(
		    	array(
		            "type" => "loop",
		            "heading" => __("Source",'flex-theme'),
		            "param_name" => "source",
		            'settings' => array(
		                'size' => array('hidden' => false, 'value' => 10),
		                'order_by' => array('value' => 'date')
		            ),
		            "group" => __("Source Settings", 'flex-theme'),
		        ),
		        array(
		            "type" => "textfield",
		            "heading" => __("Tiêu đề",'flex-theme'),
		            "param_name" => "title",
		            "value" => "",
		            "admin_label" => true,
		            "description" => __("",'flex-theme'),
		            "group" => __("Source Settings", 'flex-theme')
		        ),
		        array(
		            "type" => "textfield",
		            "heading" => __("Mô tả",'flex-theme'),
		            "param_name" => "desc",
		            "value" => "",
		            "description" => __("",'flex-theme'),		            
		            "group" => __("Source Settings", 'flex-theme')
		        ),
		        
                array(
	                "type" => "checkbox",
	                "heading" => __("Lựa chọn thêm",'smart-addon'),
	                "param_name" => "extraoptions",
	                "value" => array(
	                    "Sản phẩm nỗi bật" => 'is_featured',
	                    "Hiển thị Slider" => 'is_slider',
	                    "Hiển thị Xem thêm" => 'is_showmore',
	                ),
	                "group" => __("Source Settings", 'flex-theme')
	            ),

	            array(
                    'heading' => __( 'Link Xem thêm' ),
                    'param_name' => 'link',
                    'type' => 'textfield',
                     "dependency" => array(
	                    "element"=>"extraoptions",
	                    "value" => 'is_showmore'
	                ),
                    "group" => __("Source Settings", 'flex-theme')
                ),
		        array(
	                "type" => "dropdown",
	                "heading" => __("Heading",'smart-addon'),
	                "param_name" => "heading",
	                "value" => array(
	                    "H1" => 1,
	                    "H2" => 2,
	                    "H3" => 3,
	                    "H4" => 4
	                ),
	                'std' => 3,
	                "group" => __("Template", 'flex-theme')
	            ),
		        array(
		            "type" => "textfield",
		            "heading" => __("Extra Class",'flex-theme'),
		            "param_name" => "class",
		            "value" => "",
		            "description" => __("",'flex-theme'),
		            "group" => __("Template", 'flex-theme')
		        ),
		        array(
		            "type" => "textfield",
		            "heading" => __("Extra Id",'flex-theme'),
		            "param_name" => "html_id",
		            "value" => "",
		            "description" => __("",'flex-theme'),
		            "group" => __("Template", 'flex-theme')
		        )
		    )
		)
	);
}
add_shortcode('list_product', 'list_product_func');
function list_product_func($atts, $content = null){
	extract(shortcode_atts(array(
        'title' 	=> '',
        'desc'		=> '',
        'link'		=> '',
        'extraoptions'		=> '',
        'heading'			=> '3',
        'html_id' 	=> 'list_product'.rand(),
        'class' 	=> 'list_product'.rand(),
    ), $atts));
	$source = $atts['source'];
	ob_start();
    list($args, $pl_query) = vc_build_loop_query($source);
    $extraoptions = explode(',', $extraoptions);
    if (in_array('is_featured', $extraoptions)) {
    	$args['tax_query'] = array( array(
                        'taxonomy' => 'product_visibility',
                        'field'    => 'name',
                        'terms'    => 'featured',
                    ),);
    	
    }

    if (in_array('is_slider', $extraoptions)) {
    	$iterm_class = '';
    	$wp_class = 'products_crs owl-carousel owl-theme';	  	
    }else{
    	$wp_class = 'row';	
    	$iterm_class = 'col-xxs-6 col-xs-4 col-sm-3 col-md-3 col-lg-5';
    }

	$pl_query = new WP_Query($args); 
			if ( $pl_query->have_posts() ) {
				?>
				<div id="<?=$html_id;?>" class="dns-list_product dns-owl_list <?=$class;?>">
					<?php if (trim($title) != '' || $desc != ''): ?>
	                    <div class="group-title text-left">
	                    	<?php if (trim($title) != ''): ?>
	                    		<h<?=$heading;?> class="block-title ">
	                    			<?=$title; ?>	
	                    		</h<?=$heading;?>>
	                    	<?php endif; ?>
	                    	<?php if($desc != ''): ?>
		                    	<div class="desc">
		                    		<?=$desc;?>
		                    	</div>
		                    <?php endif; ?>
	                    </div>
                    <?php endif; ?>
					<div class="dns-crpost_wp">
						<div class="dns-cr_product <?=$wp_class;?>">
							<?php 
								while ( $pl_query->have_posts() ) :
									$pl_query->the_post();
							?>
								<div class="crproduct-iterm <?=$iterm_class;?>">
								   <?php global $product; ?>
									<div class="product-container photoframe animate_ftb long">
									    <div class="left-block">
									        <a href="<?php the_permalink(); ?>">
									            <?php 
									                the_dns_image(array(255,340),'img-responsive tr_all_long_hover',get_the_post_thumbnail_url( get_the_ID(), 'full' )) ; 
									            ?>
									        </a>
									         <div class="add-to-cart">
									            <a title="Xem thêm" href="<?php the_permalink(); ?>"><i class="fa fa-eye" ></i> Xem thêm</a>
									        </div>
									    </div>
									    <div class="right-block">
									        <div class="product-name">
									            <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
									        </div>
									        <div class="content_price">
									            <?php 
									                print $product->get_price_html();;
									            ?>
									        </div>
									    </div>
									</div>
	                            </div>
					        <?php 
					        	endwhile;
					        	wp_reset_postdata();
					        ?>
						</div>
						
						<?php 
							if ($link != '' && in_array('is_showmore', $extraoptions)): 
						?>
							<div class="more_link text-right">
								<a href="<?=$link;?>" class="link_btn">
									<span class="fa fa-hand-o-right"></span> Xem thêm
								</a>
							</div>
						<?php endif; ?>

					</div>
				</div>
				<?php
				
			}

    return ob_get_clean();
}



// [product_by_id title="" number="" type="" layout="" hide_title="" has_container= ]
add_shortcode('product_by_id', 'dns_product_by_id');
function dns_product_by_id($atts, $content = null){
	extract(shortcode_atts(array(
        'title'     => '',
        'number'    => 5,
        'type'      => 'by_tags',
        'layout'    => 'image_text',
        'hide_title'	=> 0,
        'has_container'	=> 1,
    ), $atts));
    ob_start();
    global $post;

    // 'by_cat'			=> __( 'Theo Danh Mục', '' ),
	// 'by_tags' 		=> __( 'Theo Tags', '' ),
	// 'by_oldid'   	=> __( 'Sản Phẩm Cũ Hơn', '' ),
	// 'by_newid'   	=> __( 'Sản Phẩm Mới Hơn', '' ),
	// 'views_more'   	=> __( 'Sản Phẩm Xem Nhiều Nhất', '' ),
	// 'views_recent'	=> __( 'Sản Phẩm mới nhất', '' ),

	switch ($type) {
		case 'by_cat':
			$cats = wp_get_post_terms( get_the_ID(),'product_cat',array( 'fields' => 'ids' ));
			if (!empty($cats)) {
				$args = array('post_type' => 'product',
			          'post_status' => 'publish',
			          'tax_query' => array(
							'relation' => 'AND',
							array(
								'taxonomy' => 'product_cat',
								'field'    => 'term_id',
								'terms'    => $allterms,
							),
						),
			          'posts_per_page'=>$number);
			  	$pl_query = new WP_Query( $args );
			  	the_product_by($pl_query,$title,$layout,$has_container,$hide_title);
			}
			break;

		case 'by_tags':
			$allterms = wp_get_post_terms( get_the_ID(),'product_tag',array( 'fields' => 'ids' ));
		  	if (!empty($allterms)) {
			  	$args = array('post_type' => 'product',
			          'post_status' => 'publish',
			          'tax_query' => array(
							'relation' => 'AND',
							array(
								'taxonomy' => 'product_tag',
								'field'    => 'term_id',
								'terms'    => $allterms,
							),
						),
			          'posts_per_page'=>$number);
			  	$pl_query = new WP_Query( $args );
			  	the_product_by($pl_query,$title,$layout,$has_container,$hide_title);
			  }
			break;

		case 'by_oldid':
			$data_pre = dns_get_posts(get_the_ID(),'pre');
			if (!empty($data_pre)){
				$pl_query = new WP_Query( array( 'post_type' => 'product', 'post__in' => $data_pre));
				the_product_by($pl_query,$title,$layout,$has_container,$hide_title);
			}
			break;

		case 'by_newid':
			$data_next = dns_get_posts(get_the_ID());
			if (!empty($data_next)){
				$pl_query = new WP_Query( array( 'post_type' => 'product', 'post__in' => $data_next) );
				the_product_by($pl_query,$title,$layout,$has_container,$hide_title);
			}
			break;

		case 'views_more':
			$args = array('post_type' => 'post',
			          'post_status' => 'publish',
			          'meta_key' => 'post_views_count',
			          'orderby' => 'post_views_count',
					  'order'   => 'DESC',
			          'posts_per_page'=>$number);
		  	$pl_query = new WP_Query( $args );
		  	the_product_by($pl_query,$title,$layout,$has_container,$hide_title);
			break;

		case 'views_recent':
			$args = array('post_type' => 'post',
				          'post_status' => 'publish',
				          'orderby' => 'ID',
						  'order'   => 'DESC',
				          'posts_per_page'=>$number);
				  	$pl_query = new WP_Query( $args );
				  	the_product_by($pl_query,$title,$layout,$has_container,$hide_title);
			break;

	}
    return ob_get_clean();
}

function the_product_by($pl_query = array(),$title = '',$layout = 'slider_image',$has_container = 1, $hidetitle = 0)
{
	if ( $pl_query->have_posts() ) {
		$containercl = ($has_container == 1)?'container':'';
		switch ($layout) {
			case 'slider_image':
			
			if ( $pl_query->have_posts() ) {
				?>
				<div id="dns-list_product-<?=rand();?>"  class="dns-list_product dns-owl_list ">
					<div class="<?=$containercl;?>">
						<?php if ($hidetitle === 0): ?>
	                        <div class="group-title text-left">
	                            <h3 class="block-title "><?=$title; ?></h3>
	                        </div>
	                    <?php endif; ?>
	                            
						<div class="dns-crpost_wp">
							<div class="dns-cr_product products_crs owl-carousel owl-theme">
								<?php 
									while ( $pl_query->have_posts() ) :
										$pl_query->the_post();
								?>
									<div class="crproduct-iterm ">
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
			break;

			case 'image_text':
				if ( $pl_query->have_posts() ) {
					?>
					<div id="dns-list_product-<?=rand();?>"  class="dns-list_product dns-owl_list ">
						<div class="<?=$containercl;?>">
							<?php if ($hidetitle === 0): ?>
		                        <div class="group-title text-left">
		                            <h3 class="block-title "><?=$title; ?></h3>
		                        </div>
		                    <?php endif; ?>
		                            
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
				break;

			case 'list_sidebar':
				?>
					<div  class="dns-ls_container">
			            <div class="<?=$containercl;?>">
			            	<?php if ($hidetitle === 0): ?>
				            	<div class="group-title text-left">
					            	<h3 class="block-title "><?=$title; ?></h3>
					            </div>
					        <?php endif; ?>
				            
							<div class="dns-ls_wp">
								<ul class="dns_list_style">
									<?php 
										while ( $pl_query->have_posts() ) :
											$pl_query->the_post();
											set_query_var( 'layout', 'list_title' );
											get_template_part('template_part/post', 'loop');
							        	endwhile;
							        	wp_reset_postdata();
							        ?>
								</ul>
							</div>
			            </div>
					</div>
				<?php 
			break;

            case 'list_price':
                ?>
                    <div  class="dns-ls_container">
                        <div class="<?=$containercl;?>">
                            <?php if ($hidetitle === 0): ?>
                                <div class="group-title text-left">
                                    <h2 class="block-title "><?=$title; ?></h2>
                                </div>
                            <?php endif; ?>
                            
                            <div class="dns-ls_wp">
                                <ul class="dns_list_style">
                                    <?php 
                                        while ( $pl_query->have_posts() ) :
                                            $pl_query->the_post();
                                            set_query_var( 'layout', 'list_title' );
                                            get_template_part('template_part/post', 'loop');
                                        endwhile;
                                        wp_reset_postdata();
                                    ?>
                                </ul>
                            </div>
                        </div>
                    </div>
                <?php 
            break;

		}
	}
}

