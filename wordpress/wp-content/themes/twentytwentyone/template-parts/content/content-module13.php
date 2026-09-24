<?php
/**
 * Template part for displaying Module 13 post cards.
 *
 * @package WordPress
 * @subpackage Twenty_Twenty_One
 */
?>

<article
	id="post-<?php the_ID(); ?>"
	<?php post_class( 'module13-post-card' ); ?>
>

	<div class="module13-post-thumb">

		<a href="<?php the_permalink(); ?>">

			<?php if ( has_post_thumbnail() ) : ?>

				<?php the_post_thumbnail( 'medium_large' ); ?>

			<?php else : ?>

				<div class="module13-post-placeholder">

					<svg
						width="40"
						height="40"
						viewBox="0 0 24 24"
						fill="none"
						stroke="#94a3b8"
						stroke-width="1.5"
						stroke-linecap="round"
						stroke-linejoin="round"
						aria-hidden="true"
					>
						<rect
							x="3"
							y="3"
							width="18"
							height="18"
							rx="2"
						></rect>

						<circle
							cx="8.5"
							cy="8.5"
							r="1.5"
						></circle>

						<polyline
							points="21 15 16 10 5 21"
						></polyline>
					</svg>

				</div>

			<?php endif; ?>

		</a>

	</div>

	<div class="module13-post-content">

		<h2 class="module13-post-title">

			<a href="<?php the_permalink(); ?>">
				<?php the_title(); ?>
			</a>

		</h2>

		<div class="module13-post-excerpt">

			<?php
			$excerpt_text = get_the_excerpt();

			if ( empty( $excerpt_text ) ) {
				$excerpt_text = wp_trim_words(
					get_the_content(),
					25,
					'...'
				);
			}

			echo esc_html( $excerpt_text );
			?>

		</div>

	</div>

</article>