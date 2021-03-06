<?php 
/*
* Template Name: Basic grid: Default
*/
?>

<div id="<?php echo esc_attr($atts['html_id']);?>" class="sa_vc-grid-wrapper <?php echo esc_attr($atts['class']);?>" >
    <div class="row sa_vc-grid <?php echo esc_attr($atts['grid_class']);?>">
        <?php
            $posts = $atts['posts'];
            while($posts->have_posts()):
                $posts->the_post();            
        ?>
            <div class="sa_vc-grid-item <?php echo esc_attr($atts['item_class']);?>" >
                <?php
                    if (has_post_thumbnail() && !post_password_required() && !is_attachment() ){
                         get_the_post_thumbnail(get_the_ID(),'full',array('class'=>'img-responsive'));
                     }else{
                        print '<img src="' . USAEV_IMAGES . 'no-image.jpg" alt="' . get_the_title() . '" class="img-responsive" />';
                     }
                ?>
                <div class = "sa_vc-grid-title">
                     <a href="<?php the_permalink(); ?>" title="<?php the_title();?>"><?php the_title();?></a>
                </div>
                <div class="sa_vc-grid-time">
                    <?php the_time('l, F j, Y');?>
                </div>
                <div class="sa_vc-grid-content">
                    <?php
                        $atts['numshows'] = ($atts['numshows']!='')?$atts['numshows']:15;
                        print wp_trim_words( get_the_content(), (int)$atts['numshows'], '...' );
                    ?>
                </div>
            </div>
        <?php endwhile; ?>
    </div>
    <?php
    wp_reset_postdata();
    ?>
</div>
