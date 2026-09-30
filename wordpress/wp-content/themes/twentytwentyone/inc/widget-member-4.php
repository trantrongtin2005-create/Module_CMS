<?php
/**
 * Member 4's isolated WordPress widget.
 *
 * @package WordPress
 */

if ( ! class_exists( 'Member_4_Widget' ) && class_exists( 'WP_Widget' ) ) {
	class Member_4_Widget extends WP_Widget {
		public function __construct() {
			parent::__construct(
				'member_4_widget',
				__( 'Member 4 Widget', 'twentytwentyone' ),
				array( 'description' => __( 'Custom widget for member 4.', 'twentytwentyone' ) )
			);
		}

		public function widget( $args, $instance ) {
			echo $args['before_widget'] ?? '';
			get_template_part( 'template-parts/widgets/widget-test-4' );
			echo $args['after_widget'] ?? '';
		}
	}
}

function register_member_4_widget() {
	register_widget( 'Member_4_Widget' );
}
add_action( 'widgets_init', 'register_member_4_widget', 40 );

function enqueue_member_4_widget_styles() {
	wp_enqueue_style(
		'member-4-widget-style',
		get_template_directory_uri() . '/assets/css/widget-member-4.css',
		array(),
		'1.0.0'
	);
}
add_action( 'wp_enqueue_scripts', 'enqueue_member_4_widget_styles', 10 );
