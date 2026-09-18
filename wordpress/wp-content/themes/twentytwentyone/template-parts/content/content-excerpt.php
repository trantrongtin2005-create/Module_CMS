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
	<div class="cms-news-date">
		<span class="cms-news-day"><?php echo esc_html( $day ); ?></span>
		<span class="cms-news-month">THÁNG <?php echo esc_html( $month ); ?></span>
	</div>

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

