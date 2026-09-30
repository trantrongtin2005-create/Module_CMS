<?php
/**
 * The template for displaying all single posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
 *
 * @package WordPress
 * @subpackage Twenty_Twenty_One
 * @since Twenty Twenty-One 1.0
 */

wp_enqueue_style( 'module11-home', get_stylesheet_directory_uri() . '/module11.css', array(), '1.2.0' );

get_header();

echo '<div class="module11-single-layout">';

echo '<aside class="module9-single-sidebar">';
get_template_part( 'template-parts/sidebar/categories' );
echo '</aside>';

echo '<main class="module11-single-content">';

/* Start the Loop */
while ( have_posts() ) :
	the_post();

	get_template_part( 'template-parts/content/content-single' );

	// Section 7: Next Post navigation
	get_template_part( 'template-parts/post/navigation' );

	if ( is_attachment() ) {
		// Parent post navigation.
		the_post_navigation(
			array(
				/* translators: %s: Parent post link. */
				'prev_text' => sprintf( __( '<span class="meta-nav">Published in</span><span class="post-title">%s</span>', 'twentytwentyone' ), '%title' ),
			)
		);
	}

	// If comments are open or there is at least one comment, load up the comment template.
	if ( comments_open() || get_comments_number() ) {
		comments_template();
	}
endwhile; // End of the loop.

echo '</main></div>';

get_footer();
