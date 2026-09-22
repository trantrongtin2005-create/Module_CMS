<?php
/**
 * Template part for displaying prev/next post navigation (Section 7)
 *
 * @package WordPress
 * @subpackage Twenty_Twenty_One
 */

$prev_post = get_previous_post();
$next_post = get_next_post();

if ( $prev_post || $next_post ) :
?>
<nav class="gc-post-navigation" aria-label="<?php esc_attr_e( 'Post navigation', 'twentytwentyone' ); ?>">
	<div class="gc-post-nav-inner">
		<?php if ( $prev_post ) :
			$prev_id    = $prev_post->ID;
			$prev_title = get_the_title( $prev_id );
			$prev_link  = get_permalink( $prev_id );
			$prev_day   = get_the_date( 'd', $prev_id );
			$prev_month = get_the_date( 'm', $prev_id );
			$prev_year  = get_the_date( 'y', $prev_id );
		?>
			<div class="gc-post-nav-item gc-post-nav-prev">
				<a href="<?php echo esc_url( $prev_link ); ?>" class="gc-post-nav-label-link">Prev Post</a>
				<div class="gc-post-nav-content">
					<a href="<?php echo esc_url( $prev_link ); ?>" class="gc-post-nav-main-link">
						<div class="gc-nav-date-box">
							<div class="gc-nav-date-fraction">
								<span class="gc-nav-day"><?php echo esc_html( $prev_day ); ?></span>
								<span class="gc-nav-date-line"></span>
								<span class="gc-nav-month"><?php echo esc_html( $prev_month ); ?></span>
							</div>
							<span class="gc-nav-year"><?php echo esc_html( $prev_year ); ?></span>
						</div>
						<span class="gc-nav-title"><?php echo esc_html( $prev_title ); ?></span>
					</a>
				</div>
			</div>
		<?php else : ?>
			<div class="gc-post-nav-item gc-post-nav-prev gc-nav-empty"></div>
		<?php endif; ?>

		<?php if ( $next_post ) :
			$next_id    = $next_post->ID;
			$next_title = get_the_title( $next_id );
			$next_link  = get_permalink( $next_id );
			$next_day   = get_the_date( 'd', $next_id );
			$next_month = get_the_date( 'm', $next_id );
			$next_year  = get_the_date( 'y', $next_id );
		?>
			<div class="gc-post-nav-item gc-post-nav-next">
				<a href="<?php echo esc_url( $next_link ); ?>" class="gc-post-nav-label-link">Next Post</a>
				<div class="gc-post-nav-content">
					<a href="<?php echo esc_url( $next_link ); ?>" class="gc-post-nav-main-link">
						<div class="gc-nav-date-box">
							<div class="gc-nav-date-fraction">
								<span class="gc-nav-day"><?php echo esc_html( $next_day ); ?></span>
								<span class="gc-nav-date-line"></span>
								<span class="gc-nav-month"><?php echo esc_html( $next_month ); ?></span>
							</div>
							<span class="gc-nav-year"><?php echo esc_html( $next_year ); ?></span>
						</div>
						<span class="gc-nav-title"><?php echo esc_html( $next_title ); ?></span>
					</a>
				</div>
			</div>
		<?php else : ?>
			<div class="gc-post-nav-item gc-post-nav-next gc-nav-empty"></div>
		<?php endif; ?>
	</div>
</nav>
<?php endif; ?>
