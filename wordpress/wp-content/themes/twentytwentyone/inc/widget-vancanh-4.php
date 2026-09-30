<?php
/**
 * Isolated WordPress Widget for ASEAN Cup Grid (Widget 3 - Văn Cảnh).
 *
 * @package WordPress
 */

if ( ! class_exists( 'Widget_Vancanh_4' ) && class_exists( 'WP_Widget' ) ) {
	class Widget_Vancanh_4 extends WP_Widget {
		public function __construct() {
			parent::__construct(
				'widget_vancanh_4',
				__( 'Widget ASEAN Cup Grid (Văn Cảnh)', 'twentytwentyone' ),
				array( 'description' => __( 'Widget ASEAN Cup dạng Grid báo chí tin tức.', 'twentytwentyone' ) )
			);
		}

		public function widget( $args, $instance ) {
			echo $args['before_widget'] ?? '';
			get_template_part( 'template-parts/widgets/widget-vancanh-4' );
			echo $args['after_widget'] ?? '';
		}
	}
}

function register_widget_vancanh_4() {
	register_widget( 'Widget_Vancanh_4' );
}
add_action( 'widgets_init', 'register_widget_vancanh_4', 40 );

function enqueue_widget_vancanh_4_styles() {
	wp_enqueue_style(
		'widget-vancanh-4-style',
		get_template_directory_uri() . '/assets/css/widget-vancanh-4.css',
		array(),
		'1.0.0'
	);
}
add_action( 'wp_enqueue_scripts', 'enqueue_widget_vancanh_4_styles', 10 );
