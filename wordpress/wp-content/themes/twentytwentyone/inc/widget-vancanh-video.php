<?php
/**
 * Widget Name: VanCanh_Widget_Video_4
 * Description: Hiển thị danh sách video/bài viết ngẫu nhiên theo giao diện mẫu của Văn Cảnh
 * Phục hồi từ nhánh vanCanh_Cms/_widget_4
 * 
 * @package WordPress
 * @subpackage Twenty_Twenty_One
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! class_exists( 'VanCanh_Widget_Video_4' ) ) {

	class VanCanh_Widget_Video_4 extends WP_Widget {

		/**
		 * Khởi tạo Widget
		 */
		public function __construct() {
			parent::__construct(
				'vancanh_widget_video_4',
				__( 'Widget Video Tin Tức (Văn Cảnh)', 'twentytwentyone' ),
				array(
					'classname'                   => 'widget_vancanh_widget_video_4 widget_test_4',
					'description'                 => __( 'Widget Test 4 (Văn Cảnh): Danh sách video tin tức thể thao ngẫu nhiên (random) kèm thời lượng / Đang phát.', 'twentytwentyone' ),
					'customize_selective_refresh' => true,
				)
			);
		}

		/**
		 * Hiển thị widget ở giao diện người dùng (Frontend)
		 *
		 * @param array $args     Widget arguments.
		 * @param array $instance Saved values from database.
		 */
		public function widget( $args, $instance ) {
			$title    = ! empty( $instance['title'] ) ? $instance['title'] : '';
			$number   = ! empty( $instance['number'] ) ? absint( $instance['number'] ) : 5;
			$category = ! empty( $instance['category'] ) ? absint( $instance['category'] ) : 0;

			// Query random posts theo yêu cầu: "random, không SV nào giống nhau"
			$query_args = array(
				'post_type'           => 'post',
				'post_status'         => 'publish',
				'posts_per_page'      => $number,
				'orderby'             => 'rand',
				'ignore_sticky_posts' => true,
				'no_found_rows'       => true,
			);

			if ( $category > 0 ) {
				$query_args['cat'] = $category;
			}

			$random_query = new WP_Query( $query_args );

			echo isset( $args['before_widget'] ) ? $args['before_widget'] : '<div class="widget_vancanh_widget_video_4">';

			if ( ! empty( $title ) ) {
				$before_t = isset( $args['before_title'] ) ? $args['before_title'] : '<h3 class="widget-title vancanh-video-main-title">';
				$after_t  = isset( $args['after_title'] ) ? $args['after_title'] : '</h3>';
				echo $before_t . apply_filters( 'widget_title', $title ) . $after_t;
			}
			?>
			<div class="vancanh-video-card widget-test-4-card">
				<div class="vancanh-video-scrollable widget-test-4-scrollable">
					<?php
					if ( $random_query->have_posts() ) :
						$item_index = 0;
						while ( $random_query->have_posts() ) :
							$random_query->the_post();
							$post_id   = get_the_ID();
							$permalink = get_permalink();
							$title_txt = get_the_title();

							// Lấy badge hoặc duration
							$badge = get_post_meta( $post_id, '_video_badge', true );
							if ( empty( $badge ) ) {
								$badge = get_post_meta( $post_id, '_video_duration', true );
							}
							// Nếu bài viết chưa có meta, tự động tạo badge trực quan:
							// Bài đầu tiên hoặc một số bài có thể là "Đang phát", còn lại là thời lượng video "mm:ss"
							if ( empty( $badge ) ) {
								if ( $item_index === 0 && ( $post_id % 3 === 0 || $post_id % 2 === 0 ) ) {
									$badge = 'Đang phát';
								} else {
									$minutes = str_pad( ( ( $post_id * 3 ) % 4 ) + 1, 2, '0', STR_PAD_LEFT );
									$seconds = str_pad( ( $post_id * 19 ) % 60, 2, '0', STR_PAD_LEFT );
									$badge   = $minutes . ':' . $seconds;
								}
							}

							// Lấy hình ảnh đại diện (thumbnail)
							$thumb_html = '';
							if ( has_post_thumbnail( $post_id ) ) {
								$thumb_html = get_the_post_thumbnail(
									$post_id,
									'medium',
									array(
										'class' => 'vancanh-video-img widget-test-4-img',
										'alt'   => esc_attr( $title_txt ),
									)
								);
							} else {
								// Fallback hình ảnh nếu bài viết không có thumbnail
								$fallback_src = get_template_directory_uri() . '/assets/images/football.jpg';
								$thumb_html   = '<img src="' . esc_url( $fallback_src ) . '" alt="' . esc_attr( $title_txt ) . '" class="vancanh-video-img widget-test-4-img" />';
							}
							?>
							<a href="<?php echo esc_url( $permalink ); ?>" class="vancanh-video-item widget-test-4-item" title="<?php echo esc_attr( $title_txt ); ?>">
								<div class="vancanh-video-thumb-wrapper widget-test-4-thumb-wrapper">
									<?php echo $thumb_html; ?>
									<?php if ( $badge === 'Đang phát' ) : ?>
										<div class="vancanh-video-badge-live widget-test-4-badge-live">
											<span><?php esc_html_e( 'Đang phát', 'twentytwentyone' ); ?></span>
										</div>
									<?php else : ?>
										<div class="vancanh-video-badge-time widget-test-4-badge-time">
											<span><?php echo esc_html( $badge ); ?></span>
										</div>
									<?php endif; ?>
								</div>
								<div class="vancanh-video-title-wrapper widget-test-4-title-wrapper">
									<h4 class="vancanh-video-item-title widget-test-4-item-title"><?php echo esc_html( $title_txt ); ?></h4>
								</div>
							</a>
							<?php
							$item_index++;
						endwhile;
						wp_reset_postdata();
					else :
						?>
						<p class="vancanh-video-empty widget-test-4-empty"><?php esc_html_e( 'Chưa có bài viết nào.', 'twentytwentyone' ); ?></p>
					<?php endif; ?>
				</div>
			</div>
			<?php
			echo isset( $args['after_widget'] ) ? $args['after_widget'] : '</div>';
		}

		/**
		 * Form quản trị cấu hình widget trong WP Admin
		 *
		 * @param array $instance Current settings.
		 */
		public function form( $instance ) {
			$title    = ! empty( $instance['title'] ) ? $instance['title'] : '';
			$number   = ! empty( $instance['number'] ) ? absint( $instance['number'] ) : 5;
			$category = ! empty( $instance['category'] ) ? absint( $instance['category'] ) : 0;
			$categories = get_categories( array( 'hide_empty' => false ) );
			?>
			<p>
				<label for="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>">
					<?php esc_html_e( 'Tiêu đề Widget:', 'twentytwentyone' ); ?>
				</label>
				<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'title' ) ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" placeholder="Để trống nếu không muốn hiển thị tiêu đề" />
			</p>
			<p>
				<label for="<?php echo esc_attr( $this->get_field_id( 'number' ) ); ?>">
					<?php esc_html_e( 'Số lượng bài hiển thị:', 'twentytwentyone' ); ?>
				</label>
				<input class="tiny-text" id="<?php echo esc_attr( $this->get_field_id( 'number' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'number' ) ); ?>" type="number" step="1" min="1" max="20" value="<?php echo esc_attr( $number ); ?>" size="3" />
			</p>
			<p>
				<label for="<?php echo esc_attr( $this->get_field_id( 'category' ) ); ?>">
					<?php esc_html_e( 'Chọn chuyên mục (Tùy chọn):', 'twentytwentyone' ); ?>
				</label>
				<select class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'category' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'category' ) ); ?>">
					<option value="0" <?php selected( $category, 0 ); ?>><?php esc_html_e( '— Tất cả chuyên mục (Random) —', 'twentytwentyone' ); ?></option>
					<?php foreach ( $categories as $cat ) : ?>
						<option value="<?php echo esc_attr( $cat->term_id ); ?>" <?php selected( $category, $cat->term_id ); ?>>
							<?php echo esc_html( $cat->name ); ?> (<?php echo esc_html( $cat->count ); ?>)
						</option>
					<?php endforeach; ?>
				</select>
			</p>
			<?php
		}

		/**
		 * Cập nhật cấu hình widget khi lưu trong WP Admin
		 *
		 * @param array $new_instance New settings.
		 * @param array $old_instance Old settings.
		 * @return array
		 */
		public function update( $new_instance, $old_instance ) {
			$instance             = array();
			$instance['title']    = ( ! empty( $new_instance['title'] ) ) ? sanitize_text_field( $new_instance['title'] ) : '';
			$instance['number']   = ( ! empty( $new_instance['number'] ) ) ? absint( $new_instance['number'] ) : 5;
			$instance['category'] = ( ! empty( $new_instance['category'] ) ) ? absint( $new_instance['category'] ) : 0;
			return $instance;
		}
	}
}

/**
 * Đăng ký Widget Video Tin Tức Văn Cảnh với WordPress
 */
function register_vancanh_widget_video_4() {
	register_widget( 'VanCanh_Widget_Video_4' );
}
add_action( 'widgets_init', 'register_vancanh_widget_video_4' );

/**
 * Enqueue CSS cho Widget Video Văn Cảnh
 */
function enqueue_vancanh_widget_video_styles() {
	wp_enqueue_style(
		'vancanh-widget-video-style',
		get_template_directory_uri() . '/assets/css/widget-vancanh-video.css',
		array(),
		wp_get_theme()->get( 'Version' )
	);
}
add_action( 'wp_enqueue_scripts', 'enqueue_vancanh_widget_video_styles', 20 );

