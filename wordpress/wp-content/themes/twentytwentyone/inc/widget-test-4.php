<?php
/**
 * Thể hiện chức năng Widget Test 4 (Tính điểm lần 4 môn CMS)
 * 
 * Tên Widget: widget_test_4
 * Vị trí hiển thị: Phía trên Footer (Trang chủ, Trang danh sách, Trang chi tiết)
 * Chức năng: Hiển thị 5 bài viết ngẫu nhiên và thanh danh mục động có menu xổ xuống (dropdown) tại chữ 'v'
 */

if ( ! class_exists( 'widget_test_4' ) ) {
	// Khai báo lớp widget_test_4 kế thừa từ lớp WP_Widget của WordPress
	class widget_test_4 extends WP_Widget {

		/**
		 * Khởi tạo Widget với ID và tên là 'widget_test_4'
		 */
		public function __construct() {
			parent::__construct(
				'widget_test_4', // ID cố định của Widget
				__( 'widget_test_4', 'twentytwentyone' ), // Tên hiển thị trong Admin
				array(
					'description' => __( 'Widget Test 4 - Hiển thị 5 bài viết ngẫu nhiên phía trên Footer', 'twentytwentyone' ),
				)
			);
		}

		/**
		 * Xử lý hiển thị Giao diện Widget ở phía Frontend
		 */
		public function widget( $args, $instance ) {
			echo $args['before_widget'] ?? '<div class="widget_test_4">';

			// --- 1. LẤY DANH SÁCH DANH MỤC (CATEGORIES) TỪ DATABASE ---
			$all_categories = get_categories( array(
				'hide_empty' => false,
				'orderby'    => 'name',
				'order'      => 'ASC',
				'exclude'    => array( 1 ), // Bỏ qua danh mục mặc định 'Uncategorized' nếu có danh mục khác
			) );

			// Nếu không tìm thấy danh mục nào khác, lấy toàn bộ danh mục hiện có
			if ( empty( $all_categories ) ) {
				$all_categories = get_categories( array( 'hide_empty' => false ) );
			}

			// Tách 3 danh mục đầu tiên để hiển thị ngang, các danh mục còn lại đưa vào Menu xổ xuống (Dropdown)
			$top_cats  = array_slice( $all_categories, 0, 3 );
			$more_cats = array_slice( $all_categories, 3 );

			// --- 2. TRUY VẤN 5 BÀI VIẾT NGẪU NHIÊN (RANDOM POSTS) ---
			$query_args = array(
				'post_type'      => 'post',
				'post_status'    => 'publish',
				'posts_per_page' => 5,      // Lấy đúng 5 bài viết
				'orderby'        => 'rand',   // Sắp xếp ngẫu nhiên để không sinh viên nào giống sinh viên nào
			);

			$random_query = new WP_Query( $query_args );
			?>
			<!-- Khung chứa Widget Test 4 -->
			<div class="widget-test-4-container">
				
				<!-- Thanh Navigation chứa 3 danh mục đầu + Menu xổ xuống tại chữ 'v' (Góc trên bên phải) -->
				<div class="widget-test-4-header">
					<?php if ( ! empty( $top_cats ) ) : ?>
						<?php foreach ( $top_cats as $index => $cat ) : ?>
							<?php if ( $index > 0 ) : ?>
								<span class="widget-test-4-sep">|</span>
							<?php endif; ?>
							<a href="<?php echo esc_url( get_category_link( $cat->term_id ) ); ?>" class="widget-test-4-nav-link">
								<?php echo esc_html( $cat->name ); ?>
							</a>
						<?php endforeach; ?>
					<?php else : ?>
						<!-- Dự phòng nếu chưa có danh mục trong database -->
						<a href="#" class="widget-test-4-nav-link">Kết nối</a>
						<span class="widget-test-4-sep">|</span>
						<a href="#" class="widget-test-4-nav-link">Phim</a>
						<span class="widget-test-4-sep">|</span>
						<a href="#" class="widget-test-4-nav-link">Truyền hình</a>
					<?php endif; ?>

					<span class="widget-test-4-sep">|</span>

					<!-- Menu sổ xuống (Dropdown Menu) khi rê chuột/bấm vào icon chữ 'v' chứa các danh mục còn lại -->
					<div class="widget-test-4-dropdown-wrapper">
						<span class="widget-test-4-caret" tabindex="0" title="Click hoặc di chuột xem thêm danh mục">&#x2228;</span>
						<div class="widget-test-4-dropdown-menu">
							<?php if ( ! empty( $more_cats ) ) : ?>
								<?php foreach ( $more_cats as $m_cat ) : ?>
									<a href="<?php echo esc_url( get_category_link( $m_cat->term_id ) ); ?>" class="widget-test-4-dropdown-item">
										<?php echo esc_html( $m_cat->name ); ?>
									</a>
								<?php endforeach; ?>
							<?php else : ?>
								<!-- Dự phòng danh mục bổ sung -->
								<a href="#" class="widget-test-4-dropdown-item">Giải trí</a>
								<a href="#" class="widget-test-4-dropdown-item">Âm nhạc</a>
								<a href="#" class="widget-test-4-dropdown-item">Thời sự</a>
							<?php endif; ?>
						</div>
					</div>
				</div>

				<!-- Khung hiển thị danh sách bài viết với đường kẻ dọc bên trái -->
				<div class="widget-test-4-body">
					<ul class="widget-test-4-list">
						<?php if ( $random_query->have_posts() ) : ?>
							<?php while ( $random_query->have_posts() ) : $random_query->the_post(); ?>
								<li class="widget-test-4-item">
									<a href="<?php the_permalink(); ?>" class="widget-test-4-title">
										<?php
										// Chuẩn hóa ký tự tiếng Việt dạng UTF-8 NFC để tránh lỗi tách dấu hoặc khoảng trắng dấu
										$post_title = get_the_title();
										if ( class_exists( 'Normalizer' ) ) {
											$post_title = Normalizer::normalize( $post_title, Normalizer::FORM_C );
										}
										echo esc_html( $post_title );
										?>
									</a>
								</li>
							<?php endwhile; ?>
							<?php wp_reset_postdata(); ?>
						<?php else : ?>
							<li class="widget-test-4-item">
								<span class="widget-test-4-title">Không có bài viết nào.</span>
							</li>
						<?php endif; ?>
					</ul>
				</div>
			</div>
			<?php

			echo $args['after_widget'] ?? '</div>';
		}

		/**
		 * Form cấu hình Widget trong trang quản trị Admin
		 */
		public function form( $instance ) {
			$title = ! empty( $instance['title'] ) ? $instance['title'] : 'widget_test_4';
			?>
			<p>
				<label for="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>"><?php esc_html_e( 'Tiêu đề Widget:' ); ?></label>
				<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'title' ) ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>">
			</p>
			<?php
		}

		/**
		 * Cập nhật cấu hình Widget
		 */
		public function update( $new_instance, $old_instance ) {
			$instance          = array();
			$instance['title'] = ( ! empty( $new_instance['title'] ) ) ? sanitize_text_field( $new_instance['title'] ) : '';
			return $instance;
		}
	}
}

/**
 * Đăng ký Widget widget_test_4 với hệ thống WordPress qua Action 'widgets_init'
 */
function register_widget_test_4() {
	register_widget( 'widget_test_4' );
}
add_action( 'widgets_init', 'register_widget_test_4' );
