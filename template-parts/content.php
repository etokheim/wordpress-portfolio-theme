<?php
/**
 * Template part for displaying posts.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package Tokheim_grafisk
 */

?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

	<header>
		<div id="intro_container">
			<div id="intro" data-stellar-ratio="0.4">
			<?php $attribute = "$(window).ready(function() { thisPageTransition() });"; ?>
				<div class='intro_image'><?php the_post_thumbnail('full', array('onload'=>$attribute)); ?></div>

				<div class="intro_dimmer"></div>

				<div id="intro_txt">
					<h1><?php the_title(); ?></h1>
					<p class="entry_excerpt">
						<?php echo get_the_excerpt(); ?>
					</p>
				</div>
			</div>
		</div>
	</header>

	<?php
		$post_content = get_the_content( sprintf(
			/* translators: %s: Name of current post. */
			wp_kses( __( 'Continue reading %s <span class="meta-nav">&rarr;</span>', 't_fisk' ), array( 'span' => array( 'class' => array() ) ) ),
			the_title( '<span class="screen-reader-text">"', '"</span>', false )
		) );

		// Separates the sections in $post_content into the $post_splitted array.
		// Each section is separated by an <hr /> tag by the editor.
		$post_splitted = explode("<hr />", $post_content);

		// Echoes out each section within a section and a div.
		// Apply_filters gives the raw data the same formatting as the original content.
		// Otherwise you would see [caption width="xxx"] etc echoed out.
		for($i = 0; $i < count($post_splitted); $i++) {
			if(strlen($post_splitted[$i]) > 2) {
				echo '
				<section class="post_content filled">
					<div class="contain post_padding">
						' . apply_filters("the_content", $post_splitted[$i])/* Formats with wp's formatting, ie.: [caption] becomes an HTML caption */ . '
					</div>
				</section>';
			}
		}


		wp_link_pages( array(
			'before' => '<div class="page-links">' . esc_html__( 'Pages:', 't_fisk' ),
			'after'  => '</div>',
		) );
	?>

	<!-- <footer class="entry_footer">
		<div class="content_section_small">
			<?php //t_fisk_entry_footer(); //echoes: "Posted in FeaturedEdit" ?>
		</div>
	</footer><!-- .entry_footer -->
</article><!-- #post-## -->