<?php
/**
 * Template part for Categories Sidebar Widget (Module 9)
 * Styled matching wireframe layout.
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

<div class="module9-categories-widget">
	<h3 class="module9-widget-title">Categories</h3>
	<div class="module9-striped-divider"></div>
	<div class="module9-categories-box">
		<ul class="module9-categories-list">
			<?php
			if ( ! empty( $categories ) ) :
				foreach ( $categories as $cat ) :
			?>
				<li class="module9-cat-item">
					<span class="module9-cat-bullet">&#8226;</span>
					<a href="<?php echo esc_url( get_category_link( $cat->term_id ) ); ?>" class="module9-cat-link">
						<?php echo esc_html( $cat->name ); ?>
					</a>
				</li>
			<?php
				endforeach;
			else :
			?>
				<li class="module9-cat-item">
					<span class="module9-cat-bullet">&#8226;</span>
					<a href="#" class="module9-cat-link">.Net Developer</a>
				</li>
				<li class="module9-cat-item">
					<span class="module9-cat-bullet">&#8226;</span>
					<a href="#" class="module9-cat-link">Thực Tập Sinh Tester</a>
				</li>
				<li class="module9-cat-item">
					<span class="module9-cat-bullet">&#8226;</span>
					<a href="#" class="module9-cat-link">Trợ giảng lập trình - Part time</a>
				</li>
			<?php endif; ?>
		</ul>
	</div>
</div>
