<?php
/**
 * The searchform.php template.
 *
 * Used any time that get_search_form() is called.
 *
 * @link https://developer.wordpress.org/reference/functions/wp_unique_id/
 * @link https://developer.wordpress.org/reference/functions/get_search_form/
 *
 * @package WordPress
 * @subpackage Twenty_Twenty_One
 * @since Twenty Twenty-One 1.0
 */

/*
 * Generate a unique ID for each form and a string containing an aria-label
 * if one was passed to get_search_form() in the args array.
 */
$twentytwentyone_unique_id = wp_unique_id( 'search-form-' );

$twentytwentyone_aria_label = ! empty( $args['aria_label'] ) ? 'aria-label="' . esc_attr( $args['aria_label'] ) . '"' : '';
$twentytwentyone_placeholder = ! empty( $args['placeholder'] ) ? $args['placeholder'] : __( 'Search topics or keywords', 'twentytwentyone' );
?>
<div class="custom-search-container">
	<form role="search" <?php echo $twentytwentyone_aria_label; ?> method="get" class="search-form custom-search-form" action="<?php echo esc_url( home_url( '/' ) ); ?>">
		<label for="<?php echo esc_attr( $twentytwentyone_unique_id ); ?>" class="screen-reader-text"><?php _e( 'Search&hellip;', 'twentytwentyone' ); ?></label>
		<div class="search-input-wrapper">
			<svg class="search-icon" xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
				<circle cx="11" cy="11" r="8"></circle>
				<line x1="21" y1="21" x2="16.65" y2="16.65"></line>
			</svg>
			<input type="search" id="<?php echo esc_attr( $twentytwentyone_unique_id ); ?>" class="search-field" placeholder="<?php echo esc_attr( $twentytwentyone_placeholder ); ?>" value="<?php echo get_search_query(); ?>" name="s" />
		</div>
		<button type="submit" class="search-submit"><?php echo esc_html_x( 'Search', 'submit button', 'twentytwentyone' ); ?></button>
	</form>
</div>
