<?php
/**
 * Template part for displaying next post navigation (Section 7 - Module 7)
 *
 * @package WordPress
 * @subpackage Twenty_Twenty_One
 */

$nav_posts = array();

// Fetch next and previous posts
$next_post = get_next_post();
$prev_post = get_previous_post();

if ( $next_post ) {
	$nav_posts[] = $next_post;
}
if ( $prev_post ) {
	$nav_posts[] = $prev_post;
}

// If fewer than 2 posts, fetch other recent published posts to ensure 2 items are displayed
if ( count( $nav_posts ) < 2 ) {
	$exclude_ids = array( get_the_ID() );
	foreach ( $nav_posts as $np ) {
		$exclude_ids[] = $np->ID;
	}

	$extra_posts = get_posts(
		array(
			'numberposts'  => 2 - count( $nav_posts ),
			'post__not_in' => $exclude_ids,
			'post_type'    => 'post',
			'post_status'  => 'publish',
			'orderby'      => 'date',
			'order'        => 'DESC',
		)
	);

	foreach ( $extra_posts as $ep ) {
		$nav_posts[] = $ep;
	}
}

if ( ! empty( $nav_posts ) ) :
?>
<nav class="gc-post-navigation module7-next-post-navigation" aria-label="<?php esc_attr_e( 'Post navigation', 'twentytwentyone' ); ?>">
	<div class="gc-post-nav-list module7-next-post-list">
		<?php foreach ( $nav_posts as $p ) :
			$p_id    = $p->ID;
			$p_title = get_the_title( $p_id );
			$p_link  = get_permalink( $p_id );
			$p_day   = get_the_date( 'd', $p_id );
			$p_month = get_the_date( 'm', $p_id );
			$p_year  = get_the_date( 'y', $p_id );
		?>
			<div class="gc-post-nav-item module7-next-post-item">
				<a href="<?php echo esc_url( $p_link ); ?>" class="gc-post-nav-link module7-next-post-link">
					<div class="gc-nav-date-box module7-date-box">
						<div class="gc-nav-date-fraction module7-date-fraction">
							<span class="gc-nav-day module7-day"><?php echo esc_html( $p_day ); ?></span>
							<span class="gc-nav-date-line module7-date-line"></span>
							<span class="gc-nav-month module7-month"><?php echo esc_html( $p_month ); ?></span>
						</div>
						<span class="gc-nav-year module7-year"><?php echo esc_html( $p_year ); ?></span>
					</div>
					<span class="gc-nav-title module7-title"><?php echo esc_html( $p_title ); ?></span>
				</a>
			</div>
		<?php endforeach; ?>
	</div>
</nav>
<?php endif; ?>
