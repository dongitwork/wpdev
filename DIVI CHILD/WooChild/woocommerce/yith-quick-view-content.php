<?php
/*
 * This file belongs to the YIT Framework.
 *
 * This source file is subject to the GNU GENERAL PUBLIC LICENSE (GPL 3.0)
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://www.gnu.org/licenses/gpl-3.0.txt
 */

while ( have_posts() ) : the_post(); ?>
<div class="product sa-quick_views sa-pro_detaill">
	<div id="product-<?php the_ID(); ?>" <?php post_class('product'); ?>>
		<div class="sa-pro_info">
			<div class="row_fl">
				<div class="col-sm-4 col-md-6 hidden-xs">
					<div class="sa-pro_image">
						 <?php 
				        	print get_image_size(array(400,450),'img-responsive');
				        ?>
					</div>
				</div>
				<div class="col-xs-12 col-sm-8 col-md-6">
					<div class="summary-content">
						<?php do_action( 'yith_wcqv_product_summary' ); ?>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<?php endwhile;