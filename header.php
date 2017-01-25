<?php
/**
 * The header for our theme.
 *
 * This is the template that displays all of the <head> section and everything up until <div id="content">
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package Tokheim_grafisk
 */

?><!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
	<?php wp_head(); ?>

	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<link rel="profile" href="http://gmpg.org/xfn/11">
	<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">

	<link rel="icon" type="image/png" href="img/ikon/favicon.png">
	<meta name="viewport" content="width=device-width,  maximum-scale=2.0, minimum-scale=1.0, initial-scale=1.0" />

	<!-- Stylesheets -->
	<link rel="stylesheet" type="text/css" href="<?php echo get_template_directory_uri(); ?>/css/bootstrap.css" />

	<link rel="stylesheet" media='screen and (min-width: 701px) and (max-width: 900px)' type="text/css" href="<?php echo get_template_directory_uri(); ?>/css/style_medium.css" />
	<link rel="stylesheet" media='screen and (max-width: 700px)' type="text/css" href="<?php echo get_template_directory_uri(); ?>/css/style_small.css" />



	<!-- PLUG-INS -->
	<script type="text/javascript" src="<?php bloginfo('template_directory'); ?>/plug-ins/jquery/jquery.min.js"></script>
	<script type="text/javascript" src="<?php bloginfo('template_directory'); ?>/plug-ins/jquery/jquery-ui.min.js"></script>
	<script src="<?php bloginfo('template_directory'); ?>/plug-ins/stellar/jquery.stellar.min.js"></script>

	<!-- Fonts from typekit: -->
	<script src="https://use.typekit.net/sxe3quh.js"></script>
	<script>try{Typekit.load({ async: true });}catch(e){}</script>

	<!-- Javascript files: -->
	<script type="text/javascript" src="<?php bloginfo('template_directory'); ?>/js/javascript.js"></script>
	<?php if(is_front_page()) { ?><script type='text/javascript' src='<?php bloginfo('template_directory'); echo "/js/javascript-front-page.js"; ?>'></script> <?php } ?>
	<!-- <test> -->
	<!-- MIDLERTIDIG! -->
	<link href='https://fonts.googleapis.com/css?family=Libre+Baskerville:400,400italic' rel='stylesheet' type='text/css'>


	<!-- REFRESHES PAGE EVERY x SECONDS -->
	<!-- <meta http-equiv="refresh" content="3"> -->
</head>

<!-- Google analytics -->
<script>
	if(!setup.debugging) {
		(function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
		(i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
		m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
		})(window,document,'script','https://www.google-analytics.com/analytics.js','ga');

		ga('create', 'UA-81638914-1', 'auto');
		ga('send', 'pageview');
	}
</script>

<body <?php body_class(); ?>>
<script>
<?php
	if( is_admin_bar_showing() ) {
		echo "
			$(document).ready(function() {
				// document.body.style.paddingTop = $('#wpadminbar').height() + 'px';
				document.getElementById('header').style.marginTop = $('#wpadminbar').height() + 'px';
			});";
	};
?>
</script>
<!-- <div class="this_page_transition"></div> -->
<!-- <div class="next_page_transition"></div> -->
<div id="page">
	<a class="skip-link screen-reader-text" href="#main"><?php esc_html_e( 'Skip to content', 't_fisk' ); ?></a>

	<div id="menu_container" class="menu_container">
		<h3>Meny:</h3>
		<br/>
		<nav id="navMenu" class="navMenu">
			<?php
				$args = array(
					"theme_location" => "primarymenu",
				);

				wp_nav_menu($args);
			?>
		</nav>
	</div>


	<header id="header" class="frame_container">
		<div class="frame_topbot_hidden align_pos_top frame">
			<div class="header_section_width">
				<a href="<?php echo home_url(); ?>"><div id="header_logo_container"><?php //bloginfo("name"); ?><img height="13" width="150" itemprop="logo" alt="cropped-logo-3.png" class="custom-logo" src="<?php echo get_template_directory_uri() . "/img/logo-black.svg"; ?>"><?php // the_custom_logo(); ?></div></a>

				<div id="header_social_container">
					<a href="https://no.linkedin.com/in/erling-tokheim-a78194121" target="_blank"><div class="header_social" style="background-image: url('<?php bloginfo('template_directory'); ?>/img/logo-linkedin-black.svg')"></div></a>
					<a href="https://500px.com/etokheim" target="_blank"><div class="header_social" style="background-image: url('<?php bloginfo('template_directory'); ?>/img/logo-500px-black.svg')"></div></a>
				</div>
			</div>
		</div>
		<div class="header_section_width">
			<a href="<?php echo home_url(); ?>"><div id="header_logo_container"><?php //bloginfo("name"); ?><img height="13" width="150" itemprop="logo" alt="cropped-logo-3.png" class="custom-logo" src="<?php echo get_template_directory_uri() . "/img/logo-white.svg"; ?>"></div></a>

			<div id="header_social_container">
				<a href="https://no.linkedin.com/in/erling-tokheim-a78194121" target="_blank"><div class="header_social" style="background-image: url('<?php bloginfo('template_directory'); ?>/img/logo-linkedin-white.svg')"></div></a>
				<a href="https://500px.com/etokheim" target="_blank"><div class="header_social" style="background-image: url('<?php bloginfo('template_directory'); ?>/img/logo-500px-white.svg')"></div></a>
			</div>
		</div>
		<div class="header_gradient"></div>
	</header>

	<!-- White boxes to simluate a frame -->
	<div id="left_box_margin" class="frame_container align_pos_left">
		<div class="frame_lefrig_hidden frame">
			<div id="menuButton" onclick="expandMenu()">
				<div class="menuButton_lines"></div>
				<div class="menuButton_lines"></div>
				<div class="menuButton_lines"></div>
			</div>
		</div>
	</div>
	<div id="right_box_margin" class="frame_container">
		<div class="frame_lefrig_hidden align_pos_right frame">
			<div id="toc_container">

			</div>
		</div>
	</div>
	<div id="bottom_box_margin" class="frame_container">
		<div class="frame_topbot_hidden align_pos_bottom frame"></div>
	</div>