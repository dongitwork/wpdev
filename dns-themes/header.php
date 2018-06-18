<?php
/**
 * The Theme Header
 * @author DongNam Solutions
 * @package dns-themes
 */
?>

<!DOCTYPE html>
<!--[if lt IE 7]>  <html class="no-js lt-ie9 lt-ie8 lt-ie7" <?php language_attributes(); ?>> <![endif]-->
<!--[if IE 7]>     <html class="no-js lt-ie9 lt-ie8" <?php language_attributes(); ?>> <![endif]-->
<!--[if IE 8]>     <html class="no-js lt-ie9" <?php language_attributes(); ?>> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js" <?php language_attributes(); ?>> <!--<![endif]-->
<head>
	<meta charset="<?php bloginfo('charset'); ?>">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="profile" href="http://gmpg.org/xfn/11">
	<meta name="format-detection" content="telephone=no">
	<link rel="pingback" href="<?php bloginfo('pingback_url'); ?>">
	<link rel="shortcut icon" href="<?php the_toption('favicon','image'); ?>" type="image/x-icon">
	<link rel="icon" href="<?php the_toption('favicon','image'); ?>" type="image/x-icon">
	<link rel="alternate" href="<?php echo esc_url(home_url('/')); ?>" hreflang="vi-vn" />
	<!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
  	<!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
      <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
  <![endif]-->
  <?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
<!-- Load Facebook SDK for JavaScript -->
<div id="fb-root"></div>
<script>(function(d, s, id) {
  var js, fjs = d.getElementsByTagName(s)[0];
  if (d.getElementById(id)) return;
  js = d.createElement(s); js.id = id;
  js.src = 'https://connect.facebook.net/vi_VN/sdk/xfbml.customerchat.js#xfbml=1&version=v2.12&autoLogAppEvents=1';
  fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));</script>

<!-- Your customer chat code -->
<div class="fb-customerchat"
  attribution="setup_tool"
  page_id="160909970755380"
  theme_color="#0084ff"
  logged_in_greeting="Chào chị! Để DEPO tư vấn cho Chị mẫu đầm phù hợp nhất nhé!"
  logged_out_greeting="Chào chị! Để DEPO tư vấn cho Chị mẫu đầm phù hợp nhất nhé!">
</div>

	<?php do_action('before'); ?> 
	<?php
	//if (get_toption('header_top') == 1 && get_toption('header_top_content') != ''):
	?>
		<div id="header-top" class="pl_header_top hidden-xs">
			<div class="container">
				<div class="row">
					<div class="col-xs-12 col-sm-6">
						<?php 
							the_toption('header_top_content');
						?>
					</div>
					<div class="col-xs-12 col-sm-12 text-right">
						<?php 
							flex_menu('topbar','topbar-menu','topbar-menu nav navbar-nav');
						?>
					</div>
				</div>	
			</div>
		</div>
	<?php //endif; ?>
	<header id="header" role="header">
		<div class="container">
			<div class="row flex-center">
				<div class="col-md-3 col-sm-2 col-xs-4 left_header_bg">
					<div class="header-logo">
						<?php 
						if (get_toption('logo-on')== 1 && !empty(get_toption('logo-image'))):
							?>
							<a href="<?php echo esc_url(home_url('/')); ?>" title="<?php echo esc_attr(get_bloginfo('name', 'display')); ?>" rel="home">
								<?php 
									if (is_front_page()) {
										$logo = get_toption('logo-image');
										$url_logo = $logo['url'];
									}else{
										$logo = get_toption('logo-image');
										$url_logo = $logo['url'];
									}
								?>
								<img class="pl-logo img-responsive" src="<?=$url_logo?>">
							</a>
						<?php else: ?>
							<h1 class="site-title-heading">
								<a href="<?php echo esc_url(home_url('/')); ?>" title="<?php echo esc_attr(get_bloginfo('name', 'display')); ?>" rel="home"><?php bloginfo('name'); ?></a>
							</h1>
							<div class="site-description">
								<small>
									<?php bloginfo('description'); ?> 
								</small>
							</div>
							<?php 
						endif;
						?>
					</div>
				</div>
				<div class="col-md-5 hidden-xs hidden-sm">
					<form id="searchform" action="<?php echo esc_url( home_url( '/' ) ); ?>" method="get" class="searchform" role="search">
					    <fieldset>
					    	<input name="s" id="s" value="" placeholder="Bạn cần tìm gì?" type="text" class="frm-text" >
					    	<button class="btn-submit" title="Search" type="submit">
					    		<i class="fa fa-search"></i>
					    	</button>
					    </fieldset>
					    <input name="post_type" value="product" type="hidden">
					</form>
				</div>
				<div class="col-md-4 col-sm-10 col-xs-8">
					<div class="header-right ">
						<div class="header_info hidden-xs">
							<?php dynamic_sidebar('header'); ?>
						</div>
						<div class="navbar-header visible-xs">
							<div class="mobile-search"> 
									<div class="wrapper-mobile-search hide"> 

								 	</div> 
								 	<i class="fa fa-search" aria-hidden="true"></i> 
								 	<span>Search</span> 
							</div>

							<div class="mcart_iterms">
								<a  href="<?php echo wc_get_cart_url(); ?>" title="<?php _e( 'Xem sản phẩm trong giỏ hàng' ); ?>">
									<span class="fa fa-shopping-cart"></span>
									<span class="iterm">
										<?=WC()->cart->get_cart_contents_count(); ?>
									</span>
								</a>
							</div>
							<span class="navbar-toggle" >
								<span class="icon-bar"></span>
								<span class="icon-bar"></span>
								<span class="icon-bar"></span>
								<span class="mtitle">Menu</span>
							</span>
						</div>
						
					</div>
				</div>
			</div>
			<div class="searh_mobile" style="display: none;">
				<form id="searchform" action="<?php echo esc_url( home_url( '/' ) ); ?>" method="get" class="searchform" role="search">
					    <fieldset>
					    	<input name="s" id="s" value="" placeholder="Bạn cần tìm gì?" type="text" class="frm-text" >
					    	<button class="btn-submit" title="Search" type="submit">
					    		<i class="fa fa-search"></i>
					    	</button>
					    </fieldset>
					    <input name="post_type" value="product" type="hidden">
					</form>
			</div>
		</div>
	</header>
	<div id="navbar" class="navbar  collapse navbar-collapse">
		<div class="container">
			<div class="row">
				<div class="col-sm-12 col-xs-12">
					<nav  class="menu-top t navbar-wp" role="navigation">
						<?php 
							flex_menu('primary','','main-menu nav navbar-nav');
							dynamic_sidebar('navbar'); 
						?> 
					</nav>
				</div>
			</div>
		</div>
	</div>	

