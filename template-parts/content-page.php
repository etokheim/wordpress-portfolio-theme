<?php
/**
 * Template part for displaying page content in page.php.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package Tokheim_grafisk
 */

?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<header class="entry-header">
		<?php $size = "full"; ?>
		<?php
		// If Featured image, echo it with the title on top of the picture.
		if(has_post_thumbnail()) { ?>
			<div id="content_featured_image" style="background-image: url('<?php echo wp_get_attachment_image_src(get_post_thumbnail_id($post->ID), 'full' )[0]; ?>')">
				<div class="entry_heading_container">
					<div class="entry_heading_wrapper">
						<?php the_title( '<h1 class="entry_title">', '</h1>' ); ?>
						<p class="entry_excerpt">
							<?php echo get_the_excerpt(); ?>
						</p>
					</div>
				</div>
			</div>
		<?php } else {
			// if no featured image, echo just the title.
			the_title( '<h1 class="entry_title">', '</h1>' );
			} ?>
	</header><!-- .entry-header -->

	<div class="entry-content">
		<?php
			the_content();

			wp_link_pages( array(
				'before' => '<div class="page-links">' . esc_html__( 'Pages:', 't_fisk' ),
				'after'  => '</div>',
			) );
		?>
	</div><!-- .entry-content -->

	<footer class="entry-footer">
		<?php
			edit_post_link(
				sprintf(
					/* translators: %s: Name of current post */
					esc_html__( 'Edit %s', 't_fisk' ),
					the_title( '<span class="screen-reader-text">"', '"</span>', false )
				),
				'<span class="edit-link">',
				'</span>'
			);
		?>
	</footer><!-- .entry-footer -->
</article><!-- #post-## -->
