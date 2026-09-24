```php
<?php

/**
 * The template for displaying comments
 *
 * Module 12 / Comment System
 * Styled matching the Make a Post wireframe - Tiếng Việt.
 *
 * @package WordPress
 * @subpackage Twenty_Twenty_One
 */

if ( post_password_required() ) {
	return;
}

$user          = wp_get_current_user();
$user_identity = $user->exists() ? $user->display_name : '';

?>

<div id="comments" class="comments-area make-a-post-comments-wrapper">

	<!-- Make a Post Comment Card (Giao diện Tạo bài viết / Bình luận) -->
	<div class="make-a-post-card">

		<div class="make-a-post-tab-header">
			<div class="make-a-post-tab active">
				<span>Tạo bài viết</span>
			</div>
		</div>

		<div class="make-a-post-card-body">

			<?php

			$commenter = wp_get_current_commenter();
			$req       = get_option( 'require_name_email' );
			$aria_req  = $req ? " aria-required='true'" : '';

			$fields = array(
				'author' => '<div class="comment-form-author-email-row">
					<p class="comment-form-author">
						<input
							id="author"
							name="author"
							type="text"
							value="' . esc_attr( $commenter['comment_author'] ) . '"
							placeholder="Họ và tên' . ( $req ? ' *' : '' ) . '"
							size="30"' . $aria_req . '
						/>
					</p>',

				'email' => '<p class="comment-form-email">
						<input
							id="email"
							name="email"
							type="email"
							value="' . esc_attr( $commenter['comment_author_email'] ) . '"
							placeholder="Email' . ( $req ? ' *' : '' ) . '"
							size="30"' . $aria_req . '
						/>
					</p>
				</div>',
			);

			comment_form(
				array(
					'title_reply'          => '',
					'title_reply_before'   => '',
					'title_reply_after'    => '',
					'comment_notes_before' => '',
					'comment_notes_after'  => '',

					'logged_in_as' => '<p class="logged-in-as">' . sprintf(
						'Đã đăng nhập với tên <strong>%1$s</strong>. <a href="%2$s">Sửa hồ sơ</a>. <a href="%3$s">Đăng xuất?</a> Các trường bắt buộc được đánh dấu <span class="required">*</span>',
						esc_html( $user_identity ),
						esc_url( get_edit_profile_url() ),
						esc_url(
							wp_logout_url(
								apply_filters( 'the_permalink', get_permalink() )
							)
						)
					) . '</p>',

					'must_log_in' => '<p class="must-log-in">
						Bạn phải
						<a href="' . esc_url(
							wp_login_url(
								apply_filters( 'the_permalink', get_permalink() )
							)
						) . '">đăng nhập</a>
						để bình luận.
					</p>',

					'fields' => $fields,

					'comment_field' => '<div class="comment-form-textarea-wrapper">
						<textarea
							id="comment"
							name="comment"
							cols="45"
							rows="4"
							placeholder="Bạn đang nghĩ gì..."
							aria-required="true"
						></textarea>
					</div>',

					'class_form' => 'make-a-post-form',

					'submit_button' => '<div class="comment-form-submit-row">
						<button
							name="%1$s"
							type="submit"
							id="%2$s"
							class="%3$s make-a-post-submit-btn"
						>%4$s</button>
					</div>',

					'label_submit' => 'Chia sẻ',
				)
			);

			?>

		</div>
	</div>

	<!-- List of Posted Comments -->
	<?php if ( have_comments() ) : ?>

		<div class="make-a-post-comments-list-section">

			<h3 class="comments-count-heading">

				<?php

				$comment_count = get_comments_number();

				if ( 1 === (int) $comment_count ) {

					echo '1 bình luận';

				} else {

					printf(
						/* translators: %s: Comment count */
						esc_html(
							_nx(
								'%s bình luận',
								'%s bình luận',
								$comment_count,
								'Comments title',
								'twentytwentyone'
							)
						),
						esc_html(
							number_format_i18n( $comment_count )
						)
					);
				}

				?>

			</h3>

			<ol class="comment-list make-a-post-comment-list">

				<?php

				wp_list_comments(
					array(
						'avatar_size' => 50,
						'style'       => 'ol',
						'short_ping'  => true,
						'callback'    => 'dan_custom_comment',
					)
				);

				?>

			</ol><!-- .comment-list -->

			<?php

			the_comments_pagination(
				array(
					'before_page_number' => esc_html__( 'Trang', 'twentytwentyone' ) . ' ',
					'mid_size'           => 0,

					'prev_text' => sprintf(
						'%s <span class="nav-prev-text">%s</span>',
						is_rtl()
							? twenty_twenty_one_get_icon_svg( 'ui', 'arrow_right' )
							: twenty_twenty_one_get_icon_svg( 'ui', 'arrow_left' ),
						esc_html__( 'Bình luận cũ hơn', 'twentytwentyone' )
					),

					'next_text' => sprintf(
						'<span class="nav-next-text">%s</span> %s',
						esc_html__( 'Bình luận mới hơn', 'twentytwentyone' ),
						is_rtl()
							? twenty_twenty_one_get_icon_svg( 'ui', 'arrow_left' )
							: twenty_twenty_one_get_icon_svg( 'ui', 'arrow_right' )
					),
				)
			);

			?>

		</div>

	<?php endif; ?>

	<?php if ( ! comments_open() && get_comments_number() && post_type_supports( get_post_type(), 'comments' ) ) : ?>

		<p class="no-comments">
			<?php esc_html_e( 'Bình luận đã đóng.', 'twentytwentyone' ); ?>
		</p>

	<?php endif; ?>

</div><!-- #comments -->
```
