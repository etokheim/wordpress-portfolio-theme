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


	<?php // if(!is_front_page()) { ?>
	<div class="whitespace_separator"></div>
	<footer class="site_footer" role="contentinfo">
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

<!-- PLUG-INS -->
<script type="text/javascript" src="<?php bloginfo('template_directory'); ?>/plug-ins/jquery/jquery-ui.min.js"></script>
<script src="<?php bloginfo('template_directory'); ?>/plug-ins/stellar/jquery.stellar.min.js"></script>
<script src="<?php bloginfo('template_directory'); ?>/plug-ins/knockout/knockout-latest.js"></script>

<!-- Fonts from typekit: -->
<script src="https://use.typekit.net/sxe3quh.js"></script>
<script>try{Typekit.load({ async: true });}catch(e){}</script>

<!-- Javascript files: -->
<script type="text/javascript" src="<?php bloginfo('template_directory'); ?>/js/javascript.js"></script>
<?php if(is_front_page()) { ?><script type='text/javascript' src='<?php bloginfo('template_directory'); echo "/js/javascript-front-page.js"; ?>'></script> <?php } ?>
<!-- <test> -->

<?php wp_footer(); ?>

</body>
</html>