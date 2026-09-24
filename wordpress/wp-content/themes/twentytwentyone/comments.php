<?php
/**
 * The template for displaying comments
 *
 * @package WordPress
 * @subpackage Twenty_Twenty_One
 * @since Twenty Twenty-One 1.0
 */

if ( post_password_required() ) {
	return;
}

$twenty_twenty_one_comment_count = get_comments_number();
?>

<div id="comments" class="comments-area default-max-width <?php echo get_option( 'show_avatars' ) ? 'show-avatars' : ''; ?>">

	<?php if ( have_comments() ) : ?>

		<h2 class="comments-title">

			<?php if ( 1 === $twenty_twenty_one_comment_count ) : ?>

				<?php esc_html_e( '1 comment', 'twentytwentyone' ); ?>

			<?php else : ?>

				<?php
				printf(
					esc_html(
						_nx(
							'%s comment',
							'%s comments',
							$twenty_twenty_one_comment_count,
							'Comments title',
							'twentytwentyone'
						)
					),
					esc_html(
						number_format_i18n( $twenty_twenty_one_comment_count )
					)
				);
				?>

			<?php endif; ?>

		</h2>

		<ol class="comment-list">

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
				'before_page_number' => esc_html__( 'Page', 'twentytwentyone' ) . ' ',
				'mid_size'           => 0,

				'prev_text' => sprintf(
					'%s <span class="nav-prev-text">%s</span>',
					is_rtl()
						? twenty_twenty_one_get_icon_svg( 'ui', 'arrow_right' )
						: twenty_twenty_one_get_icon_svg( 'ui', 'arrow_left' ),
					esc_html__( 'Older comments', 'twentytwentyone' )
				),

				'next_text' => sprintf(
					'<span class="nav-next-text">%s</span> %s',
					esc_html__( 'Newer comments', 'twentytwentyone' ),
					is_rtl()
						? twenty_twenty_one_get_icon_svg( 'ui', 'arrow_left' )
						: twenty_twenty_one_get_icon_svg( 'ui', 'arrow_right' )
				),
			)
		);
		?>

		<?php if ( ! comments_open() ) : ?>

			<p class="no-comments">
				<?php esc_html_e( 'Comments are closed.', 'twentytwentyone' ); ?>
			</p>

		<?php endif; ?>

	<?php endif; ?>


	<?php
	comment_form(
		array(
			'title_reply'        => esc_html__( 'Leave a comment', 'twentytwentyone' ),
			'title_reply_before' => '<h2 id="reply-title" class="comment-reply-title">',
			'title_reply_after'  => '</h2>',
		)
	);
	?>

</div><!-- #comments -->