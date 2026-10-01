<?php
/**
 * Module 11 theme setup.
 */

function module11_setup() {
    add_theme_support( 'title-tag' );
    add_theme_support( 'post-thumbnails' );
    register_nav_menus(
        array(
            'primary' => __( 'Primary menu', 'module11' ),
        )
    );
}
add_action( 'after_setup_theme', 'module11_setup' );

function module11_assets() {
    wp_enqueue_style( 'module11-style', get_stylesheet_uri(), array(), '1.0.0' );
    wp_enqueue_style( 'widget-test-4-style', get_template_directory_uri() . '/assets/css/widget-test-4.css', array(), '1.0.0' );
}
add_action( 'wp_enqueue_scripts', 'module11_assets' );
