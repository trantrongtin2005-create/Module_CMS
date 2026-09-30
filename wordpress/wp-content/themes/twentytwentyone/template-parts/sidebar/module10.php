<?php
/**
 * Module 10: Recent Posts Sidebar (Khung tin tức bên phải trang chi tiết bài viết)
 *
 * @package WordPress
 * @subpackage Twenty_Twenty_One
 */

$module10_detail_posts = new WP_Query(
	array(
		'post_type'           => 'post',
		'post_status'         => 'publish',
		'posts_per_page'      => 3,
		'ignore_sticky_posts' => true,
		'orderby'             => 'date',
		'order'               => 'DESC',
	)
);

if ( $module10_detail_posts->have_posts() ) :
?>
	<!-- ===================== MODULE 10: RECENT POSTS SIDEBAR ===================== -->
	<section class="module10-detail-news module11-detail-news">
		<div class="module10-detail-news-list module11-detail-news-list">
			<?php
			while ( $module10_detail_posts->have_posts() ) :
				$module10_detail_posts->the_post();
				?>
				<article class="module10-detail-news-item module11-detail-news-item">
					<time datetime="<?php echo esc_attr( get_the_date( 'c' ) ); ?>">
						<strong><?php echo esc_html( get_the_date( 'd' ) ); ?></strong>
						<span><?php echo esc_html( get_the_date( 'm' ) ); ?></span>
						<small><?php echo esc_html( get_the_date( 'y' ) ); ?></small>
					</time>
					<a href="<?php echo esc_url( get_permalink() ); ?>"><?php echo esc_html( get_the_title() ); ?></a>
				</article>
			<?php endwhile; ?>
		</div>
		<a class="module10-detail-news-more module11-detail-news-more" href="<?php echo esc_url( home_url( '/' ) ); ?>">
			<?php esc_html_e( 'XEM TẤT CẢ TIN TỨC', 'twentytwentyone' ); ?>
		</a>
	</section>
<?php
endif;
wp_reset_postdata();
