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

echo '<aside class="module11-single-sidebar" aria-label="Bài viết mới nhất">';

$module11_detail_posts = new WP_Query(
	array(
		'post_type'           => 'post',
		'post_status'         => 'publish',
		'posts_per_page'      => 6,
		'ignore_sticky_posts' => true,
		'orderby'             => 'date',
		'order'               => 'DESC',
	)
);

if ( $module11_detail_posts->have_posts() ) {
	echo '<section class="module11-home-archive" aria-labelledby="module11-detail-latest-title"><h2 id="module11-detail-latest-title">Bài viết mới nhất</h2><ul class="module11-timeline">';
	while ( $module11_detail_posts->have_posts() ) {
		$module11_detail_posts->the_post();
		$module11_excerpt = get_the_excerpt();
		if ( empty( $module11_excerpt ) ) {
			$module11_excerpt = get_the_content();
		}
		echo '<li class="module11-timeline-item"><div class="module11-timeline-header">';
		echo '<a class="module11-timeline-title" href="' . esc_url( get_permalink() ) . '">' . esc_html( get_the_title() ) . '</a>';
		echo '<span class="module11-timeline-date">' . esc_html( get_the_date( 'd/m/Y' ) ) . '</span></div>';
		echo '<p class="module11-timeline-excerpt">' . esc_html( wp_trim_words( wp_strip_all_tags( $module11_excerpt ), 12, '...' ) ) . '</p></li>';
	}
	echo '</ul></section>';
} else {
	echo '<section class="module11-home-archive"><h2>Bài viết mới nhất</h2><p>Chưa có bài viết.</p></section>';
}
wp_reset_postdata();

echo '</aside><main class="module11-single-content">';

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
