<?php
/**
 * Widget Test 4 Component
 * 
 * Displays category news in a custom card layout with a main article and two sub-articles.
 * Location: Above footer on Homepage, Category/Archive, and Detail pages.
 * 
 * @package Twenty_Twenty_One
 */

if ( ! class_exists( 'Widget_Test_4' ) ) {

	class Widget_Test_4 extends WP_Widget {

		public function __construct( $id_base = 'widget_test_4', $name = null ) {
			parent::__construct(
				$id_base,
				$name ? $name : __( 'Widget Test 4', 'twentytwentyone' ),
				array(
					'classname'   => 'widget_test_4_box',
					'description' => __( 'Widget hiển thị tin tức theo danh mục (Category) phong cách Thể thao / Doanh nghiệp phía trên Footer.', 'twentytwentyone' ),
				)
			);
		}

		/**
		 * Render Widget Front-End
		 */
		public function widget( $args, $instance ) {
			echo isset( $args['before_widget'] ) ? $args['before_widget'] : '<div class="widget_test_4_wrapper">';

			$cat_id       = ! empty( $instance['category_id'] ) ? intval( $instance['category_id'] ) : 0;
			$order_by     = ! empty( $instance['order_by'] ) ? sanitize_text_field( $instance['order_by'] ) : 'rand';
			$custom_title = ! empty( $instance['title'] ) ? sanitize_text_field( $instance['title'] ) : '';

			// If category is 0 / random, select a random category
			if ( $cat_id <= 0 ) {
				$all_categories = get_categories(
					array(
						'hide_empty' => true,
					)
				);
				if ( empty( $all_categories ) ) {
					$all_categories = get_categories(
						array(
							'hide_empty' => false,
						)
					);
				}
				if ( ! empty( $all_categories ) ) {
					// Select category randomly
					$random_cat = $all_categories[ array_rand( $all_categories ) ];
					$cat_id     = $random_cat->term_id;
				}
			}

			// Retrieve category object
			$category = get_category( $cat_id );

			if ( ! empty( $custom_title ) ) {
				$display_title = $custom_title;
			} elseif ( $category && ! is_wp_error( $category ) ) {
				$display_title = $category->name;
			} else {
				$display_title = __( 'Thể thao', 'twentytwentyone' );
			}

			$cat_link = ( $category && ! is_wp_error( $category ) ) ? get_category_link( $category->term_id ) : '#';

			// Query 3 posts from category
			$query_args = array(
				'posts_per_page'      => 3,
				'post_status'         => 'publish',
				'ignore_sticky_posts' => true,
			);

			if ( $cat_id > 0 ) {
				$query_args['cat'] = $cat_id;
			}

			if ( 'rand' === $order_by ) {
				$query_args['orderby'] = 'rand';
			} else {
				$query_args['orderby'] = 'date';
				$query_args['order']   = 'DESC';
			}

			$posts_query = new WP_Query( $query_args );
			$posts       = $posts_query->posts;
			wp_reset_postdata();

			$default_football_img = get_template_directory_uri() . '/assets/images/football.jpg';

			// Fallback sample posts matching user screenshot exact data
			$sample_posts = array(
				array(
					'title'   => 'Bóng đá',
					'excerpt' => 'Nội dung tóm tắt bài viết Bóng đá...',
					'link'    => '#',
					'thumb'   => $default_football_img,
				),
				array(
					'title'   => 'FIT-TDC TỔ CHỨC BUỔI LIVESTREAM CHÀO ĐÓN TÂN SINH VIÊN FIT-TDC KHÓA 2021',
					'excerpt' => '',
					'link'    => '#',
					'thumb'   => '',
				),
				array(
					'title'   => 'Thành công',
					'excerpt' => '',
					'link'    => '#',
					'thumb'   => '',
				),
			);

			$display_items = array();
			for ( $i = 0; $i < 3; $i++ ) {
				if ( isset( $posts[ $i ] ) ) {
					$p         = $posts[ $i ];
					$thumb_id  = get_post_thumbnail_id( $p->ID );
					$thumb_url = '';
					if ( $thumb_id ) {
						$img_src = wp_get_attachment_image_src( $thumb_id, 'medium' );
						if ( $img_src ) {
							$thumb_url = $img_src[0];
						}
					}
					if ( empty( $thumb_url ) && 0 === $i ) {
						$thumb_url = $default_football_img;
					}

					$excerpt = get_the_excerpt( $p->ID );
					if ( empty( $excerpt ) ) {
						$excerpt = wp_trim_words( strip_shortcodes( $p->post_content ), 20, '...' );
					}

					$display_items[] = array(
						'title'   => get_the_title( $p->ID ),
						'excerpt' => $excerpt,
						'link'    => get_permalink( $p->ID ),
						'thumb'   => $thumb_url,
					);
				} else {
					$display_items[] = $sample_posts[ $i ];
				}
			}

			// Output Widget Markup matching exact mockup layout
			?>
			<div class="widget-test-4-card">
				<!-- Widget Header -->
				<div class="widget-test-4-header">
					<span class="widget-test-4-red-bar"></span>
					<h3 class="widget-test-4-cat-name">
						<a href="<?php echo esc_url( $cat_link ); ?>"><?php echo esc_html( $display_title ); ?></a>
					</h3>
				</div>
				<div class="widget-test-4-header-line"></div>

				<!-- Main Top Article -->
				<?php $main_item = $display_items[0]; ?>
				<div class="widget-test-4-top-post">
					<div class="widget-test-4-thumb-wrapper">
						<a href="<?php echo esc_url( $main_item['link'] ); ?>">
							<?php if ( ! empty( $main_item['thumb'] ) ) : ?>
								<img src="<?php echo esc_url( $main_item['thumb'] ); ?>" alt="<?php echo esc_attr( $main_item['title'] ); ?>" class="widget-test-4-img" />
							<?php else : ?>
								<img src="<?php echo esc_url( $default_football_img ); ?>" alt="<?php echo esc_attr( $main_item['title'] ); ?>" class="widget-test-4-img" />
							<?php endif; ?>
						</a>
					</div>
					<div class="widget-test-4-top-content">
						<h4 class="widget-test-4-top-title">
							<a href="<?php echo esc_url( $main_item['link'] ); ?>"><?php echo esc_html( $main_item['title'] ); ?></a>
						</h4>
						<?php if ( ! empty( $main_item['excerpt'] ) ) : ?>
							<p class="widget-test-4-top-sapo"><?php echo esc_html( $main_item['excerpt'] ); ?></p>
						<?php endif; ?>
					</div>
				</div>

				<!-- Horizontal Dotted Divider -->
				<div class="widget-test-4-dotted-divider"></div>

				<!-- Bottom 2-Column Articles -->
				<div class="widget-test-4-bottom-grid">
					<!-- Left Column -->
					<?php $sub_item1 = $display_items[1]; ?>
					<div class="widget-test-4-col widget-test-4-col-left">
						<h5 class="widget-test-4-sub-title">
							<a href="<?php echo esc_url( $sub_item1['link'] ); ?>"><?php echo esc_html( $sub_item1['title'] ); ?></a>
						</h5>
					</div>

					<!-- Right Column -->
					<?php $sub_item2 = $display_items[2]; ?>
					<div class="widget-test-4-col widget-test-4-col-right">
						<h5 class="widget-test-4-sub-title">
							<a href="<?php echo esc_url( $sub_item2['link'] ); ?>"><?php echo esc_html( $sub_item2['title'] ); ?></a>
						</h5>
					</div>
				</div>
			</div>
			<?php

			echo isset( $args['after_widget'] ) ? $args['after_widget'] : '</div>';
		}

		/**
		 * Admin Form
		 */
		public function form( $instance ) {
			$title       = ! empty( $instance['title'] ) ? $instance['title'] : '';
			$category_id = ! empty( $instance['category_id'] ) ? $instance['category_id'] : '0';
			$order_by    = ! empty( $instance['order_by'] ) ? $instance['order_by'] : 'rand';

			$categories = get_categories( array( 'hide_empty' => false ) );
			?>
			<p>
				<label for="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>"><?php esc_html_e( 'Tiêu đề Tùy Chọn (Để trống để tự động lấy tên Category):', 'twentytwentyone' ); ?></label>
				<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'title' ) ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" placeholder="VD: Thể thao" />
			</p>
			<p>
				<label for="<?php echo esc_attr( $this->get_field_id( 'category_id' ) ); ?>"><?php esc_html_e( 'Chọn Chuyên mục (Category):', 'twentytwentyone' ); ?></label>
				<select class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'category_id' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'category_id' ) ); ?>">
					<option value="0" <?php selected( $category_id, '0' ); ?>><?php esc_html_e( '-- Ngẫu nhiên (Random Category) --', 'twentytwentyone' ); ?></option>
					<?php foreach ( $categories as $cat ) : ?>
						<option value="<?php echo esc_attr( $cat->term_id ); ?>" <?php selected( $category_id, $cat->term_id ); ?>>
							<?php echo esc_html( $cat->name ); ?> (<?php echo esc_html( $cat->count ); ?> bài)
						</option>
					<?php endforeach; ?>
				</select>
			</p>
			<p>
				<label for="<?php echo esc_attr( $this->get_field_id( 'order_by' ) ); ?>"><?php esc_html_e( 'Thứ tự sắp xếp bài viết:', 'twentytwentyone' ); ?></label>
				<select class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'order_by' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'order_by' ) ); ?>">
					<option value="rand" <?php selected( $order_by, 'rand' ); ?>><?php esc_html_e( 'Ngẫu nhiên (Random)', 'twentytwentyone' ); ?></option>
					<option value="date" <?php selected( $order_by, 'date' ); ?>><?php esc_html_e( 'Mới nhất (Latest)', 'twentytwentyone' ); ?></option>
				</select>
			</p>
			<?php
		}

		/**
		 * Save Widget Options
		 */
		public function update( $new_instance, $old_instance ) {
			$instance                = array();
			$instance['title']       = ! empty( $new_instance['title'] ) ? sanitize_text_field( $new_instance['title'] ) : '';
			$instance['category_id'] = ! empty( $new_instance['category_id'] ) ? sanitize_text_field( $new_instance['category_id'] ) : '0';
			$instance['order_by']    = ! empty( $new_instance['order_by'] ) ? sanitize_text_field( $new_instance['order_by'] ) : 'rand';
			return $instance;
		}
	}
}

