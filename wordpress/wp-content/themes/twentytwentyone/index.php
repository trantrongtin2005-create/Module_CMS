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

if (is_home() || is_front_page() || is_single()) {
	wp_enqueue_style('module11-home', get_stylesheet_directory_uri() . '/module11.css', array(), '1.1.0');
}
get_header(); ?>

<?php if (is_home() && ! is_front_page() && ! empty(single_post_title('', false))) : ?>
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
				'posts_per_page'      => 6,
				'ignore_sticky_posts' => true,
				'orderby'             => 'date',
				'order'               => 'DESC',
			)
		);
		?>

		<?php if ($module11_latest_posts->have_posts()) : ?>

			<ul class="module11-timeline">

				<?php while ($module11_latest_posts->have_posts()) : $module11_latest_posts->the_post(); ?>

					<li class="module11-timeline-item">

						<div class="module11-timeline-header">

							<a
								class="module11-timeline-title"
								href="<?php the_permalink(); ?>">
								<?php the_title(); ?>
							</a>

							<span class="module11-timeline-date">
								<?php echo esc_html(get_the_date('d/m/Y')); ?>
							</span>

						</div>

						<p class="module11-timeline-excerpt">
							<?php
							$module11_excerpt = get_the_excerpt();

							if (empty($module11_excerpt)) {
								$module11_excerpt = get_the_content();
							}

							echo esc_html(
								wp_trim_words(
									wp_strip_all_tags($module11_excerpt),
									12,
									'...'
								)
							);
							?>
						</p>

					</li>

				<?php endwhile; ?>

			</ul>

		<?php else : ?>

			<p>Chưa có bài viết.</p>

		<?php endif; ?>

		<?php wp_reset_postdata(); ?>

	</aside>



	<div class="module11-home-feed">

		<?php if (have_posts()) : ?>

			<div class="module13-post-grid">

				<?php while (have_posts()) : the_post(); ?>

					<?php
					get_template_part(
						'template-parts/content/content',
						'module13'
					);
					?>

				<?php endwhile; ?>

			</div>

			<?php twenty_twenty_one_the_posts_navigation(); ?>

		<?php else : ?>

			<?php get_template_part('template-parts/content/content-none'); ?>

		<?php endif; ?>

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
		<?php if ($module11_home_comments) : ?>
			<ul>
				<?php foreach ($module11_home_comments as $module11_home_comment) : ?>
					<li>
						<a href="<?php echo esc_url(get_comment_link($module11_home_comment)); ?>"><?php echo esc_html(wp_strip_all_tags($module11_home_comment->comment_content)); ?></a>
					</li>
				<?php endforeach; ?>
			</ul>
		<?php else : ?>
			<p>Chưa có bình luận.</p>
		<?php endif; ?>
	</aside>
</div>

<?php get_footer(); ?>