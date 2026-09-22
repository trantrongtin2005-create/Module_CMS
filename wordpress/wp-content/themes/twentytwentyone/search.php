<?php
/**
 * The template for displaying search results pages
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#search-result
 *
 * @package WordPress
 * @subpackage Twenty_Twenty_One
 * @since Twenty Twenty-One 1.0
 */

get_header();

if ( have_posts() ) {
	?>
	<div class="gc-search-banner default-max-width">
		<h1 class="gc-search-banner-title">
			<?php
			printf(
				/* translators: %s: Search term. */
				esc_html__( 'Kết quả tìm kiếm cho: "%s"', 'twentytwentyone' ),
				'<span class="gc-search-keyword">' . esc_html( get_search_query( false ) ) . '</span>'
			);
			?>
		</h1>
		<div class="gc-search-banner-meta">
			<?php
			printf(
				esc_html(
					_n(
						'Tìm thấy %d kết quả phù hợp',
						'Tìm thấy %d kết quả phù hợp',
						(int) $wp_query->found_posts,
						'twentytwentyone'
					)
				),
				(int) $wp_query->found_posts
			);
			?>
		</div>
	</div><!-- .gc-search-banner -->

	<div class="gc-posts-grid default-max-width">
		<?php
		// Start the Loop.
		while ( have_posts() ) {
			the_post();

			get_template_part( 'template-parts/content/content-excerpt', get_post_format() );
		} // End the loop.
		?>
	</div><!-- .gc-posts-grid -->

	<?php
	// Previous/next page navigation.
	twenty_twenty_one_the_posts_navigation();

} else {
	get_template_part( 'template-parts/content/content-none' );
}

get_footer();

