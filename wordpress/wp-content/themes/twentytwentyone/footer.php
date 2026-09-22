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

	<footer id="colophon" class="site-footer gc-custom-footer">
		<div class="gc-footer-inner">
			<!-- Top 3 Columns: Quick Links -->
			<div class="gc-footer-columns">
				<!-- Column 1 -->
				<div class="gc-footer-col">
					<h4 class="gc-footer-heading"><span class="gc-footer-vbar">|</span> Quick links</h4>
					<ul class="gc-footer-links">
						<li><a href="<?php echo esc_url( home_url( '/' ) ); ?>">» Home</a></li>
						<li><a href="<?php echo esc_url( home_url( '/about/' ) ); ?>">» About</a></li>
						<li><a href="<?php echo esc_url( home_url( '/faq/' ) ); ?>">» FAQ</a></li>
						<li><a href="<?php echo esc_url( home_url( '/get-started/' ) ); ?>">» Get Started</a></li>
						<li><a href="<?php echo esc_url( home_url( '/videos/' ) ); ?>">» Videos</a></li>
					</ul>
				</div>

				<!-- Column 2 -->
				<div class="gc-footer-col">
					<h4 class="gc-footer-heading"><span class="gc-footer-vbar">|</span> Quick links</h4>
					<ul class="gc-footer-links">
						<li><a href="<?php echo esc_url( home_url( '/' ) ); ?>">» Home</a></li>
						<li><a href="<?php echo esc_url( home_url( '/about/' ) ); ?>">» About</a></li>
						<li><a href="<?php echo esc_url( home_url( '/faq/' ) ); ?>">» FAQ</a></li>
						<li><a href="<?php echo esc_url( home_url( '/get-started/' ) ); ?>">» Get Started</a></li>
						<li><a href="<?php echo esc_url( home_url( '/videos/' ) ); ?>">» Videos</a></li>
					</ul>
				</div>

				<!-- Column 3 -->
				<div class="gc-footer-col">
					<h4 class="gc-footer-heading"><span class="gc-footer-vbar">|</span> Quick links</h4>
					<ul class="gc-footer-links">
						<li><a href="<?php echo esc_url( home_url( '/' ) ); ?>">» Home</a></li>
						<li><a href="<?php echo esc_url( home_url( '/about/' ) ); ?>">» About</a></li>
						<li><a href="<?php echo esc_url( home_url( '/faq/' ) ); ?>">» FAQ</a></li>
						<li><a href="<?php echo esc_url( home_url( '/get-started/' ) ); ?>">» Get Started</a></li>
						<li><a href="<?php echo esc_url( home_url( '/imprint/' ) ); ?>">» Imprint</a></li>
					</ul>
				</div>
			</div>

			<!-- Middle Row: Social Icons -->
			<div class="gc-footer-social">
				<a href="#" class="gc-social-btn" title="Facebook">
					<svg width="20" height="20" viewBox="0 0 24 24" fill="currentColor"><path d="M18 2h-3a5 5 0 0 0-5 5v3H7v4h3v8h4v-8h3l1-4h-4V7a1 1 0 0 1 1-1h3z"/></svg>
				</a>
				<a href="#" class="gc-social-btn" title="Twitter">
					<svg width="20" height="20" viewBox="0 0 24 24" fill="currentColor"><path d="M23 3a10.9 10.9 0 0 1-3.14 1.53 4.48 4.48 0 0 0-7.86 3v1A10.66 10.66 0 0 1 3 4s-4 9 5 13a11.64 11.64 0 0 1-7 2c9 5 20 0 20-11.5a4.5 4.5 0 0 0-.08-.83A7.72 7.72 0 0 0 23 3z"/></svg>
				</a>
				<a href="#" class="gc-social-btn" title="Instagram">
					<svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="2" y="2" width="20" height="20" rx="5" ry="5"/><path d="M16 11.37A4 4 0 1 1 12.63 8 4 4 0 0 1 16 11.37z"/><line x1="17.5" y1="6.5" x2="17.51" y2="6.5"/></svg>
				</a>
				<a href="#" class="gc-social-btn" title="Google+">
					<span class="gc-gplus-icon">G+</span>
				</a>
				<a href="#" class="gc-social-btn" title="Email">
					<svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/><polyline points="22,6 12,13 2,6"/></svg>
				</a>
			</div>

			<!-- Bottom Section: Notice & Copyright -->
			<div class="gc-footer-bottom">
				<p class="gc-footer-notice">
					<a href="#" class="gc-notice-link">National Transaction Corporation</a> is a Registered MSP/ISO of Elavon, Inc. Georgia [a wholly owned subsidiary of U.S. Bancorp, Minneapolis, MN]
				</p>
				<p class="gc-footer-copyright">
					© All right Reversed. Sunlimetech
				</p>
			</div>
		</div>
	</footer><!-- #colophon -->


</div><!-- #page -->

<?php wp_footer(); ?>

</body>
</html>
