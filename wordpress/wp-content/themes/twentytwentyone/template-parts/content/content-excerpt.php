<?php
/**
 * Template part for displaying post archives and search results
 * Matching exact wireframe: Date Block (Day + Month) | Vertical Divider | Blue Title + Excerpt
 *
 * @package WordPress
 * @subpackage Twenty_Twenty_One
 * @since Twenty Twenty-One 1.0
 */

$day_num   = get_the_date( 'd' );
$month_num = get_the_date( 'm' );
?>

<article id="post-<?php the_ID(); ?>" <?php post_class( 'gc-post-card-item' ); ?>>
	<div class="gc-card-inner">
		<!-- Left: Date Block -->
		<div class="gc-card-date-block">
			<span class="gc-card-day"><?php echo esc_html( $day_num ); ?></span>
			<span class="gc-card-month"><?php echo esc_html( 'THÁNG ' . $month_num ); ?></span>
		</div>

		<!-- Middle: Vertical Line -->
		<div class="gc-card-divider"></div>

		<!-- Right: Title & Excerpt -->
		<div class="gc-card-content-block">
			<h3 class="gc-card-title">
				<a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
			</h3>

			<div class="gc-card-excerpt">
				<?php
				$excerpt = get_the_excerpt();
				if ( empty( $excerpt ) ) {
					$excerpt = wp_trim_words( get_the_content(), 30, '[...]' );
				}
				echo esc_html( $excerpt );
				?>
			</div>
		</div>
	</div>
</article><!-- #post-<?php the_ID(); ?> -->

