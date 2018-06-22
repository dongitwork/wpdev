<article id="rkt-blog-<?php the_ID(); ?>" class="rkt_blog-iterm">
	<?php if (has_post_thumbnail() ): ?>
		<div class="blog_iterm-inner">
			<div class="col-iterm col-image">
				<div class="rkt-blog-image_mobile">
					<?php the_post_thumbnail( 'full'); ?>
				</div>
				<div class="rkt-blog-image" style="background-image: url('<?php the_post_thumbnail_url('full'); ?>');">
				</div>
			</div>	
			<div class="col-iterm col-content">

				<div class="rkt-group-title ">
					<a href="<?php the_permalink(); ?>">
						<h3 class="rkt-blog-title">
							<?php the_title(); ?>
						</h3>
					</a>
					<div class="rkt-blogtop-meta">
						<span>on <?php echo get_the_date(); ?></span>
						<span class="rkt_pauthor">By <?php the_author(); ?></span>
					</div>
				</div>

				<div class="rkt-blog-content">
					<?php print wp_trim_words( get_the_content(), 35, '.' ); ?>
				</div>

				<div class="rkt-blog-more text-right">
					<a class="rkt-btn-more" href="<?php the_permalink(); ?>">Read More</a>
				</div>

				<div class="rkt-blog-meta">
					<div class="row_fl">
						<div class="col-xs-4">
							<span class="rkt-meta-comment">
								<i class="fa fa-commenting-o"></i>
								 12 Coments
							</span>
						</div>
						<div class="col-xs-4">
							<span class="rkt-meta-like">
								<i class="fa fa-thumbs-o-up"></i>
								 5 Likes
							</span>
						</div>
						<div class="col-xs-4">
							<span class="rkt-meta-share">
								<i class="fa fa-share-alt"></i>
								 14 Shares
							</span>
						</div>
					</div>
				</div>

			</div>
		</div>
	<?php else: ?>
		<div class="blog_noimg-inner">
			<div class="rkt-group-title ">
				<a href="<?php the_permalink(); ?>">
					<h3 class="rkt-blog-title">
						<?php the_title(); ?>
					</h3>
				</a>
				<div class="rkt-blogtop-meta">
					<span>on <?php echo get_the_date(); ?></span>
					<span class="rkt_pauthor">By <?php the_author(); ?></span>
				</div>
			</div>

			<div class="rkt-blog-content">
				<?php print wp_trim_words( get_the_content(), 35, '.' ); ?>
			</div>

			<div class="rkt-blog-more text-right">
				<a class="rkt-btn-more" href="<?php the_permalink(); ?>">Read More</a>
			</div>
			<div class="rkt-blog-meta">
				<div class="row_fl">
					<div class="col-xs-4">
						<span class="rkt-meta-comment">
							<i class="fa fa-commenting-o"></i>
							 12 Coments
						</span>
					</div>
					<div class="col-xs-4">
						<span class="rkt-meta-like">
							<i class="fa fa-thumbs-o-up"></i>
							 5 Likes
						</span>
					</div>
					<div class="col-xs-4">
						<span class="rkt-meta-share">
							<i class="fa fa-share-alt"></i>
							 14 Shares
						</span>
					</div>
				</div>
			</div>
		</div>
	<?php endif; ?>
</article>