<?php
/**
 * Member 3: ASEAN Cup news grid widget.
 *
 * @package Twenty_Twenty_One
 */

if ( ! class_exists( 'Member_3_Widget' ) && class_exists( 'WP_Widget' ) ) {
	class Member_3_Widget extends WP_Widget {
		public function __construct() {
			parent::__construct(
				'member_3_widget',
				__( 'Member 3 Widget', 'twentytwentyone' ),
				array( 'description' => __( 'ASEAN Cup news grid.', 'twentytwentyone' ) )
			);
		}

		public function widget( $args, $instance ) {
			echo $args['before_widget'] ?? '';
			echo '<div class="widget-member-3">';
			get_template_part( 'template-parts/widgets/widget-vancanh-4' );
			echo '</div>';
			echo $args['after_widget'] ?? '';
		}
	}
}

function register_member_3_widget() {
	register_widget( 'Member_3_Widget' );
}
add_action( 'widgets_init', 'register_member_3_widget', 30 );

function enqueue_member_3_widget_styles() {
	wp_enqueue_style(
		'member-3-widget-style',
		get_template_directory_uri() . '/assets/css/widget-vancanh-4.css',
		array(),
		'1.0.0'
	);
}
add_action( 'wp_enqueue_scripts', 'enqueue_member_3_widget_styles', 10 );