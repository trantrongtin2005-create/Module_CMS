<?php
/**
 * The main template file
 *
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * E.g., it puts together the home page when no home.php file exists.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package WordPress
 * @subpackage Twenty_Twenty_One
 * @since Twenty Twenty-One 1.0
 */

if ( is_home() || is_front_page() || is_single() ) {
	wp_enqueue_style( 'module11-home', get_stylesheet_directory_uri() . '/module11.css', array(), '1.1.0' );
}
get_header(); ?>

<?php if ( is_home() && ! is_front_page() && ! empty( single_post_title( '', false ) ) ) : ?>
	<header class="page-header alignwide">
		<h1 class="page-title"><?php single_post_title(); ?></h1>
	</header><!-- .page-header -->
<?php endif; ?>

<div class="module11-home-layout">
	<aside class="module11-home-archive" aria-labelledby="module11-home-archive-title">
		<h2 id="module11-home-archive-title">Bài viết mới nhất</h2>
		<?php
		$module11_latest_posts = new WP_Query(
			array(
				'post_type'           => 'post',
				'post_status'         => 'publish',
				'posts_per_page'      => -1,
				'ignore_sticky_posts' => true,
				'orderby'              => 'date',
				'order'                => 'DESC',
			)
		);
		?>
		<?php if ( $module11_latest_posts->have_posts() ) : ?>
			<ol class="module11-latest-list">
				<?php while ( $module11_latest_posts->have_posts() ) : $module11_latest_posts->the_post(); ?>
					<li><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></li>
				<?php endwhile; ?>
			</ol>
		<?php else : ?>
			<p>Chưa có bài viết.</p>
		<?php endif; ?>
		<?php wp_reset_postdata(); ?>
	</aside>

	<div class="module11-home-feed">
		<?php
		if ( have_posts() ) {
			while ( have_posts() ) {
				the_post();
				get_template_part( 'template-parts/content/content', get_theme_mod( 'display_excerpt_or_full_post', 'excerpt' ) );
			}
			twenty_twenty_one_the_posts_navigation();
		} else {
			get_template_part( 'template-parts/content/content-none' );
		}
		?>
	</div>

	<aside class="module11-home-comments" aria-labelledby="module11-home-comments-title">
		<div class="module11-comments-heading">
			<h2 id="module11-home-comments-title">Comments</h2>
			<span class="module11-comments-more" aria-hidden="true">&#8942;</span>
		</div>
		<?php
		$module11_home_comments = get_comments(
			array(
				'number'      => 0,
				'status'      => 'approve',
				'post_type'   => 'post',
				'post_status' => 'publish',
				'orderby'     => 'comment_date_gmt',
				'order'       => 'DESC',
			)
		);
		?>
		<?php if ( $module11_home_comments ) : ?>
			<ul>
				<?php foreach ( $module11_home_comments as $module11_home_comment ) : ?>
					<li>
						<a href="<?php echo esc_url( get_comment_link( $module11_home_comment ) ); ?>"><?php echo esc_html( wp_strip_all_tags( $module11_home_comment->comment_content ) ); ?></a>
					</li>
				<?php endforeach; ?>
			</ul>
		<?php else : ?>
			<p>Chưa có bình luận.</p>
		<?php endif; ?>
	</aside>
</div>

<?php get_footer(); ?>
