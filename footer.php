<?php
/**
 * The template for displaying the footer.
 *
 * Contains the closing of the #content div and all content after.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package Tokheim_grafisk
 */

?>

	</div><!-- #content -->

	<?php // if(!is_front_page()) { ?>
	<div id="footer_margin_top"></div>
	<footer id="colophon" class="site_footer" role="contentinfo">
		<div class="content_section">
			<div class="site-info">
				<span style="">- Erling Tokheim -</span>
				<br>
				<span style="font-size: .65em; opacity: .5; margin-top: -5px; display: block;">erling@tokheim.no</span>
			</div><!-- .site-info -->
		</div>
	</footer><!-- #colophon -->
	<?php // } ?>

</div><!-- #page -->

<?php wp_footer(); ?>

</body>
</html>