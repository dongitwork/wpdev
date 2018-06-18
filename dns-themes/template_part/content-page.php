<article id="page-<?php the_ID(); ?>" <?php post_class(); ?>>
	<?php if (!is_home() && !is_front_page()): ?>
		<h1 class="page-title"><?php the_title(); ?></h1>
	<?php endif; ?>
	<div class="page-content">
		<?php the_content(); ?>
	</div>
</article>