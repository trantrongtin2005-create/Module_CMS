<?php
/**
 * Displays the footer widget area.
 *
 * @package WordPress
 * @subpackage Twenty_Twenty_One
 * @since Twenty Twenty-One 1.0
 */

// Hiển thị widget_test_4 tại:
// 1) Trang chủ (is_front_page() || is_home())
// 2) Trang danh sách (is_archive() || is_category() || is_tag() || is_tax() || is_search())
// 3) Trang chi tiết (is_single() || is_singular())
// Khu vực hiển thị: phía trên Footer

$is_home_page   = is_front_page() || is_home();
$is_list_page   = is_archive() || is_category() || is_tag() || is_tax() || is_search();
$is_detail_page = is_single() || is_singular();

if ( $is_home_page || $is_list_page || $is_detail_page ) : ?>

	<aside class="widget-area footer-widget-test-4-area">
		<?php
		$sidebars_widgets   = get_option( 'sidebars_widgets', array() );
		$sidebar_1          = isset( $sidebars_widgets['sidebar-1'] ) && is_array( $sidebars_widgets['sidebar-1'] ) ? $sidebars_widgets['sidebar-1'] : array();
		$has_widget_test_4  = false;

		foreach ( $sidebar_1 as $w_id ) {
			if ( strpos( $w_id, 'widget_test_4' ) !== false ) {
				$has_widget_test_4 = true;
				break;
			}
		}

		// Render Widget của Bạn ở BÊN TRÁI (user-widget-left)
		if ( ! $has_widget_test_4 && class_exists( 'widget_test_4' ) ) {
			the_widget( 'widget_test_4', array(), array(
				'before_widget' => '<div class="widget widget_widget_test_4 user-widget-left">',
				'after_widget'  => '</div>',
			) );
		}

		if ( is_active_sidebar( 'sidebar-1' ) ) {
			dynamic_sidebar( 'sidebar-1' );
		}
		?>
	</aside><!-- .widget-area -->

<?php
endif;

