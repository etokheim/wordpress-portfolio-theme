<?php
/**
 * Template part for displaying posts.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package Tokheim_grafisk
 */

?>

<script type="text/javascript">
	setup.onLoadHook.push(toc.create);
</script>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<header <?php if(has_post_thumbnail()) {echo "class='entry_header'";} else {echo "class='entry_header no_header_image'";} ?>>
		<?php $size = "full"; ?>
		<?php
		// If Featured image, echo it with the title on top of the picture.
		if(has_post_thumbnail()) { ?>
			<div id="content_header_wrapper">
				<div id="content_featured_image" style="background-image: url('<?php echo wp_get_attachment_image_src(get_post_thumbnail_id($post->ID), 'full' )[0]; ?>')">
					<div class="entry_heading_container" data-stellar-ratio="1.5" data-stellar-vertical-offset="90">
						<div class="entry_heading_wrapper">
							<?php the_title( '<h1 class="entry_title">', '</h1>' ); ?>
							<p class="entry_excerpt">
								<?php echo get_the_excerpt(); ?>
							</p>
						</div>
					</div>
				</div>
			</div>
		<?php } else {?>
					<div class="entry_heading_container" data-stellar-ratio=".5" data-stellar-vertical-offset="0">
						<div class="entry_heading_wrapper">
							<?php the_title( '<h1 class="entry_title">', '</h1>' ); ?>
							<p class="entry_excerpt">
								<?php echo get_the_excerpt(); ?>
							</p>
						</div>
					</div>
			<?php } ?>
	</header><!-- .entry_header -->

	<div class="entry_content_wrapper">
		<div class="entry_content">
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
						<div class="whitespace_separator"></div>
						<section class="content_section_wrapper">
							<div class="content_section content_section_padding">
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
		</div><!-- .entry_content -->

	<footer class="entry_footer">
		<div class="content_section_small">
			<?php // t_fisk_entry_footer(); echoes: "Posted in FeaturedEdit" ?>
		</div>
	</footer><!-- .entry_footer -->
	</div><!-- .entry_content_wrapper -->
</article><!-- #post-## -->