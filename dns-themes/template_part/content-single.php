<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<header class="post-header">
		<h1 class="post-title bg-title entry-title"><?php the_title(); ?></h1>
		<div class="post_meta">
        	<span class="fa fa-clock-o "></span> <?php print get_the_date('d/m/Y', get_the_ID() ); ?> 
        	<span class="post-cat">
        		<span class="fa fa-folder-open  "></span> <?php print the_category( ',', '', get_the_ID() ); ?>
        	</span>
        </div>
	</header>
	<!-- Box Tư vấn -->	
	<?php print do_shortcode('[box_tuvan]' ); ?>

	<div class="post-content">
		<?php 
			the_content();
		?> 
	</div>

	<!-- Box Tư vấn -->	
	<?php print do_shortcode('[box_tuvan]' ); ?>
	<?php print do_shortcode('[box_contact]'); ?>
	
</article>

<?php //print get_share(get_the_ID());?>
<?php if (has_tag()): ?>
	<div class="post-tag">
		<?php the_tags( 'Tags: ', ', ', '' ); ?>
	</div>
<?php endif; ?>

