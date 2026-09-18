<?php
/**
 * Customizer settings for this theme.
 *
 * @package WordPress
 * @subpackage Twenty_Twenty_One
 * @since Twenty Twenty-One 1.0
 */

if ( ! class_exists( 'Twenty_Twenty_One_Customize' ) ) {
	/**
	 * Customizer Settings.
	 *
	 * @since Twenty Twenty-One 1.0
	 */
	class Twenty_Twenty_One_Customize {

		/**
		 * Constructor. Instantiates the object.
		 *
		 * @since Twenty Twenty-One 1.0
		 */
		public function __construct() {
			add_action( 'customize_register', array( $this, 'register' ) );
		}

		/**
		 * Registers customizer options.
		 *
		 * @since Twenty Twenty-One 1.0
		 *
		 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
		 * @return void
		 */
		public function register( $wp_customize ) {

			// Change site-title & description to postMessage.
			foreach ( array( 'blogname', 'blogdescription' ) as $setting_id ) {
				$setting = $wp_customize->get_setting( $setting_id );
				if ( $setting ) {
					$setting->transport = 'postMessage';
				}
			}

			// Add partial for blogname.
			$wp_customize->selective_refresh->add_partial(
				'blogname',
				array(
					'selector'        => '.site-title',
					'render_callback' => array( $this, 'partial_blogname' ),
				)
			);

			// Add partial for blogdescription.
			$wp_customize->selective_refresh->add_partial(
				'blogdescription',
				array(
					'selector'        => '.site-description',
					'render_callback' => array( $this, 'partial_blogdescription' ),
				)
			);

			// Add "display_title_and_tagline" setting for displaying the site-title & tagline.
			$wp_customize->add_setting(
				'display_title_and_tagline',
				array(
					'capability'        => 'edit_theme_options',
					'default'           => true,
					'sanitize_callback' => array( __CLASS__, 'sanitize_checkbox' ),
				)
			);

			// Add control for the "display_title_and_tagline" setting.
			$wp_customize->add_control(
				'display_title_and_tagline',
				array(
					'type'    => 'checkbox',
					'section' => 'title_tagline',
					'label'   => esc_html__( 'Display Site Title & Tagline', 'twentytwentyone' ),
				)
			);

			/**
			 * Add excerpt or full text selector to customizer
			 */
			$wp_customize->add_section(
				'excerpt_settings',
				array(
					'title'    => esc_html__( 'Excerpt Settings', 'twentytwentyone' ),
					'priority' => 120,
				)
			);

			$wp_customize->add_setting(
				'display_excerpt_or_full_post',
				array(
					'capability'        => 'edit_theme_options',
					'default'           => 'excerpt',
					'sanitize_callback' => static function ( $value ) {
						return 'excerpt' === $value || 'full' === $value ? $value : 'excerpt';
					},
				)
			);

			$wp_customize->add_control(
				'display_excerpt_or_full_post',
				array(
					'type'    => 'radio',
					'section' => 'excerpt_settings',
					'label'   => esc_html__( 'On Archive Pages, posts show:', 'twentytwentyone' ),
					'choices' => array(
						'excerpt' => esc_html__( 'Summary', 'twentytwentyone' ),
						'full'    => esc_html__( 'Full text', 'twentytwentyone' ),
					),
				)
			);

			// Background color.
			// Include the custom control class.
			require_once get_theme_file_path( 'classes/class-twenty-twenty-one-customize-color-control.php' );

			// Register the custom control.
			$wp_customize->register_control_type( 'Twenty_Twenty_One_Customize_Color_Control' );

			// Get the palette from theme-supports.
			$palette = get_theme_support( 'editor-color-palette' );

			// Build the colors array from theme-support.
			$colors = array();
			if ( isset( $palette[0] ) && is_array( $palette[0] ) ) {
				foreach ( $palette[0] as $palette_color ) {
					$colors[] = $palette_color['color'];
				}
			}

			// Add the control. Overrides the default background-color control.
			$wp_customize->add_control(
				new Twenty_Twenty_One_Customize_Color_Control(
					$wp_customize,
					'background_color',
					array(
						'label'   => esc_html_x( 'Background color', 'Customizer control', 'twentytwentyone' ),
						'section' => 'colors',
						'palette' => $colors,
					)
				)
			);

			/**
			 * Header & Navigation Settings (Group C Wireframe)
			 */
			$wp_customize->add_section(
				'group_c_header_settings',
				array(
					'title'    => esc_html__( 'Group C Header Settings', 'twentytwentyone' ),
					'priority' => 30,
				)
			);

			// Brand Text
			$wp_customize->add_setting(
				'group_c_brand_text',
				array(
					'capability'        => 'edit_theme_options',
					'default'           => 'Group C',
					'sanitize_callback' => 'sanitize_text_field',
				)
			);
			$wp_customize->add_control(
				'group_c_brand_text',
				array(
					'type'    => 'text',
					'section' => 'group_c_header_settings',
					'label'   => esc_html__( 'Brand / Site Name Text', 'twentytwentyone' ),
				)
			);

			// Display Inline Search Form
			$wp_customize->add_setting(
				'group_c_show_search_form',
				array(
					'capability'        => 'edit_theme_options',
					'default'           => true,
					'sanitize_callback' => array( __CLASS__, 'sanitize_checkbox' ),
				)
			);
			$wp_customize->add_control(
				'group_c_show_search_form',
				array(
					'type'    => 'checkbox',
					'section' => 'group_c_header_settings',
					'label'   => esc_html__( 'Display Inline Search Form', 'twentytwentyone' ),
				)
			);

			// Search Placeholder
			$wp_customize->add_setting(
				'group_c_search_placeholder',
				array(
					'capability'        => 'edit_theme_options',
					'default'           => 'Search',
					'sanitize_callback' => 'sanitize_text_field',
				)
			);
			$wp_customize->add_control(
				'group_c_search_placeholder',
				array(
					'type'    => 'text',
					'section' => 'group_c_header_settings',
					'label'   => esc_html__( 'Search Placeholder Text', 'twentytwentyone' ),
				)
			);

			// Search Submit Button Text
			$wp_customize->add_setting(
				'group_c_search_button_text',
				array(
					'capability'        => 'edit_theme_options',
					'default'           => 'Submit',
					'sanitize_callback' => 'sanitize_text_field',
				)
			);
			$wp_customize->add_control(
				'group_c_search_button_text',
				array(
					'type'    => 'text',
					'section' => 'group_c_header_settings',
					'label'   => esc_html__( 'Search Submit Button Text', 'twentytwentyone' ),
				)
			);

			// Show Search Icon Button
			$wp_customize->add_setting(
				'group_c_show_search_icon',
				array(
					'capability'        => 'edit_theme_options',
					'default'           => true,
					'sanitize_callback' => array( __CLASS__, 'sanitize_checkbox' ),
				)
			);
			$wp_customize->add_control(
				'group_c_show_search_icon',
				array(
					'type'    => 'checkbox',
					'section' => 'group_c_header_settings',
					'label'   => esc_html__( 'Display Right Search Icon', 'twentytwentyone' ),
				)
			);

			// Show Account Dropdown Menu
			$wp_customize->add_setting(
				'group_c_show_account_menu',
				array(
					'capability'        => 'edit_theme_options',
					'default'           => true,
					'sanitize_callback' => array( __CLASS__, 'sanitize_checkbox' ),
				)
			);
			$wp_customize->add_control(
				'group_c_show_account_menu',
				array(
					'type'    => 'checkbox',
					'section' => 'group_c_header_settings',
					'label'   => esc_html__( 'Display Account Dropdown Menu', 'twentytwentyone' ),
				)
			);

			// Account Button Text
			$wp_customize->add_setting(
				'group_c_account_text',
				array(
					'capability'        => 'edit_theme_options',
					'default'           => 'Account',
					'sanitize_callback' => 'sanitize_text_field',
				)
			);
			$wp_customize->add_control(
				'group_c_account_text',
				array(
					'type'    => 'text',
					'section' => 'group_c_header_settings',
					'label'   => esc_html__( 'Account Button Label', 'twentytwentyone' ),
				)
			);
		}

		/**
		 * Sanitizes a boolean for checkbox.
		 *
		 * @since Twenty Twenty-One 1.0
		 *
		 * @param bool $checked Whether or not a box is checked.
		 * @return bool
		 */
		public static function sanitize_checkbox( $checked = null ) {
			return (bool) isset( $checked ) && true === $checked;
		}

		/**
		 * Renders the site title for the selective refresh partial.
		 *
		 * @since Twenty Twenty-One 1.0
		 *
		 * @return void
		 */
		public function partial_blogname() {
			bloginfo( 'name' );
		}

		/**
		 * Renders the site tagline for the selective refresh partial.
		 *
		 * @since Twenty Twenty-One 1.0
		 *
		 * @return void
		 */
		public function partial_blogdescription() {
			bloginfo( 'description' );
		}
	}
}
