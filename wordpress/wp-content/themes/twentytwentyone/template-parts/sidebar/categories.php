<?php
/**
 * Template part for Categories Sidebar Widget (Redesigned - Modern & Professional)
 *
 * @package WordPress
 * @subpackage Twenty_Twenty_One
 */

$categories = get_categories(
	array(
		'orderby'    => 'name',
		'order'      => 'ASC',
		'hide_empty' => false,
	)
);
?>

<div class="module9-categories-widget modern-categories-card">
	<div class="module9-widget-header">
		<span class="module9-header-accent"></span>
		<h3 class="module9-widget-title">Categories</h3>
	</div>
	<div class="module9-header-divider"></div>
	<div class="module9-categories-box">
		<ul class="module9-categories-list">
			<?php
			if ( ! empty( $categories ) && ! is_wp_error( $categories ) ) :
				foreach ( $categories as $cat ) :
			?>
				<li class="module9-cat-item">
					<a href="<?php echo esc_url( get_category_link( $cat->term_id ) ); ?>" class="module9-cat-link">
						<span class="module9-cat-bullet"></span>
						<span class="module9-cat-name"><?php echo esc_html( $cat->name ); ?></span>
						<?php if ( isset( $cat->count ) ) : ?>
							<span class="module9-cat-badge"><?php echo esc_html( $cat->count ); ?></span>
						<?php endif; ?>
					</a>
				</li>
			<?php
				endforeach;
			else :
			?>
				<li class="module9-cat-item">
					<a href="#" class="module9-cat-link">
						<span class="module9-cat-bullet"></span>
						<span class="module9-cat-name">Tin tức</span>
						<span class="module9-cat-badge">5</span>
					</a>
				</li>
				<li class="module9-cat-item">
					<a href="#" class="module9-cat-link">
						<span class="module9-cat-bullet"></span>
						<span class="module9-cat-name">Công nghệ</span>
						<span class="module9-cat-badge">3</span>
					</a>
				</li>
			<?php endif; ?>
		</ul>
	</div>
</div>
