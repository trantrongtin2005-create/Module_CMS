<?php
/**
 * Module 3: Footer Quick Links Settings & Functions
 * Cho phép tùy chỉnh tiêu đề 3 cột Quick links và hỗ trợ hiển thị tràn màn hình
 *
 * @package WordPress
 * @subpackage Twenty_Twenty_One
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Lấy tiêu đề cột Quick links ở Footer
 * Thứ tự ưu tiên:
 * 1. Giá trị lưu trong Customizer (theme_mod) hoặc Option
 * 2. Tên của Menu được gán cho cột đó trong Giao diện -> Menu
 * 3. Mặc định: 'Quick links'
 */
if ( ! function_exists( 'get_footer_col_title' ) ) {
	function get_footer_col_title( $col_index, $default = 'Quick links' ) {
		// 1. Kiểm tra theme_mod
		$mod_title = get_theme_mod( "footer_col_{$col_index}_title" );
		if ( ! empty( $mod_title ) ) {
			return $mod_title;
		}

		// 2. Kiểm tra option
		$opt_title = get_option( "footer_col_{$col_index}_title" );
		if ( ! empty( $opt_title ) ) {
			return $opt_title;
		}

		// 3. Kiểm tra tên Menu được gán
		$locations    = get_nav_menu_locations();
		$location_key = "footer-col-{$col_index}";
		if ( ! empty( $locations[ $location_key ] ) ) {
			$menu_obj = wp_get_nav_menu_object( $locations[ $location_key ] );
			if ( $menu_obj && ! is_wp_error( $menu_obj ) && ! empty( $menu_obj->name ) ) {
				return $menu_obj->name;
			}
		}

		return $default;
	}
}

/**
 * Đăng ký tùy biến Customizer cho Footer Quick Links
 */
function module3_footer_customize_register( $wp_customize ) {
	$wp_customize->add_section(
		'module3_footer_section',
		array(
			'title'       => __( 'Footer Quick Links (Tiêu đề cột)', 'twentytwentyone' ),
			'priority'    => 130,
			'description' => __( 'Tùy chỉnh tiêu đề của 3 cột Quick Links ở chân trang (Footer).', 'twentytwentyone' ),
		)
	);

	foreach ( array( 1, 2, 3 ) as $i ) {
		$wp_customize->add_setting(
			"footer_col_{$i}_title",
			array(
				'default'           => 'Quick links',
				'sanitize_callback' => 'sanitize_text_field',
				'transport'         => 'refresh',
			)
		);
		$wp_customize->add_control(
			"footer_col_{$i}_title",
			array(
				'label'   => sprintf( __( 'Tiêu đề Cột %d', 'twentytwentyone' ), $i ),
				'section' => 'module3_footer_section',
				'type'    => 'text',
			)
		);
	}
}
add_action( 'customize_register', 'module3_footer_customize_register' );

/**
 * Thêm trang quản trị nhanh trong WP Admin: Giao diện -> Footer Quick Links
 */
function module3_footer_admin_menu() {
	add_theme_page(
		__( 'Footer Quick Links', 'twentytwentyone' ),
		__( 'Footer Quick Links', 'twentytwentyone' ),
		'manage_options',
		'footer-quicklinks-settings',
		'module3_footer_admin_page'
	);
}
add_action( 'admin_menu', 'module3_footer_admin_menu' );

function module3_footer_admin_page() {
	if ( ! current_user_can( 'manage_options' ) ) {
		return;
	}

	$saved = false;
	if ( isset( $_POST['module3_save_footer_titles'] ) && check_admin_referer( 'module3_footer_action', 'module3_footer_nonce' ) ) {
		for ( $i = 1; $i <= 3; $i++ ) {
			$val = isset( $_POST[ "footer_col_{$i}_title" ] ) ? sanitize_text_field( wp_unslash( $_POST[ "footer_col_{$i}_title" ] ) ) : '';
			set_theme_mod( "footer_col_{$i}_title", $val );
			update_option( "footer_col_{$i}_title", $val );
		}
		$saved = true;
	}

	$col1 = get_footer_col_title( 1, 'Quick links' );
	$col2 = get_footer_col_title( 2, 'Quick links' );
	$col3 = get_footer_col_title( 3, 'Quick links' );
	?>
	<div class="wrap">
		<h1><?php esc_html_e( 'Cài đặt Tiêu đề Footer Quick Links', 'twentytwentyone' ); ?></h1>
		<?php if ( $saved ) : ?>
			<div class="notice notice-success is-dismissible">
				<p><strong><?php esc_html_e( 'Đã lưu cài đặt tiêu đề thành công!', 'twentytwentyone' ); ?></strong></p>
			</div>
		<?php endif; ?>
		<p><?php esc_html_e( 'Bạn có thể chỉnh sửa chữ "Quick links" ở 3 cột chân trang tại đây hoặc trong mục Giao diện -> Tùy biến (Customizer).', 'twentytwentyone' ); ?></p>
		<form method="post" action="">
			<?php wp_nonce_field( 'module3_footer_action', 'module3_footer_nonce' ); ?>
			<table class="form-table" role="presentation">
				<tr>
					<th scope="row"><label for="footer_col_1_title"><?php esc_html_e( 'Tiêu đề Cột 1', 'twentytwentyone' ); ?></label></th>
					<td><input name="footer_col_1_title" type="text" id="footer_col_1_title" value="<?php echo esc_attr( $col1 ); ?>" class="regular-text" /></td>
				</tr>
				<tr>
					<th scope="row"><label for="footer_col_2_title"><?php esc_html_e( 'Tiêu đề Cột 2', 'twentytwentyone' ); ?></label></th>
					<td><input name="footer_col_2_title" type="text" id="footer_col_2_title" value="<?php echo esc_attr( $col2 ); ?>" class="regular-text" /></td>
				</tr>
				<tr>
					<th scope="row"><label for="footer_col_3_title"><?php esc_html_e( 'Tiêu đề Cột 3', 'twentytwentyone' ); ?></label></th>
					<td><input name="footer_col_3_title" type="text" id="footer_col_3_title" value="<?php echo esc_attr( $col3 ); ?>" class="regular-text" /></td>
				</tr>
			</table>
			<p class="submit">
				<input type="submit" name="module3_save_footer_titles" id="submit" class="button button-primary" value="<?php esc_attr_e( 'Lưu thay đổi', 'twentytwentyone' ); ?>" />
			</p>
		</form>
	</div>
	<?php
}
