<?php
/**
 * Member 2: category navigation and post list widget.
 *
 * @package Twenty_Twenty_One
 */

if ( ! class_exists( 'Member_2_Widget' ) && class_exists( 'WP_Widget' ) ) {
	class Member_2_Widget extends WP_Widget {
		public function __construct() {
			parent::__construct(
				'member_2_widget',
				__( 'Member 2 Widget', 'twentytwentyone' ),
				array( 'description' => __( 'Category navigation and post list.', 'twentytwentyone' ) )
			);
		}

		public function widget( $args, $instance ) {
			echo $args['before_widget'] ?? '';
			get_template_part( 'template-parts/widgets/widget-member-4' );
			echo $args['after_widget'] ?? '';
		}
	}
}

function register_member_2_widget() {
	register_widget( 'Member_2_Widget' );
}
add_action( 'widgets_init', 'register_member_2_widget', 20 );

function enqueue_member_2_widget_styles() {
	wp_enqueue_style(
		'member-2-widget-style',
		get_template_directory_uri() . '/assets/css/widget-member-4.css',
		array(),
		'1.0.0'
	);
}
add_action( 'wp_enqueue_scripts', 'enqueue_member_2_widget_styles', 10 );