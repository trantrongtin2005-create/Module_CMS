<?php
/**
 * Thể hiện chức năng Widget Test 4: Danh sách video/bài viết ngẫu nhiên theo khung Card cuộn
 * 
 * Tên Widget: widget_test_4
 * Vị trí hiển thị: Phía trên Footer (BÊN TRÁI)
 */

if ( ! class_exists( 'widget_test_4' ) ) {
	class widget_test_4 extends WP_Widget {

		public function __construct() {
			parent::__construct(
				'widget_test_4',
				__( 'Widget Test 4 (Video Posts)', 'twentytwentyone' ),
				array(
					'classname'   => 'widget_widget_test_4',
					'description' => __( 'Widget Test 4 - Danh sách video bài viết với ảnh và badge thời lượng', 'twentytwentyone' ),
				)
			);
		}

		public function widget( $args, $instance ) {
			$title  = ! empty( $instance['title'] ) ? $instance['title'] : '';
			$number = ! empty( $instance['number'] ) ? absint( $instance['number'] ) : 5;

			$query_args = array(
				'post_type'           => 'post',
				'post_status'         => 'publish',
				'posts_per_page'      => $number,
				'orderby'             => 'rand',
				'ignore_sticky_posts' => true,
				'no_found_rows'       => true,
			);

			if ( is_single() ) {
				$query_args['post__not_in'] = array( get_queried_object_id() );
			}

			$random_query = new WP_Query( $query_args );

			echo $args['before_widget'] ?? '<div class="widget widget_widget_test_4 user-widget-left">';

			if ( ! empty( $title ) ) {
				echo ( $args['before_title'] ?? '<h2 class="widget-title">' ) . apply_filters( 'widget_title', $title ) . ( $args['after_title'] ?? '</h2>' );
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

							// Nếu chưa có meta, tạo thời lượng mm:ss ngẫu nhiên giả định
							if ( empty( $badge ) ) {
								$minutes = str_pad( ( ( $post_id * 3 ) % 4 ) + 1, 2, '0', STR_PAD_LEFT );
								$seconds = str_pad( ( $post_id * 19 ) % 60, 2, '0', STR_PAD_LEFT );
								$badge   = '0' . ( ( $post_id % 3 ) + 1 ) . ':' . $seconds;
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
								$fallback_svg = 'data:image/svg+xml;utf8,<svg xmlns="http://www.w3.org/2000/svg" width="130" height="75" viewBox="0 0 130 75"><rect width="130" height="75" fill="%232c5282"/><path d="M0 50 L40 25 L80 55 L100 40 L130 65 L130 75 L0 75 Z" fill="%234299e1"/><circle cx="95" cy="22" r="8" fill="%23ecc94b"/></svg>';
								$thumb_html   = '<img src="' . esc_attr( $fallback_svg ) . '" alt="' . esc_attr( $title_txt ) . '" class="widget-test-4-img" />';
							}
							?>
							<a href="<?php echo esc_url( $permalink ); ?>" class="widget-test-4-item" title="<?php echo esc_attr( $title_txt ); ?>">
								<div class="widget-test-4-thumb-wrapper">
									<?php echo $thumb_html; ?>
									<div class="widget-test-4-badge-time">
										<span><?php echo esc_html( $badge ); ?></span>
									</div>
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
			echo $args['after_widget'] ?? '</div>';
		}

		public function form( $instance ) {
			$title  = ! empty( $instance['title'] ) ? $instance['title'] : '';
			$number = ! empty( $instance['number'] ) ? absint( $instance['number'] ) : 5;
			?>
			<p>
				<label for="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>"><?php esc_html_e( 'Tiêu đề Widget:' ); ?></label>
				<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'title' ) ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>">
			</p>
			<p>
				<label for="<?php echo esc_attr( $this->get_field_id( 'number' ) ); ?>"><?php esc_html_e( 'Số lượng bài hiển thị:' ); ?></label>
				<input class="tiny-text" id="<?php echo esc_attr( $this->get_field_id( 'number' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'number' ) ); ?>" type="number" step="1" min="1" max="20" value="<?php echo esc_attr( $number ); ?>">
			</p>
			<?php
		}

		public function update( $new_instance, $old_instance ) {
			$instance          = array();
			$instance['title']  = ( ! empty( $new_instance['title'] ) ) ? sanitize_text_field( $new_instance['title'] ) : '';
			$instance['number'] = ( ! empty( $new_instance['number'] ) ) ? absint( $new_instance['number'] ) : 5;
			return $instance;
		}
	}
}

function register_custom_widget_test_4() {
	register_widget( 'widget_test_4' );
}
add_action( 'widgets_init', 'register_custom_widget_test_4' );