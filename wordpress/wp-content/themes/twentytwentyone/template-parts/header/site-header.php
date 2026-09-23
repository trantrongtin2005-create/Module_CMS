<?php
/**
 * Displays the site header - MODULE 1
 *
 * @package WordPress
 * @subpackage Twenty_Twenty_One
 * @since Twenty Twenty-One 1.0
 */
?>

<!-- ===================== MODULE 1: HEADER ===================== -->
<header id="module-header">
	<div class="header-container">

		<!-- Left Section: Brand, Home, Search -->
		<div class="header-left">
			<!-- Brand / Group Name -->
			<a class="header-brand" href="<?php echo esc_url( home_url( '/' ) ); ?>">
				<?php
				if ( has_custom_logo() ) {
					the_custom_logo();
				} else {
					$site_title = get_bloginfo( 'name' );
					echo esc_html( ! empty( $site_title ) ? $site_title : 'Group C' );
				}
				?>
			</a>

			<!-- Home tab button -->
			<a class="header-home-btn <?php echo ( is_front_page() || is_home() ) ? 'active' : ''; ?>" href="<?php echo esc_url( home_url( '/' ) ); ?>">
				<?php esc_html_e( 'Home', 'twentytwentyone' ); ?>
			</a>

			<!-- Search Form: Gửi query 's' để ra trang kết quả tìm kiếm -->
			<form class="header-search-form" role="search" method="get" action="<?php echo esc_url( home_url( '/' ) ); ?>">
				<input
					type="search"
					name="s"
					id="header-search-box"
					placeholder="Search"
					value="<?php echo esc_attr( get_search_query() ); ?>"
					aria-label="Search"
				/>
				<button type="submit" id="header-search-submit">
					Submit
				</button>
			</form>
		</div><!-- .header-left -->

		<!-- Right Section: Menu Links, Menu Icon, Search Icon, Account Dropdown -->
		<div class="header-right">

			<!-- Primary Nav Links -->
			<nav class="header-nav-links" aria-label="Main Navigation">
				<?php
				if ( has_nav_menu( 'primary' ) ) {
					wp_nav_menu(
						array(
							'theme_location' => 'primary',
							'menu_class'     => 'nav-list',
							'container'      => false,
							'depth'          => 1,
							'fallback_cb'    => false,
						)
					);
				} else {
					// Fallback mặc định theo hình mẫu bài tập
					?>
					<ul class="nav-list">
						<li><a href="#">Thể thao</a></li>
						<li><a href="#">Khoa học</a></li>
						<li><a href="#">Tin tức</a></li>
					</ul>
					<?php
				}
				?>
			</nav>

			<!-- Menu icon button: 3 chấm + nhãn Menu (không xử lý theo đề bài) -->
			<div class="header-action-item">
				<button type="button" class="btn-action-icon" aria-label="Menu">
					<i class="fa-solid fa-ellipsis"></i>
					<span>Menu</span>
				</button>
			</div>

			<!-- Search icon button: kính lúp + nhãn Search (focus vào ô tìm kiếm) -->
			<div class="header-action-item">
				<button type="button" class="btn-action-icon" aria-label="Search" onclick="var s = document.getElementById('header-search-box'); if(s) { s.focus(); s.scrollIntoView({behavior: 'smooth', block: 'center'}); }">
					<i class="fa-solid fa-magnifying-glass"></i>
					<span>Search</span>
				</button>
			</div>

			<!-- Account Dropdown (theo Bootstrap dropdown) -->
			<div class="header-action-item account-dropdown-wrapper">
				<button type="button" class="btn-action-icon btn-account" id="accountDropdownBtn" aria-expanded="false" aria-haspopup="true">
					<i class="fa-solid fa-circle-user account-avatar-icon"></i>
					<span class="account-label">
						Account <i class="fa-solid fa-caret-down"></i>
					</span>
				</button>

				<!-- Dropdown Menu -->
				<div class="account-menu" id="accountDropdownMenu">
					<?php if ( is_user_logged_in() ) : ?>
						<?php
						$current_user = wp_get_current_user();
						?>
						<div class="account-user-info">
							<strong><?php echo esc_html( $current_user->display_name ); ?></strong>
						</div>
						<div class="dropdown-divider"></div>
						<a href="<?php echo esc_url( admin_url() ); ?>" class="account-menu-item">
							<i class="fa-solid fa-gauge-high"></i> Dashboard
						</a>
						<a href="<?php echo esc_url( get_edit_profile_url() ); ?>" class="account-menu-item">
							<i class="fa-solid fa-user-pen"></i> Profile
						</a>
						<div class="dropdown-divider"></div>
						<a href="<?php echo esc_url( wp_logout_url( home_url() ) ); ?>" class="account-menu-item text-danger">
							<i class="fa-solid fa-right-from-bracket"></i> Logout
						</a>
					<?php else : ?>
						<a href="<?php echo esc_url( wp_login_url() ); ?>" class="account-menu-item">
							<i class="fa-solid fa-arrow-right-to-bracket"></i> Login
						</a>
						<a href="<?php echo esc_url( wp_registration_url() ); ?>" class="account-menu-item">
							<i class="fa-solid fa-user-plus"></i> Register
						</a>
					<?php endif; ?>
				</div>
			</div><!-- .account-dropdown-wrapper -->

		</div><!-- .header-right -->

	</div><!-- .header-container -->
</header><!-- #module-header -->

<!-- Script xử lý click dropdown Account -->
<script>
document.addEventListener('DOMContentLoaded', function () {
	var accountBtn = document.getElementById('accountDropdownBtn');
	var accountMenu = document.getElementById('accountDropdownMenu');

	if (accountBtn && accountMenu) {
		accountBtn.addEventListener('click', function (e) {
			e.stopPropagation();
			var isOpen = accountMenu.classList.contains('show');
			if (isOpen) {
				accountMenu.classList.remove('show');
				accountBtn.setAttribute('aria-expanded', 'false');
			} else {
				accountMenu.classList.add('show');
				accountBtn.setAttribute('aria-expanded', 'true');
			}
		});

		// Đóng dropdown khi click ra ngoài
		document.addEventListener('click', function (e) {
			if (!accountMenu.contains(e.target) && !accountBtn.contains(e.target)) {
				accountMenu.classList.remove('show');
				accountBtn.setAttribute('aria-expanded', 'false');
			}
		});
	}
});
</script>
<!-- ===================== END MODULE 1 ===================== -->

<?php
// Giữ lại header gốc Twenty Twenty-One ở trạng thái ẩn để các hook & accessibility của theme không bị lỗi
$wrapper_classes  = 'site-header';
$wrapper_classes .= has_custom_logo() ? ' has-logo' : '';
$wrapper_classes .= ( true === get_theme_mod( 'display_title_and_tagline', true ) ) ? ' has-title-and-tagline' : '';
$wrapper_classes .= has_nav_menu( 'primary' ) ? ' has-menu' : '';
?>
<header id="masthead" class="<?php echo esc_attr( $wrapper_classes ); ?>" aria-hidden="true" style="display:none !important;">
	<?php get_template_part( 'template-parts/header/site-branding' ); ?>
	<?php get_template_part( 'template-parts/header/site-nav' ); ?>
</header><!-- #masthead -->
