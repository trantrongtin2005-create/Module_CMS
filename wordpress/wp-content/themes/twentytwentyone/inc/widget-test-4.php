<?php
/**
 * Widget Name: widget_test_4
 * Description: Hiển thị danh sách video/bài viết ngẫu nhiên theo giao diện mẫu
 * 
 * @package WordPress
 * @subpackage Twenty_Twenty_One
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class widget_test_4 extends WP_Widget {

	/**
	 * Khởi tạo widget_test_4
	 */
	public function __construct() {
		parent::__construct(
			'widget_test_4',
			__( 'Widget Test 4 (Random Posts)', 'twentytwentyone' ),
			array(
				'classname'                   => 'widget_test_4',
				'description'                 => __( 'Widget Test 4: Danh sách video tin tức thể thao ngẫu nhiên (random)', 'twentytwentyone' ),
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

		$query_args = array(
			'post_type'           => 'post',
			'post_status'         => 'publish',
			'posts_per_page'      => $number,
			'orderby'             => 'rand',
			'ignore_sticky_posts' => true,
			'no_found_rows'       => true,
		);

		// Tránh hiển thị bài viết hiện tại nếu đang ở trang chi tiết bài viết
		if ( is_single() ) {
			$query_args['post__not_in'] = array( get_queried_object_id() );
		}

		if ( $category > 0 ) {
			$query_args['cat'] = $category;
		}

		$random_query = new WP_Query( $query_args );

		echo $args['before_widget'];

		if ( ! empty( $title ) ) {
			echo $args['before_title'] . apply_filters( 'widget_title', $title ) . $args['after_title'];
		}
		?>
		<div class="widget-test-4-card">
			<div class="widget-test-4-scrollable">
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

						// Nếu bài viết chưa có meta, tạo badge thời lượng giả định
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
						if ( has_post_thumbnail( $post_id ) ) {
							$thumb_html = get_the_post_thumbnail(
								$post_id,
								'medium',
								array(
									'class' => 'widget-test-4-img',
									'alt'   => esc_attr( $title_txt ),
								)
							);
						} else {
							$fallback_src = get_theme_file_uri( '/assets/images/default-thumb.jpg' );
							$thumb_html   = '<img src="' . esc_url( $fallback_src ) . '" alt="' . esc_attr( $title_txt ) . '" class="widget-test-4-img" />';
						}
						?>
						<a href="<?php echo esc_url( $permalink ); ?>" class="widget-test-4-item" title="<?php echo esc_attr( $title_txt ); ?>">
							<div class="widget-test-4-thumb-wrapper">
								<?php echo $thumb_html; ?>
								<?php if ( $badge === 'Đang phát' ) : ?>
									<div class="widget-test-4-badge-live">
										<span><?php esc_html_e( 'Đang phát', 'twentytwentyone' ); ?></span>
									</div>
								<?php else : ?>
									<div class="widget-test-4-badge-time">
										<span><?php echo esc_html( $badge ); ?></span>
									</div>
								<?php endif; ?>
							</div>
							<div class="widget-test-4-title-wrapper">
								<h4 class="widget-test-4-item-title"><?php echo esc_html( $title_txt ); ?></h4>
							</div>
						</a>
						<?php
						$item_index++;
					endwhile;
					wp_reset_postdata();
				else :
					?>
					<p class="widget-test-4-empty"><?php esc_html_e( 'Chưa có bài viết nào.', 'twentytwentyone' ); ?></p>
				<?php endif; ?>
			</div>
		</div>
		<?php
		echo $args['after_widget'];
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
			<input class="tiny-text" id="<?php echo esc_attr( $this->get_field_id( 'number' ) ); ?>" name="<?php echo esc_attr( $this->get_field_id( 'number' ) ); ?>" type="number" step="1" min="1" max="20" value="<?php echo esc_attr( $number ); ?>" size="3" />
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

/**
 * Đăng ký widget_test_4 với WordPress
 */
function register_custom_widget_test_4() {
	register_widget( 'widget_test_4' );
}
add_action( 'widgets_init', 'register_custom_widget_test_4' );