<?php
/**
 * The theme footer
 * @author DongNam Solutions
 * @package dns-themes
 */

?>

<?php if (is_active_sidebar( 'after-content' ) && !is_singular( array('post','product'))):  ?>
	<div id="after-content">
		<div class="container">
			<?php
				dynamic_sidebar('after-content');
			?>
		</div>
	</div>
<?php endif; ?>

<?php if (is_active_sidebar( 'footer-tags' )):  ?>
	<div id="footer_tags" class="footer-tags">
		<?php
			dynamic_sidebar('footer-tags');
		?>
	</div>
<?php endif; ?>

		<footer id="footer" class="footer" role="contentinfo">
			<?php
				if (get_toption('shows_fbottom') == 1 && get_toption('fbottom_content') != ''):
			?>
				<div id="footer-bottom" class="footer-bottom">
					<div class="container">
						<div class="row">	
							<?php if ( get_toption('logo_footer_on') == 1) : ?>
								<div class="col-md-4 col-xs-12  text-center left-logo-footer">
									<a href="<?php echo esc_url(home_url('/')); ?>" title="<?php echo esc_attr(get_bloginfo('name', 'display')); ?>" rel="home">
										<img class="pl-logo center-block img-responsive" src="<?php 
											the_toption('logo_footer','image');
										?>">
									</a>
								</div>		
								<div class="col-md-8 col-xs-12 text-center ">
									<div class="fbottom-text wow fadeIn" data-wow-duration="1s">
										<?php 
											the_toption('fbottom_content');
										?>
									</div>	
								</div>
							<?php else: ?>								
								<div class="col-xs-12">
									<?php 
										the_toption('fbottom_content');
									?>		
								</div>		
							<?php endif; ?>
						</div>
					</div>
				</div>
			<?php endif; ?>



			<?php
				$col_vis = get_toption('wg-col');
				$fclass = 'col-xs-12 col-xs-full col-sm-6 col-md-'.(12/$col_vis);
				if ( is_active_sidebar( 'footer-1' ) ||  is_active_sidebar( 'footer-2' ) ||  is_active_sidebar( 'footer-3' ) ||  is_active_sidebar( 'footer-4' ) ):
			?>
				<div id="footer-widgets" class="clearfix">
					<div class="container">
						<div class="row">
							<?php
								$footer_sidebars = array( 'footer-1', 'footer-2', 'footer-3', 'footer-4' );
								foreach ( $footer_sidebars as $key => $footer_sidebar ) :
									if ( is_active_sidebar( $footer_sidebar ) && $key+1 <= $col_vis ) :
										echo '<div class="'.$fclass.' footer-widget ' . ( 3 === $key ? ' last' : '' ) . ' wow fadeIn" >';
										dynamic_sidebar( $footer_sidebar );
										echo '</div> ';
									endif;
								endforeach;
							?>
						</div>
					</div> <!-- #footer-widgets -->
				</div>	<!-- .container -->
			<?php endif; ?>
			
			<?php
				if (get_toption('show_copyright') == 1 && get_toption('copyright_text') != ''):
			?>
				<div id="copyright">
					<div class="container">
						<div class="row">
							<div class="col-xs-12 col-sm-6 text-right hidden-xs pull-right">
								<div>
									<img src="<?=THEME_URL_ASSETS?>/images/payment-logos.png" style="float: right;width: auto;height: 25px;">
								</div>
							</div>
							<div class="col-xs-12 col-sm-6">
								<div class="copyright text-left wow fadeIn" data-wow-duration="1s"> 
									<?php 
										the_toption('copyright_text');
									?>	
								</div>
							</div>
						</div>
					</div> 
				</div>
			<?php endif; ?>
		</footer>
		
		<div id="wrap-back-to-top" class="show"> 
		    <i class="fa fa-chevron-up" aria-hidden="true"></i> 
		</div>

		<div class="fhotline">
	      <a class="call-me" href="tel:<?=get_toption('site_phone');?>">
	         <i class="fa fa-phone faa-wrench animated " aria-hidden="true"></i>
	      </a>
	      <div class="hotline-no">
	         <a href="tel:<?=get_toption('site_phone');?>"><?=get_toption('site_phone');?></a>
	         <span>GỌI ĐỂ NHẬN TƯ VẤN MIỄN PHÍ</span>
	      </div>
	   </div>
	   	

	  
		<!-- <script defer="defer" async src="https://connect.facebook.net/en_US/all.js#xfbml=1"></script>
		<script defer="defer" async type="text/javascript" src="https://apis.google.com/js/plusone.js"></script> -->


		<?php wp_footer(); ?>
		
	</body>
</html>