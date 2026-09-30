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
		if ( is_active_sidebar( 'sidebar-1' ) ) {
			dynamic_sidebar( 'sidebar-1' );
		}

		// Đảm bảo widget_test_4 luôn hiển thị kể cả khi chưa được gán qua WP Admin
		if ( ! is_active_widget( false, false, 'widget_test_4' ) ) {
			the_widget( 'widget_test_4' );
		}
		?>
	</aside><!-- .widget-area -->

<?php
endif;

