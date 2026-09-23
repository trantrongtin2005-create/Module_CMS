<?php
/**
 * The template for displaying the footer
 *
 * Contains the closing of the #content div and all content after.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package WordPress
 * @subpackage Twenty_Twenty_One
 * @since Twenty Twenty-One 1.0
 */

?>
			</main><!-- #main -->
		</div><!-- #primary -->
	</div><!-- #content -->

	<?php get_template_part( 'template-parts/footer/footer-widgets' ); ?>

	<footer id="colophon" class="site-footer">

			<!-- ===================== MODULE 3: FOOTER ===================== -->
		<div id="module-footer">

			<!-- Quick Links columns -->
		<div class="footer-top">

			<!-- Column 1: lấy từ Menu "Footer Column 1" trong Appearance > Menus -->
			<div class="footer-col">
				<h4><?php esc_html_e( 'Quick links', 'twentytwentyone' ); ?></h4>
				<?php
				if ( has_nav_menu( 'footer-col-1' ) ) {
					wp_nav_menu(
						array(
							'theme_location' => 'footer-col-1',
							'menu_class'     => '',
							'container'      => false,
							'depth'          => 1,
							'fallback_cb'    => false,
						)
					);
				} else {
					// Fallback khi chưa gán menu
					?>
					<ul>
						<li><a href="<?php echo esc_url( home_url( '/' ) ); ?>">Home</a></li>
						<li><a href="<?php echo esc_url( home_url( '/about' ) ); ?>">About</a></li>
						<li><a href="<?php echo esc_url( home_url( '/faq' ) ); ?>">FAQ</a></li>
						<li><a href="<?php echo esc_url( home_url( '/get-started' ) ); ?>">Get Started</a></li>
						<li><a href="<?php echo esc_url( home_url( '/videos' ) ); ?>">Videos</a></li>
					</ul>
					<?php
				}
				?>
			</div>

			<!-- Column 2: lấy từ Menu "Footer Column 2" trong Appearance > Menus -->
			<div class="footer-col">
				<h4><?php esc_html_e( 'Quick links', 'twentytwentyone' ); ?></h4>
				<?php
				if ( has_nav_menu( 'footer-col-2' ) ) {
					wp_nav_menu(
						array(
							'theme_location' => 'footer-col-2',
							'menu_class'     => '',
							'container'      => false,
							'depth'          => 1,
							'fallback_cb'    => false,
						)
					);
				} else {
					?>
					<ul>
						<li><a href="<?php echo esc_url( home_url( '/' ) ); ?>">Home</a></li>
						<li><a href="<?php echo esc_url( home_url( '/about' ) ); ?>">About</a></li>
						<li><a href="<?php echo esc_url( home_url( '/faq' ) ); ?>">FAQ</a></li>
						<li><a href="<?php echo esc_url( home_url( '/get-started' ) ); ?>">Get Started</a></li>
						<li><a href="<?php echo esc_url( home_url( '/videos' ) ); ?>">Videos</a></li>
					</ul>
					<?php
				}
				?>
			</div>

			<!-- Column 3: lấy từ Menu "Footer Column 3" trong Appearance > Menus -->
			<div class="footer-col">
				<h4><?php esc_html_e( 'Quick links', 'twentytwentyone' ); ?></h4>
				<?php
				if ( has_nav_menu( 'footer-col-3' ) ) {
					wp_nav_menu(
						array(
							'theme_location' => 'footer-col-3',
							'menu_class'     => '',
							'container'      => false,
							'depth'          => 1,
							'fallback_cb'    => false,
						)
					);
				} else {
					?>
					<ul>
						<li><a href="<?php echo esc_url( home_url( '/' ) ); ?>">Home</a></li>
						<li><a href="<?php echo esc_url( home_url( '/about' ) ); ?>">About</a></li>
						<li><a href="<?php echo esc_url( home_url( '/faq' ) ); ?>">FAQ</a></li>
						<li><a href="<?php echo esc_url( home_url( '/get-started' ) ); ?>">Get Started</a></li>
						<li><a href="<?php echo esc_url( home_url( '/imprint' ) ); ?>">Imprint</a></li>
					</ul>
					<?php
				}
				?>
			</div>

		</div><!-- .footer-top -->
				<hr class="footer-divider">

			<!-- Social icons -->
			<div class="footer-social">
				<a href="#" aria-label="Facebook"><i class="fab fa-facebook-f"></i></a>
				<a href="#" aria-label="Twitter"><i class="fab fa-twitter"></i></a>
				<a href="#" aria-label="Instagram"><i class="fab fa-instagram"></i></a>
				<a href="#" aria-label="Google Plus"><i class="fab fa-google-plus-g"></i></a>
				<a href="#" aria-label="Email"><i class="fas fa-envelope"></i></a>
			</div><!-- .footer-social -->

			<!-- Copyright -->
			<div class="footer-bottom">
				<a href="http://www.ntc.com/" target="_blank" rel="noopener">National Transaction Corporation</a>
				is a Registered MSP/ISO of Elavon, Inc. Georgia [a wholly owned subsidiary of U.S. Bancorp, Minneapolis, MN]<br>
				&copy; All right Reserved. Sunlrmltech
			</div><!-- .footer-bottom -->
			</div><!-- #module-footer -->
		<!-- ===================== END MODULE 3 ===================== -->

	</footer><!-- #colophon -->

</div><!-- #page -->

<?php wp_footer(); ?>

</body>
</html>
