<?php 
/*
Template Name: Test template
*/
get_header();



// echo "The post thumbnail id = " . $test;
?>
<?php if ( have_posts() ) :

	/* Start the Loop */
	while ( have_posts() ) : the_post();
?>

	
<div style='width: 100%; height: 400px; background-color: #eee; background-size: cover; background-repeat: no-repeat;<?php if(wp_get_attachment_image_src(get_post_thumbnail_id($post->ID), 'full' )[0]) {echo "background-image: url(" . '"' . wp_get_attachment_image_src(get_post_thumbnail_id($post->ID), 'full' )[0] . '");'; } ?>'></div>


<!-- <p>This is the test template. Made from page-test-template.php</p> -->
<?php the_title(); ?>
<?php if(the_content()) {the_content();} else {echo "red, no content";}; ?>
<?php the_post_thumbnail(); ?>

<?php
	endwhile;
	endif;
?>


<?php get_footer(); ?>