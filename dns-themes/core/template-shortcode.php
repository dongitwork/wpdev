<?php
/* List Social*/
add_shortcode('list_social', 'list_social_func');
function list_social_func($atts, $content = null){
	return flex_social();
}

// [news_by_id title="" number="" type="" layout="" hide_title="" has_container= ]
add_shortcode('news_by_id', 'dns_news_by_id');
function dns_news_by_id($atts, $content = null){
	extract(shortcode_atts(array(
        'title'     => '',
        'number'    => 5,
        'type'      => 'by_cat',
        'layout'    => 'slider_image',
        'hide_title'	=> 0,
        'has_container'	=> 1,
    ), $atts));
    ob_start();
    global $post;
    // 'by_cat'			=> __( 'Theo Danh Mục', '' ),
	// 'by_tags' 		=> __( 'Theo Tags', '' ),
	// 'by_oldid'   	=> __( 'Bài Viết Cũ Hơn', '' ),
	// 'by_newid'   	=> __( 'Bài Viết Mới Hơn', '' ),
	// 'views_more'   	=> __( 'Xem Nhiều Nhất', '' ),
	// 'views_recent'	=> __( 'Bài mới nhất', '' ),
	// 'views_old'   	=> __( 'Bài Cũ nhất', '' ),
	switch ($type) {
		case 'by_cat':
			$cats = wp_get_post_categories(get_the_ID());
			if (!empty($cats)) {
				$args = array('post_type' => 'post',
			          'post_status' => 'publish',
			          'category__in' => $cats ,
			          'posts_per_page'=>$number);
			  	$pl_query = new WP_Query( $args );
			  	the_post_by($pl_query,$title,$layout,$has_container,$hide_title);
			}
			break;

		case 'by_tags':
			$allterms = wp_get_post_terms( get_the_ID(),'post_tag',array( 'fields' => 'ids' ));
		  	if (!empty($allterms)) {
			  	$args = array('post_type' => 'post',
			          'post_status' => 'publish',
			          'tax_query' => array(
							'relation' => 'AND',
							array(
								'taxonomy' => 'post_tag',
								'field'    => 'term_id',
								'terms'    => $allterms,
							),
						),
			          'posts_per_page'=>$number);
			  	$pl_query = new WP_Query( $args );
			  	the_post_by($pl_query,$title,$layout,$has_container,$hide_title);
			  }
			break;

		case 'by_oldid':
			$data_pre = dns_get_posts(get_the_ID(),'pre');
			if (!empty($data_pre)){
				$pl_query = new WP_Query( array( 'post_type' => 'post', 'post__in' => $data_pre));
				the_post_by($pl_query,$title,$layout,$has_container,$hide_title);
			}
			break;

		case 'by_newid':
			$data_next = dns_get_posts(get_the_ID());
			if (!empty($data_next)){
				$pl_query = new WP_Query( array( 'post_type' => 'post', 'post__in' => $data_next) );
				the_post_by($pl_query,$title,$layout,$has_container,$hide_title);
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
		  	the_post_by($pl_query,$title,$layout,$has_container,$hide_title);
			break;

		case 'views_recent':
			$args = array('post_type' => 'post',
				          'post_status' => 'publish',
				          'orderby' => 'ID',
						  'order'   => 'DESC',
				          'posts_per_page'=>$number);
				  	$pl_query = new WP_Query( $args );
				  	the_post_by($pl_query,$title,$layout,$has_container,$hide_title);
			break;

		case 'views_old':
			$args = array('post_type' => 'post',
				          'post_status' => 'publish',
				          'orderby' => 'ID',
						  'order'   => 'ASC',
				          'posts_per_page'=>$number);
		  	$pl_query = new WP_Query( $args );
		  	the_post_by($pl_query,$title,$layout,$has_container,$hide_title);
			break;
	}
    return ob_get_clean();
}

/* Box Contact */
add_shortcode('box_contact', 'box_contact_func');
function box_contact_func($atts, $content = null){
	ob_start();
	?>
	<div class="box-contact shadow">
		<div class="box-title">Liên Hệ Chúng Tôi</div>
		<div class=" flex-center ">
			<div class="info-logo">
				<?php 
					$logo = get_toption('logo-image');
				?>
				<img class="sitelogo" src="<?=$logo['url'];?>" alt="<?=get_toption('site_title'); ?>" title="<?=get_toption('site_title'); ?>">
			</div>
			<div class="info-contact">
				<h4><?=get_toption('site_title'); ?></h4>
				<div class="info-address">
					<?php 
						if (get_toption('site_phone') != '') {
							print 'Hotline: <a href="tel:'.get_toption('site_phone').'">'.get_toption('site_phone').'</a><br>';
						}

						if (get_toption('site_address') != '') {
							print ''.get_toption('site_address').'<br>';
						}

						if (get_toption('site_email') != '') {
							print 'Email: <a href="mailto:'.get_toption('site_email').'">'.get_toption('site_email').'</a><br>';
						}
					?>
				</div>
			</div>

		</div>
	</div>
	<?php
	return ob_get_clean();
}

/* Box Cart */
add_shortcode('box_cart', 'box_cart_func');
function box_cart_func($atts, $content = null){
	ob_start();
	?>
	 
	<div class="box_cart">
		<div class="cart_iterms">
			<a  href="<?php echo wc_get_cart_url(); ?>" title="<?php _e( 'Xem sản phẩm trong giỏ hàng' ); ?>">
			<span class="fa fa-shopping-cart"></span>
			<span class="cart_group">
				<span class="name">
					Giỏ hàng
				</span>
				<span class="iterm">
					<?=WC()->cart->get_cart_contents_count(); ?> iterm
				</span>
			</span>
			</a>
		</div>
	</div>
	<?php
	return ob_get_clean();
}

/* Box Tu van */
add_shortcode('box_tuvan', 'box_tuvan_func');
function box_tuvan_func($atts, $content = null){
	ob_start();
	?>
	<?php if (get_toption('frm_tuvan') != ''): ?>
		<div class="form-tu_van">
			<?php print do_shortcode( get_toption('frm_tuvan'), false ) ?>
		</div>
	<?php endif; ?>
	<?php
	return ob_get_clean();
}

/* Box Tu van & liên hệ */
add_shortcode('lienhe_tuvan', 'box_tuvan_lienhe_func');
function box_tuvan_lienhe_func($atts, $content = null){
	ob_start();
	?>
	<div class="lienhe_tuvan">
		<div class="row flex-center mblock">
			<div class="col-xs-12 col-sm-6">
				<?=do_shortcode('[box_tuvan]' ); ?>
			</div>
			<div class="col-xs-12 col-sm-6">
				<?=do_shortcode('[box_contact]' ); ?>
			</div>
		</div>
	</div>
	<?php
	return ob_get_clean();
}


/* List news */
if(function_exists('vc_map')){
	vc_map(
		array(
			"name" => __("Danh Sách Bài Viết", 'flex-theme'),
		    "base" => "list_post",
		    "class" => "vc-list_post",
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
                    'heading' => __( 'Link Xem thêm' ),
                    'param_name' => 'link',
                    'type' => 'vc_link',
                    "group" => __("Source Settings", 'flex-theme')
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
add_shortcode('list_post', 'list_post_func');
function list_post_func($atts, $content = null){
	extract(shortcode_atts(array(
        'title'    => '',
        'desc'    => '',
        'link'    => '',
        'html_id' => 'list_post'.rand(),
        'class' => 'list_post'.rand(),
    ), $atts));
	$source = $atts['source'];
	ob_start();
    list($args, $pl_query) = vc_build_loop_query($source);
	$pl_query = new WP_Query($args); 
			if ( $pl_query->have_posts() ) {
				
				?>
				<div id="<?=$html_id;?>" class="dns-list_post dns-owl_list <?=$class;?>">
                    <div class="group-title text-left">
                    	<h2 class="block-title "><?=$title; ?></h2>
                    	<?php if($desc != ''): ?>
	                    	<div class="desc">
	                    		<?=$desc;?>
	                    	</div>
	                    <?php endif; ?>
                    </div>
                    
					<div class="dns-crpost_wp">
						<div class="dns-crpost owl-carousel owl-theme">
							<?php 
								while ( $pl_query->have_posts() ) :
									$pl_query->the_post();
							?>
								<div class="crpost-iterm long animate_ftb">
								    <div class="row">
								    	<div class="col-xs-4">
								    		<a href="#" class="d_block photoframe ">
												<?php 
													the_dns_image(array(100,135),'img-responsive tr_all_long_hover',get_the_post_thumbnail_url( get_the_ID(), 'full' )) ;
												?>
											</a>
								    	</div>
								    	<div class="col-xs-8">
								    		 <div class="mini_post_content">
										        <div class="post-title ">
										        	<a href="<?php the_permalink(); ?>" class="color_dark">
										        		<?php the_title(); ?>
										        	</a>
										        </div>
										        <div class="post_meta">
										        	<span class="fa fa-calendar "></span> <?php print get_the_date('d/m/Y', get_the_ID() ); ?>
										        </div>
										        <div class="post_content">
										        	<?php print wp_trim_words(get_the_content(),15,'...'); ?>
										        </div>
										        <div class="post_more text-right">
										        	<a class="more-btn" href="<?php the_permalink(); ?>">Xem thêm <i class="fa fa-angle-double-right"></i></a>
										        </div>
										    </div>
								    	</div>
								    </div>
								   
	                            </div>
					        <?php 
					        	endwhile;
					        	wp_reset_postdata();
					        ?>
						</div>
						<?php if ($link != ''): 
							$url = vc_build_link( $link );
							$a_link = $url['url'];
							$a_target = ($url['target'] == '') ? '' : 'target="'.$url['target'].'"';
						?>
							<div class="more_link text-right">
								<a <?=$a_target;?> href="<?=$a_link;?>" class="link_btn">
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

