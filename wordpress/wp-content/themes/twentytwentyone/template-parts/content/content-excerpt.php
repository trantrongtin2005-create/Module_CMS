<?php
/**
 * Template part for displaying post archives and search results
 * Custom CMS module layout matching design
 *
 * @package WordPress
 * @subpackage Twenty_Twenty_One
 */

$day   = get_the_date( 'd' );
$month = get_the_date( 'm' );
?>

<article id="post-<?php the_ID(); ?>" <?php post_class( 'cms-news-card' ); ?>>
	<!-- Column 1: Image Container (Always rendered in div structure) -->
	<div class="cms-news-thumb">
		<a href="<?php the_permalink(); ?>">
			<?php if ( has_post_thumbnail() ) : ?>
				<?php the_post_thumbnail( 'medium_large' ); ?>
			<?php else : ?>
				<div class="cms-news-placeholder-box">
					<svg width="40" height="40" viewBox="0 0 24 24" fill="none" stroke="#94a3b8" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
						<rect x="3" y="3" width="18" height="18" rx="2" ry="2"></rect>
						<circle cx="8.5" cy="8.5" r="1.5"></circle>
						<polyline points="21 15 16 10 5 21"></polyline>
					</svg>
				</div>
			<?php endif; ?>
		</a>
	</div>

	<!-- Column 2: Date Box -->
	<div class="cms-news-date">
		<span class="cms-news-day"><?php echo esc_html( $day ); ?></span>
		<span class="cms-news-month">THÁNG <?php echo esc_html( $month ); ?></span>
	</div>

	<!-- Column 3: Post Body (Vertical Line + Title & Excerpt) -->
	<div class="cms-news-body">
		<h2 class="cms-news-title">
			<a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
		</h2>

		<div class="cms-news-excerpt">
			<?php
			$excerpt_text = get_the_excerpt();
			if ( empty( $excerpt_text ) ) {
				$excerpt_text = wp_trim_words( get_the_content(), 40, '' );
			}
			$excerpt_text = preg_replace( '/\s*\[\.\.\.\]\s*$/', '', $excerpt_text );
			echo esc_html( $excerpt_text ) . ' <span class="cms-more-dots">[...]</span>';
			?>
		</div>
	</div>
</article>

