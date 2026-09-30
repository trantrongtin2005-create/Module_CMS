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

global $wp_query;

wp_enqueue_style( 'module11-home', get_stylesheet_directory_uri() . '/module11.css', array(), '1.3.0' );

get_header();

$module11_search_latest_posts = new WP_Query(
	array(
		'post_type'           => 'post',
		'post_status'         => 'publish',
		'posts_per_page'      => 6,
		'ignore_sticky_posts' => true,
		'orderby'             => 'date',
		'order'               => 'DESC',
	)
);
?>

<div class="module11-search-layout">
	<aside class="module11-search-sidebar" aria-labelledby="module11-search-latest-title">
		<section class="module11-home-archive">
			<h2 id="module11-search-latest-title">Bài viết mới nhất</h2>
			<?php if ( $module11_search_latest_posts->have_posts() ) : ?>
				<ul class="module11-timeline">
					<?php while ( $module11_search_latest_posts->have_posts() ) : $module11_search_latest_posts->the_post(); ?>
						<?php
						$module11_excerpt = get_the_excerpt();
						if ( empty( $module11_excerpt ) ) {
							$module11_excerpt = get_the_content();
						}
						?>
						<li class="module11-timeline-item">
							<div class="module11-timeline-header">
								<a class="module11-timeline-title" href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
								<span class="module11-timeline-date"><?php echo esc_html( get_the_date( 'd/m/Y' ) ); ?></span>
							</div>
							<p class="module11-timeline-excerpt"><?php echo esc_html( wp_trim_words( wp_strip_all_tags( $module11_excerpt ), 12, '...' ) ); ?></p>
						</li>
					<?php endwhile; ?>
				</ul>
			<?php else : ?>
				<p>Chưa có bài viết.</p>
			<?php endif; ?>
		</section>
	</aside>
	<?php wp_reset_postdata(); ?>

	<div class="module11-search-results">
		<?php if ( have_posts() ) : ?>
			<header class="page-header alignwide">
				<h1 class="page-title custom-search-title">
					<span class="search-label"><?php esc_html_e( 'Search:', 'twentytwentyone' ); ?></span> <span class="search-term">&ldquo;<?php echo esc_html( get_search_query( false ) ); ?>&rdquo;</span>
				</h1>
			</header><!-- .page-header -->

			<div class="search-result-count default-max-width">
				<?php
				printf(
					esc_html(
						/* translators: %d: The number of search results. */
						_n(
							'We found %d result for your search.',
							'We found %d results for your search.',
							(int) $wp_query->found_posts,
							'twentytwentyone'
						)
					),
					(int) $wp_query->found_posts
				);
				?>
			</div><!-- .search-result-count -->

			<?php
			while ( have_posts() ) {
				the_post();
				get_template_part( 'template-parts/content/content-excerpt', get_post_format() );
			}

			twenty_twenty_one_the_posts_navigation();
		else :
			get_template_part( 'template-parts/content/content-none' );
		endif;
		?>
	</div>
</div>

<?php
get_footer();
