<?php if ( 'on' == et_get_option( 'divi_back_to_top', 'false' ) ) : ?>

	<span class="et_pb_scroll_top et-pb-icon"></span>

<?php endif;

if ( ! is_page_template( 'page-template-blank.php' ) ) : ?>

			<footer id="main-footer">
				<div class="footer_top">
					<div class="container">
						<div class="row_fl">
							<div class="col-xs-12 col-sm-4 col-md-3 ">
								<div class="logo_footer">
									<?php
										$logo = ( $user_logo = et_get_option( 'divi_logo' ) ) && '' != $user_logo
											? $user_logo
											: $template_directory_uri . '/images/logo.png';
									?>
									<a href="<?php echo esc_url( home_url( '/' ) ); ?>">
										<img src="<?php echo esc_attr( $logo ); ?>" alt="<?php echo esc_attr( get_bloginfo( 'name' ) ); ?>" />
									</a>
								</div>
							</div>							
							<div class="col-xs-12 col-sm-8 col-md-6">
								<div class="subscribe">
									<?php dynamic_sidebar('subscribe'); ?>
								</div>
							</div>							
							<div class="col-xs-12 col-sm-12 col-md-3">
								<div class="social_footer">
									<?php
										if ( false !== et_get_option( 'show_footer_social_icons', true ) ) {
											get_template_part( 'includes/social_icons', 'footer' );
										}
									?>
								</div>
							</div>
						</div>
					</div>
				</div>
				<?php get_sidebar( 'footer' ); ?>


		<?php
			if ( has_nav_menu( 'footer-menu' ) ) : ?>

				<div id="et-footer-nav">
					<div class="container">
						<?php
							wp_nav_menu( array(
								'theme_location' => 'footer-menu',
								'depth'          => '1',
								'menu_class'     => 'bottom-nav',
								'container'      => '',
								'fallback_cb'    => '',
							) );
						?>
					</div>
				</div> <!-- #et-footer-nav -->

			<?php endif; ?>

				<div id="footer-bottom">
					<div class="container clearfix">
				<?php
					

					echo et_get_footer_credits();
				?>
					</div>	<!-- .container -->
				</div>
			</footer> <!-- #main-footer -->
		</div> <!-- #et-main-area -->

<?php endif; // ! is_page_template( 'page-template-blank.php' ) ?>

	</div> <!-- #page-container -->

	<?php wp_footer(); ?>
</body>
</html>