<?php
	if ( ! is_active_sidebar( 'sidebar-2' ) && ! is_active_sidebar( 'sidebar-3' ) && ! is_active_sidebar( 'sidebar-4' ) && ! is_active_sidebar( 'sidebar-5' ) )
		return;
?>

<div class="container">
	<div id="footer-widgets" class="clearfix">
		<div class="row_fl">
			<div class="col-xs-12 col-sm-6 col-md-4">
				<?php 
					if ( is_active_sidebar('sidebar-2' ) ) :
						echo '<div class="footer-widget">';
						dynamic_sidebar('sidebar-2' );
						echo '</div> ';
					endif;
				?>
			</div>
			<div class="col-xs-12 col-sm-6 col-md-offset-1 col-md-2">
				<?php 
					if ( is_active_sidebar('sidebar-3') ) :
						echo '<div class="footer-widget">';
						dynamic_sidebar('sidebar-3');
						echo '</div> ';
					endif;
				?>
			</div>
			<div class="col-xs-12 col-sm-6 col-md-2">
				<?php 
					if ( is_active_sidebar( 'sidebar-4' ) ) :
						echo '<div class="footer-widget">';
						dynamic_sidebar( 'sidebar-4' );
						echo '</div> ';
					endif;
				?>
			</div>
			<div class="col-xs-12 col-sm-6 col-md-3 last">
				<?php 
					if ( is_active_sidebar('sidebar-5') ) :
						echo '<div class="footer-widget">';
						dynamic_sidebar('sidebar-5' );
						echo '</div> ';
					endif;
				?>
			</div>
		</div>
	</div> <!-- #footer-widgets -->
</div>	<!-- .container -->