<?php
/**
 * Member 1: category news card widget.
 *
 * @package Twenty_Twenty_One
 */

if ( ! class_exists( 'Member_1_Widget' ) && class_exists( 'WP_Widget' ) ) {
	class Member_1_Widget extends WP_Widget {
		public function __construct() {
			parent::__construct(
				'member_1_widget',
				__( 'Member 1 Widget', 'twentytwentyone' ),
				array( 'description' => __( 'Displays recent news posts.', 'twentytwentyone' ) )
			);
		}

		public function widget( $args, $instance ) {
			$recent_posts = new WP_Query(
				array(
					'post_type'           => 'post',
					'post_status'         => 'publish',
					'posts_per_page'      => 4,
					'ignore_sticky_posts' => true,
					'orderby'             => 'date',
					'order'               => 'DESC',
				)
			);

			echo $args['before_widget'] ?? '';
			echo '<div class="widget-member-1"><h2>' . esc_html__( 'Tin nổi bật', 'twentytwentyone' ) . '</h2><ul class="member-1-post-list">';

			while ( $recent_posts->have_posts() ) {
				$recent_posts->the_post();
				echo '<li><a href="' . esc_url( get_permalink() ) . '">' . esc_html( get_the_title() ) . '</a><time datetime="' . esc_attr( get_the_date( 'c' ) ) . '">' . esc_html( get_the_date() ) . '</time></li>';
			}

			echo '</ul></div>';
			echo $args['after_widget'] ?? '';
			wp_reset_postdata();
		}
	}
}

function register_member_1_widget() {
	register_widget( 'Member_1_Widget' );
}
add_action( 'widgets_init', 'register_member_1_widget', 10 );