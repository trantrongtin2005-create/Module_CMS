<?php
/**
 * Displays the site header.
 *
 * @package WordPress
 * @subpackage Twenty_Twenty_One
 * @since Twenty Twenty-One 1.0
 */

$brand_text         = get_theme_mod( 'group_c_brand_text', 'Group C' );
$show_search_form   = get_theme_mod( 'group_c_show_search_form', true );
$search_placeholder = get_theme_mod( 'group_c_search_placeholder', 'Search' );
$search_btn_text    = get_theme_mod( 'group_c_search_button_text', 'Submit' );
$show_search_icon   = get_theme_mod( 'group_c_show_search_icon', true );
$show_account_menu  = get_theme_mod( 'group_c_show_account_menu', true );
$account_text       = get_theme_mod( 'group_c_account_text', 'Account' );

// Get category links safely using ?cat=ID query parameter to guarantee NO 404 on Apache
$cat_thethao  = get_category_by_slug( 'the-thao' );
$link_thethao = $cat_thethao ? home_url( '/?cat=' . $cat_thethao->term_id ) : home_url( '/?s=Thể+thao' );

$cat_khoahoc  = get_category_by_slug( 'khoa-hoc' );
$link_khoahoc = $cat_khoahoc ? home_url( '/?cat=' . $cat_khoahoc->term_id ) : home_url( '/?s=Khoa+học' );

$cat_tintuc  = get_category_by_slug( 'tin-tuc' );
$link_tintuc = $cat_tintuc ? home_url( '/?cat=' . $cat_tintuc->term_id ) : home_url( '/?s=Tin+tức' );
?>

<header id="masthead" class="site-header gc-custom-header">
	<div class="gc-header-container">
		<!-- Left Section: Brand + Full-height Home Tab + Inline Search Form -->
		<div class="gc-header-left">
			<div class="gc-brand">
				<a href="<?php echo esc_url( home_url( '/' ) ); ?>"><?php echo esc_html( $brand_text ); ?></a>
			</div>
			
			<a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="gc-home-tab <?php echo ( is_front_page() || is_home() ) ? 'is-active' : ''; ?>">
				<?php esc_html_e( 'Home', 'twentytwentyone' ); ?>
			</a>

			<?php if ( $show_search_form ) : ?>
				<form role="search" method="get" class="gc-inline-search-form" action="<?php echo esc_url( home_url( '/' ) ); ?>">
					<input type="search" class="gc-search-input" placeholder="<?php echo esc_attr( $search_placeholder ); ?>" value="<?php echo get_search_query(); ?>" name="s" required />
					<button type="submit" class="gc-search-submit-btn"><?php echo esc_html( $search_btn_text ); ?></button>
				</form>
			<?php endif; ?>
		</div>

		<!-- Right Section: Navigation Links + Menu Icon + Search Icon + Account Dropdown -->
		<div class="gc-header-right">
			<?php if ( has_nav_menu( 'primary' ) ) : ?>
				<?php
				wp_nav_menu(
					array(
						'theme_location'  => 'primary',
						'menu_class'      => 'gc-menu-list',
						'container'       => 'nav',
						'container_class' => 'gc-primary-nav',
						'fallback_cb'     => false,
					)
				);
				?>
			<?php else : ?>
				<nav class="gc-primary-nav">
					<ul class="gc-menu-list">
						<li><a href="<?php echo esc_url( $link_thethao ); ?>">Thể thao</a></li>
						<li><a href="<?php echo esc_url( $link_khoahoc ); ?>">Khoa học</a></li>
						<li><a href="<?php echo esc_url( $link_tintuc ); ?>">Tin tức</a></li>
					</ul>
				</nav>
			<?php endif; ?>

			<div class="gc-header-actions">
				<a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="gc-action-item gc-menu-trigger" title="Menu">
					<svg class="gc-icon-svg" width="22" height="12" viewBox="0 0 24 8" fill="#444444">
						<circle cx="4" cy="4" r="3.2" />
						<circle cx="12" cy="4" r="3.2" />
						<circle cx="20" cy="4" r="3.2" />
					</svg>
					<span class="gc-action-label">Menu</span>
				</a>

				<?php if ( $show_search_icon ) : ?>
					<a href="<?php echo esc_url( home_url( '/?s=' ) ); ?>" class="gc-action-item gc-search-trigger" onclick="var inp = document.querySelector('.gc-search-input'); if(inp){ inp.focus(); } return false;" title="Tìm kiếm">
						<svg class="gc-icon-svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#444444" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
							<circle cx="11" cy="11" r="7.5"></circle>
							<line x1="21" y1="21" x2="16.5" y2="16.5"></line>
						</svg>
						<span class="gc-action-label">Search</span>
					</a>
				<?php endif; ?>

				<?php if ( $show_account_menu ) : ?>
					<div class="gc-account-menu-wrapper">
						<a href="#" class="gc-action-item gc-account-trigger" onclick="var drop = this.nextElementSibling; if(drop){ drop.classList.toggle('is-open'); } return false;" title="Tài khoản">
							<svg class="gc-account-avatar-icon" width="28" height="28" viewBox="0 0 24 24" fill="none">
								<circle cx="12" cy="12" r="10" stroke="#555555" stroke-width="1.6" fill="none"/>
								<circle cx="12" cy="9.5" r="3.2" fill="#555555"/>
								<path d="M6.8 18.2c0-2.8 2.3-4.2 5.2-4.2s5.2 1.4 5.2 4.2" fill="#555555"/>
							</svg>
							<span class="gc-account-label"><?php echo esc_html( $account_text ); ?> ▾</span>
						</a>
						<div class="gc-account-dropdown">
							<?php if ( is_user_logged_in() ) : ?>
								<?php $current_user = wp_get_current_user(); ?>
								<div class="gc-dropdown-user">
									<strong><?php echo esc_html( $current_user->display_name ); ?></strong>
								</div>
								<a href="<?php echo esc_url( admin_url() ); ?>">Dashboard Quản trị</a>
								<a href="<?php echo esc_url( wp_logout_url( home_url() ) ); ?>">Đăng xuất</a>
							<?php else : ?>
								<a href="<?php echo esc_url( wp_login_url( home_url() ) ); ?>">Đăng nhập</a>
							<?php endif; ?>
						</div>
					</div>
				<?php endif; ?>
			</div>
		</div>
	</div>
</header><!-- #masthead -->




