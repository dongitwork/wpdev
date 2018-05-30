<?php if ($atts['sourcetype'] != 'post'): ?>
    <div  class="fl-carousel-wrap">
        <div id="<?php echo esc_attr($atts['html_id']); ?>"  class="fl-carousel <?php echo esc_attr($atts['template']); ?>" >
            <?php
            $images = explode( ',',$atts['imagessource']) ;
                foreach ($images as $key => $imid):
                ?>
                <div class="fl-carousel-item">
                    <?php
                      print  wp_get_attachment_image($imid,'full',false,array('class'=>'img-responsive center-block'));
                    ?>
                </div>
            <?php endforeach;
            ?>
        </div>
    </div>
<?php else: ?>
    <div  class="fl-carousel-wrap">
        <div id="<?php echo esc_attr($atts['html_id']); ?>"  class="fl-carousel <?php echo esc_attr($atts['template']); ?>" >
            <?php
            $posts = $atts['posts'];
            while ($posts->have_posts()) :
                $posts->the_post();
                ?>
                <div class="fl-carousel-item">
                    <?php
                        if (has_post_thumbnail() && !post_password_required() && !is_attachment() && wp_get_attachment_image_src(get_post_thumbnail_id(get_the_ID()), 'full', false)):
                            the_post_thumbnail('full',array('class'=>'img-responsive'));
                        else:
                            echo '<img src="' . FL_IMAGES . 'no-image.jpg" class="img-responsive" alt="' . get_the_title() . '" />';
                        endif;
                    ?>
                    <div class="fl-carousel-content">
                        <a href="<?php the_permalink(); ?>" title="<?php the_title();?>">
                            <h3 class="fl-carousel-title"><?php the_title();?></h3>  
                        </a>
                        <div class="fl-carousel-desc">
                            <?php echo wp_trim_words( get_the_content(), 15, '...' ); ?>
                        </div>
                    </div>
                </div>
            <?php
            endwhile;
            wp_reset_postdata();
            ?>
        </div>
    </div>
<?php endif; ?>
