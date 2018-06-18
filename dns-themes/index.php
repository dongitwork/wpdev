<?php
/**
 * The main template file
 * 
 * @package flex-theme
 */
	get_header();
?>

<section id="main-content" class="main-content" role="main">
	<div class="container">
		<div class="row">
			<?php get_sidebar('left'); ?> 
				<div id="main-column" class="<?php flex_col(); ?>" >

					<?php 
						if (have_posts()) {
							while (have_posts()) {
								the_post();
								get_template_part('template_part/content', get_post_format());
							}
						}else { 
							get_template_part('template_part/content', 'none');
						}  
					?> 
					<?php fx_nav_pager(); ?>
				</div>
			<?php get_sidebar('right'); ?> 
		</div>
	</div>
</section>
<?php get_footer(); ?> 