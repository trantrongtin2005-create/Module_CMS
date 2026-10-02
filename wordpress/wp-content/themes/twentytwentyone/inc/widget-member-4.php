<?php
/**
 * Member 4: randomly selected news widget.
 *
 * @package Twenty_Twenty_One
 */

if ( ! class_exists( 'Member_4_Widget' ) && class_exists( 'WP_Widget' ) ) {
	class Member_4_Widget extends WP_Widget {
		public function __construct() {
			parent::__construct(
				'widget_test_4',
				'widget_test_4',
				array( 'description' => __( 'Displays four randomly selected posts above the footer.', 'twentytwentyone' ) )
			);
		}

		public function widget( $args, $instance ) {
			$random_posts = new WP_Query(
				array(
					'post_type'           => 'post',
					'post_status'         => 'publish',
					'posts_per_page'      => 4,
					'ignore_sticky_posts' => true,
					'orderby'             => 'rand',
				)
			);

			$posts = $random_posts->posts;
			wp_reset_postdata();

			echo $args['before_widget'] ?? '';
			?>
			<div class="widget-member-4">
				<?php if ( ! empty( $posts ) ) : ?>
					<?php $featured_post = array_shift( $posts ); ?>
					<article class="member-4-featured">
						<a class="member-4-featured-image" href="<?php echo esc_url( get_permalink( $featured_post->ID ) ); ?>">
							<?php
							if ( has_post_thumbnail( $featured_post->ID ) ) {
								echo get_the_post_thumbnail( $featured_post->ID, 'large' );
							} else {
								printf(
									'<img src="%1$s" alt="%2$s">',
									esc_url( get_template_directory_uri() . '/assets/images/football.jpg' ),
									esc_attr( get_the_title( $featured_post->ID ) )
								);
							}
							?>
						</a>
						<div class="member-4-featured-content">
							<h2><a href="<?php echo esc_url( get_permalink( $featured_post->ID ) ); ?>"><?php echo esc_html( get_the_title( $featured_post->ID ) ); ?></a></h2>
							<p class="member-4-meta">
								<span><?php echo esc_html( get_the_author_meta( 'display_name', $featured_post->post_author ) ); ?></span>
								<span><?php echo esc_html( get_the_date( 'd/m/Y H:i', $featured_post->ID ) ); ?></span>
							</p>
							<p class="member-4-excerpt"><?php echo esc_html( wp_trim_words( get_the_excerpt( $featured_post->ID ), 30, '...' ) ); ?></p>
						</div>
					</article>

					<?php if ( ! empty( $posts ) ) : ?>
						<div class="member-4-secondary">
							<?php foreach ( $posts as $post_item ) : ?>
								<article class="member-4-item">
									<a class="member-4-item-image" href="<?php echo esc_url( get_permalink( $post_item->ID ) ); ?>">
										<?php
										if ( has_post_thumbnail( $post_item->ID ) ) {
											echo get_the_post_thumbnail( $post_item->ID, 'medium' );
										} else {
											printf(
												'<img src="%1$s" alt="%2$s">',
												esc_url( get_template_directory_uri() . '/assets/images/football.jpg' ),
												esc_attr( get_the_title( $post_item->ID ) )
											);
										}
										?>
									</a>
									<h3><a href="<?php echo esc_url( get_permalink( $post_item->ID ) ); ?>"><?php echo esc_html( get_the_title( $post_item->ID ) ); ?></a></h3>
									<p class="member-4-item-date"><?php echo esc_html( get_the_date( 'd/m/Y', $post_item->ID ) ); ?></p>
								</article>
							<?php endforeach; ?>
						</div>
					<?php endif; ?>
				<?php else : ?>
					<p class="member-4-empty"><?php esc_html_e( 'Chưa có bài viết.', 'twentytwentyone' ); ?></p>
				<?php endif; ?>
			</div>
			<?php
			echo $args['after_widget'] ?? '';
		}
	}
}

function register_member_4_widget() {
	register_widget( 'Member_4_Widget' );
}
add_action( 'widgets_init', 'register_member_4_widget', 40 );
