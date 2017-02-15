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
	<meta name="viewport" content="width=device-width, minimum-scale=1.0, initial-scale=1.0" />

	<!-- Stylesheets -->
	<link rel="stylesheet" type="text/css" href="<?php echo get_template_directory_uri(); ?>/css/bootstrap.css" />

	<link rel="stylesheet" media='screen and (max-width: 900px)' type="text/css" href="<?php echo get_template_directory_uri(); ?>/css/style_medium.css" />
	<link rel="stylesheet" media='screen and (max-width: 700px)' type="text/css" href="<?php echo get_template_directory_uri(); ?>/css/style_small.css" />

	<!-- MIDLERTIDIG! -->
	<link href='https://fonts.googleapis.com/css?family=Libre+Baskerville:400,400italic' rel='stylesheet' type='text/css'>

	<!-- PLUG-INS -->
	<script type="text/javascript" src="<?php bloginfo('template_directory'); ?>/plug-ins/jquery/jquery.min.js"></script>


	<!-- REFRESHES PAGE EVERY x SECONDS -->
	<!-- <meta http-equiv="refresh" content="3"> -->
</head>
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
<!-- <div class="this_page_transition">
	<div class="loading_animation">
		<div class="ball_container ball_container_first">
			<div class="loading_ball loading_ball_first"></div>
		</div>
		<div class="ball_container ball_container_second">
			<div class="loading_ball loading_ball_second"></div>
		</div>
		<div class="ball_container  ball_container_third">
			<div class="loading_ball loading_ball_third"></div>
		</div>
	</div>
</div>
<div class="next_page_transition">
	<div class="loading_animation">
		<div class="ball_container ball_container_first">
			<div class="loading_ball loading_ball_first"></div>
		</div>
		<div class="ball_container ball_container_second">
			<div class="loading_ball loading_ball_second"></div>
		</div>
		<div class="ball_container  ball_container_third">
			<div class="loading_ball loading_ball_third"></div>
		</div>
	</div>
</div> -->
<div id="page">
	<a class="skip-link screen-reader-text" href="#main"><?php esc_html_e( 'Skip to content', 't_fisk' ); ?></a>

<!-- 	<div id="menu_container" class="menu_container">
		<h3>Meny:</h3>
		<br/>
		<nav id="navMenu" class="navMenu">
			<?php
				// $args = array(
				// 	"theme_location" => "primarymenu",
				// );

				// wp_nav_menu($args);
			?>
		</nav>
	</div> -->


	<header id="header" class="frame_container">
		<div class="frame_topbot_hidden align_pos_top frame">
			<div class="contain_header">
				<a href="<?php echo home_url(); ?>">
					<?php //bloginfo("name"); ?>
					<img class="header_logo" itemprop="logo" alt="Erling Tokheim" src="<?php echo get_template_directory_uri() . "/img/logo-black.svg"; ?>"><?php // the_custom_logo(); ?>
				</a>

				<div class="header_social_container">
					<a href="https://500px.com/etokheim" target="_blank" title="Besøk 500px-profilen min">
						<img class="header_social" src="<?php bloginfo('template_directory'); ?>/img/logo-500px-black.svg">
					</a>

					<a href="https://github.com/etokheim/" target="_blank" title="Besøk GitHub-profilen min">
						<img class="header_social" src="<?php bloginfo('template_directory'); ?>/img/logo-github-black.svg">
					</a>

					<a href="https://no.linkedin.com/in/erling-tokheim-a78194121" target="_blank" title="Besøk LinkedIn-profilen min">
						<img class="header_social" src="<?php bloginfo('template_directory'); ?>/img/logo-linkedin-black.svg">
					</a>
				</div>
			</div>
		</div>
		<div class="header_gradient"></div>
		<div class="contain_header">
			<a href="<?php echo home_url(); ?>">
				<?php //bloginfo("name"); ?>
				<img class="header_logo" itemprop="logo" alt="Erling Tokheim" src="<?php echo get_template_directory_uri() . "/img/logo-white.svg"; ?>"><?php // the_custom_logo(); ?>
			</a>

			<div class="header_social_container">
				<a href="https://500px.com/etokheim" target="_blank" title="Besøk 500px-profilen min">
					<img class="header_social" src="<?php bloginfo('template_directory'); ?>/img/logo-500px-white.svg">
				</a>

				<a href="https://github.com/etokheim/" target="_blank" title="Besøk GitHub-profilen min">
					<img class="header_social" src="<?php bloginfo('template_directory'); ?>/img/logo-github-white.svg">
				</a>

				<a href="https://no.linkedin.com/in/erling-tokheim-a78194121" target="_blank" title="Besøk LinkedIn-profilen min">
					<img class="header_social" src="<?php bloginfo('template_directory'); ?>/img/logo-linkedin-white.svg">
				</a>
			</div>
		</div>
	</header>

	<!-- White boxes to simluate a frame -->
	<div id="left_box_margin" class="frame_container align_pos_left">
		<!-- <div class="frame_lefrig_hidden frame">
			<div id="menuButton" onclick="expandMenu()">
				<div class="menuButton_lines"></div>
				<div class="menuButton_lines"></div>
				<div class="menuButton_lines"></div>
			</div>
		</div> -->

		<div class="post_navigation">
			<div class="post_navigation_button">
				<div class="post_navigation_preview post_navigation_previous">
					<h1>Portefølje</h1>
					<p>Dette er eit bilete av ei lita portefølje</p>
				</div>
				<img style="transform: rotate(90deg);" class="arrow_medium" src="<?php echo get_template_directory_uri() ?>/img/arrow.svg" alt="">
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