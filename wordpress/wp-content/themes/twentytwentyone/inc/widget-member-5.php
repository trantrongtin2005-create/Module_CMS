<?php
/**
 * Member 5: categories list widget.
 *
 * @package Twenty_Twenty_One
 */

if ( ! class_exists( 'Member_5_Widget' ) && class_exists( 'WP_Widget' ) ) {
	class Member_5_Widget extends WP_Widget {
		public function __construct() {
			parent::__construct(
				'member_5_widget',
				__( 'Member 5 Widget', 'twentytwentyone' ),
				array( 'description' => __( 'Displays post categories and their counts.', 'twentytwentyone' ) )
			);
		}

		public function widget( $args, $instance ) {
			$categories = get_categories(
				array(
					'orderby'    => 'name',
					'order'      => 'ASC',
					'hide_empty' => false,
				)
			);

			echo $args['before_widget'] ?? '';
			echo '<div class="widget-member-5"><h2>' . esc_html__( 'Chuyên mục', 'twentytwentyone' ) . '</h2><ul>';

			if ( ! is_wp_error( $categories ) ) {
				foreach ( $categories as $category ) {
					echo '<li><a href="' . esc_url( get_category_link( $category->term_id ) ) . '">' . esc_html( $category->name ) . '</a> <span>' . esc_html( number_format_i18n( $category->count ) ) . '</span></li>';
				}
			}

			echo '</ul></div>';
			echo $args['after_widget'] ?? '';
		}
	}
}

function register_member_5_widget() {
	register_widget( 'Member_5_Widget' );
}
add_action( 'widgets_init', 'register_member_5_widget', 50 );