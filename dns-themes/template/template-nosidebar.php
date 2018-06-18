<?php
/**
 * Template Name: No Sidebar
 *
 * @package flex-theme
 */
	get_header();
?> 
<section id="main-content" class="main-content" role="main">
	<div id="main-column" class="container" >
		<?php 
			if (have_posts()) {
				while (have_posts()) {
					the_post();
					get_template_part('template_part/content','page');
				}
			}else { 
				get_template_part('template_part/content', 'none');
			}  
		?> 
	</div>
</section>
<?php get_footer(); ?> 