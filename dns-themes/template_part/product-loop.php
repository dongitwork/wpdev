<?php 
global $product; 
//data-wow-delay="1s"
//photoframe long animate_ftb
?>
<div class="product-container  ">
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