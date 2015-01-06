<!doctype html>

  <html class="no-js"  <?php language_attributes(); ?>>

	<head>
		<meta charset="utf-8">

		<!-- Force IE to use the latest rendering engine available -->
		<meta http-equiv="X-UA-Compatible" content="IE=edge">

		<title><?php //Page Title
			if(is_front_page()) { bloginfo('name'); echo ' - '; bloginfo('description'); }
			else { bloginfo('name'); wp_title('-', true,'left'); }
		?></title>


		<!-- Mobile Meta -->
		<meta name="HandheldFriendly" content="True">
		<meta name="MobileOptimized" content="width">
		<meta name="viewport" content="width=device-width, initial-scale=1.0"/>

		<!-- favicons -->
		<link rel="shortcut icon"                                   href="<?php echo get_template_directory_uri(); ?>/favicon.ico">
		<link rel="icon"                  sizes="16x16 32x32 64x64" href="<?php echo get_template_directory_uri(); ?>/favicon.ico">
		<link rel="icon" type="image/png" sizes="196x196"           href="<?php echo get_template_directory_uri(); ?>/library/images/favicons/favicon-196.png">
		<link rel="icon" type="image/png" sizes="160x160"           href="<?php echo get_template_directory_uri(); ?>/library/images/favicons/favicon-160.png">
		<link rel="icon" type="image/png" sizes="96x96"             href="<?php echo get_template_directory_uri(); ?>/library/images/favicons/favicon-96.png">
		<link rel="icon" type="image/png" sizes="64x64"             href="<?php echo get_template_directory_uri(); ?>/library/images/favicons/favicon-64.png">
		<link rel="icon" type="image/png" sizes="32x32"             href="<?php echo get_template_directory_uri(); ?>/library/images/favicons/favicon-32.png">
		<link rel="icon" type="image/png" sizes="16x16"             href="<?php echo get_template_directory_uri(); ?>/library/images/favicons/favicon-16.png">
		<link rel="apple-touch-icon"      sizes="152x152"           href="<?php echo get_template_directory_uri(); ?>/library/images/favicons/favicon-152.png">
		<link rel="apple-touch-icon"      sizes="144x144"           href="<?php echo get_template_directory_uri(); ?>/library/images/favicons/favicon-144.png">
		<link rel="apple-touch-icon"      sizes="120x120"           href="<?php echo get_template_directory_uri(); ?>/library/images/favicons/favicon-120.png">
		<link rel="apple-touch-icon"      sizes="114x114"           href="<?php echo get_template_directory_uri(); ?>/library/images/favicons/favicon-114.png">
		<link rel="apple-touch-icon"      sizes="76x76"             href="<?php echo get_template_directory_uri(); ?>/library/images/favicons/favicon-76.png">
		<link rel="apple-touch-icon"      sizes="72x72"             href="<?php echo get_template_directory_uri(); ?>/library/images/favicons/favicon-72.png">
		<link rel="apple-touch-icon"                                href="<?php echo get_template_directory_uri(); ?>/library/images/favicons/favicon-57.png">
		<meta name="msapplication-TileColor" content="#152348">
		<meta name="msapplication-TileImage"                     content="<?php echo get_template_directory_uri(); ?>/library/images/favicons/favicon-144.png">
		<meta name="msapplication-config" content="<?php echo get_template_directory_uri(); ?>/library/images/favicons/browserconfig.xml">
		<!--[if IE]>
			<link rel="shortcut icon" href="<?php echo get_template_directory_uri(); ?>/favicon.ico">
		<![endif]-->

		<meta name="theme-color" content="#152348">

		<link rel="pingback" href="<?php bloginfo('pingback_url'); ?>">

		<?php wp_head(); ?>

		<!-- Drop Google Analytics here -->
		<!-- end analytics -->

	</head>

	<body <?php body_class(); ?>>
		<div class="off-canvas-wrap" data-offcanvas>
			<div class="inner-wrap">
				<div id="container">
					<header class="header" role="banner">

						 <!-- This navs will be applied to the topbar, above all content
							  To see additional nav styles, visit the /partials directory -->
						 <?php get_template_part( 'partials/nav', 'top-offcanvas' ); ?>

						<div id="inner-header" class="row">
							<div class="large-12 medium-12 columns">
								<h1>
									<a href="<?php echo home_url(); ?>" rel="nofollow">
										<?php bloginfo('name'); ?>
									</a>
									<small>
										<?php  bloginfo('description'); ?>
									</small>
								</h1>
							</div>

							 <!-- This navs will be applied to the main, under the logo
								  To see additional nav styles, visit the /partials directory -->

							 <?php // get_template_part( 'partials/nav', 'main-offcanvas' ); ?>

						</div> <!-- end #inner-header -->
					</header> <!-- end .header -->