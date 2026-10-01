<?php
/**
 * Member 4: recent posts widget.
 *
 * @package Twenty_Twenty_One
 */

if ( ! class_exists( 'Member_4_Widget' ) && class_exists( 'WP_Widget' ) ) {
	class Member_4_Widget extends WP_Widget {
		public function __construct() {
			parent::__construct(
				'member_4_widget',
				__( 'Member 4 Widget', 'twentytwentyone' ),
				array( 'description' => __( 'Displays the latest published posts.', 'twentytwentyone' ) )
			);
		}

		public function widget( $args, $instance ) {
			$recent_posts = new WP_Query(
				array(
					'post_type'           => 'post',
					'post_status'         => 'publish',
					'posts_per_page'      => 5,
					'ignore_sticky_posts' => true,
					'orderby'             => 'date',
					'order'               => 'DESC',
				)
			);

			echo $args['before_widget'] ?? '';
			echo '<div class="widget-member-4"><h2>' . esc_html__( 'Bài viết mới', 'twentytwentyone' ) . '</h2><ul>';

			while ( $recent_posts->have_posts() ) {
				$recent_posts->the_post();
				echo '<li><a href="' . esc_url( get_permalink() ) . '">' . esc_html( get_the_title() ) . '</a></li>';
			}

			echo '</ul></div>';
			echo $args['after_widget'] ?? '';
			wp_reset_postdata();
		}
	}
}

function register_member_4_widget() {
	register_widget( 'Member_4_Widget' );
}
add_action( 'widgets_init', 'register_member_4_widget', 40 );
