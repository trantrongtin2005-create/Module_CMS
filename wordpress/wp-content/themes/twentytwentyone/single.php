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

echo '<div class="module11-single-layout"><main class="module11-single-content">';

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

echo '</main><aside class="module11-single-sidebar" aria-label="Recent posts">';
$module11_detail_posts = new WP_Query(
	array(
		'post_type'           => 'post',
		'post_status'         => 'publish',
		'posts_per_page'      => 3,
		'ignore_sticky_posts' => true,
		'orderby'             => 'date',
		'order'               => 'DESC',
	)
);

if ( $module11_detail_posts->have_posts() ) {
	echo '<section class="module11-detail-news"><div class="module11-detail-news-list">';
	while ( $module11_detail_posts->have_posts() ) {
		$module11_detail_posts->the_post();
		echo '<article class="module11-detail-news-item">';
		echo '<time datetime="' . esc_attr( get_the_date( 'c' ) ) . '"><strong>' . esc_html( get_the_date( 'd' ) ) . '</strong><span>' . esc_html( get_the_date( 'm' ) ) . '</span><small>' . esc_html( get_the_date( 'y' ) ) . '</small></time>';
		echo '<a href="' . esc_url( get_permalink() ) . '">' . esc_html( get_the_title() ) . '</a>';
		echo '</article>';
	}
	echo '</div><a class="module11-detail-news-more" href="' . esc_url( home_url( '/' ) ) . '">XEM TẤT CẢ TIN TỨC</a></section>';
}
wp_reset_postdata();
echo '</aside></div>';

get_footer();
