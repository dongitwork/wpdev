<?php 
	global $product;
?>
<div class="col-xs-6 col-xs-full col-sm-6 col-md-3">
	<div class="sa-pro_iterm">
		<div class="sa-pro_iterm_inner text-center">
		    <div class="sa-pro_image">
		        <?php 
		        	print get_image_size(array(155,190),'img-responsive');
		        ?>
		    </div>
		    <a href="<?php the_permalink(); ?>">
		        <h2 class="sa-pro_title"><?php the_title(); ?></h2>
		    </a>
		    <div class="sa-pro_desc">
		        <?php 
		        	print wp_trim_words($product_detail['short_description'], 4, '' );
		        ?>
		    </div>
		    <div class="sa-pro_btn">
		        <a data-product_id="<?php the_ID(); ?>" href="#" class="yith-wcqv-button sa-pro_addcart">
					<span class="fa fa-plus"></span> Add to cart
				</a>
		    </div>
		</div>
	</div>
</div>