<?php get_header(); ?> 
<section id="main-content" class="404-content" role="main">
	<div class="container">
		<div class="row">
			<?php get_sidebar('left'); ?> 
				<div id="main-column" class="<?php flex_col(); ?>" >
					<?php the_toption('404_content') ?>
				</div>
			<?php get_sidebar('right'); ?> 
		</div>
	</div>
</section>
<?php get_footer(); ?> 