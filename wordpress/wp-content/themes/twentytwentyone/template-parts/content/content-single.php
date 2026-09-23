<?php
/**
 * Template part for displaying single posts - MODULE 6
 * Theo mẫu: badge vàng tròn, nền xám, excerpt italic, nguồn góc phải
 *
 * @package WordPress
 * @subpackage Twenty_Twenty_One
 */
?>

<div class="module6-article-wrapper">
<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

	<div class="module6-article-card">

		<!-- ===== Header: Tiêu đề + Date Badge vàng + Nút 3 chấm ===== -->
		<div class="module6-card-header">

			<!-- Tiêu đề bài viết -->
			<?php the_title( '<h1 class="module6-title">', '</h1>' ); ?>

			<!-- Nhóm badge ngày + nút 3 chấm -->
			<div class="module6-badge-group">

				<!-- Date badge vàng tròn: ngày / tháng / năm -->
				<div class="module6-date-badge" title="<?php echo esc_attr( get_the_date( 'd/m/Y' ) ); ?>">
					<span class="badge-day"><?php echo esc_html( get_the_date( 'd' ) ); ?></span>
					<span class="badge-month"><?php echo esc_html( get_the_date( 'm' ) ); ?></span>
					<span class="badge-year"><?php echo esc_html( get_the_date( 'y' ) ); ?></span>
				</div>

				<!-- Nút 3 chấm dọc ⋮ -->
				<button class="module6-more-btn" type="button" aria-label="More options">
					<span></span>
					<span></span>
					<span></span>
				</button>

			</div>

		</div><!-- .module6-card-header -->

		<!-- ===== Hình ảnh đại diện ===== -->
		<?php if ( has_post_thumbnail() ) : ?>
			<div class="module6-thumbnail">
				<?php the_post_thumbnail( 'large', array( 'alt' => get_the_title() ) ); ?>
			</div>
		<?php endif; ?>

		<!-- ===== Excerpt / Đoạn mở đầu in nghiêng ===== -->
		<?php if ( has_excerpt() ) : ?>
			<div class="module6-excerpt">
				<?php echo wp_kses_post( get_the_excerpt() ); ?>
			</div>
		<?php endif; ?>

		<!-- ===== Nội dung bài viết ===== -->
		<div class="module6-content entry-content">
			<?php
			the_content();

			wp_link_pages(
				array(
					'before'   => '<nav class="page-links" aria-label="' . esc_attr__( 'Page', 'twentytwentyone' ) . '">',
					'after'    => '</nav>',
					'pagelink' => esc_html__( 'Page %', 'twentytwentyone' ),
				)
			);
			?>
		</div><!-- .module6-content -->

		<!-- ===== Nguồn trích dẫn (Theo Người Lao Động) ===== -->
		<?php
		// Lưu nguồn vào Custom Field tên '_post_source' trong wp-admin
		$post_source = get_post_meta( get_the_ID(), '_post_source', true );
		if ( ! empty( $post_source ) ) :
		?>
			<div class="module6-source">
				(<?php echo esc_html( $post_source ); ?>)
			</div>
		<?php endif; ?>

	</div><!-- .module6-article-card -->

	<!-- ===== Meta Footer: Categories & Tags ===== -->
	<footer class="module6-meta-footer entry-footer">
		<?php
		$categories = get_the_category();
		if ( $categories ) {
			echo '<span><strong>' . esc_html__( 'Danh mục:', 'twentytwentyone' ) . '</strong>';
			foreach ( $categories as $cat ) {
				echo ' <a href="' . esc_url( get_category_link( $cat->term_id ) ) . '">' . esc_html( $cat->name ) . '</a>';
			}
			echo '</span>';
		}

		$tags = get_the_tags();
		if ( $tags ) {
			echo '<br><span><strong>' . esc_html__( 'Tags:', 'twentytwentyone' ) . '</strong>';
			foreach ( $tags as $tag ) {
				echo ' <a href="' . esc_url( get_tag_link( $tag->term_id ) ) . '">' . esc_html( $tag->name ) . '</a>';
			}
			echo '</span>';
		}
		?>
	</footer>

</article>
</div><!-- .module6-article-wrapper -->
