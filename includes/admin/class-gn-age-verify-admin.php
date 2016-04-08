<?php
/**
 * Define the admin class
 *
 * @since 0.2.6
 *
 * @package GN_Age_Verify\Admin
 */

// Don't allow this file to be accessed directly.
if ( ! defined( 'WPINC' ) ) {
	die();
}

/**
 * The admin class.
 *
 * @since 0.2.6
 */
final class GN_Age_Verify_Admin {

	/**
	 * The only instance of this class.
	 *
	 * @since 0.2.6
	 * @access protected
	 */
	protected static $instance = null;

	/**
	 * Get the only instance of this class.
	 *
	 * @since 0.2.6
	 *
	 * @return object $instance The only instance of this class.
	 */
	public static function get_instance() {

		if ( is_null( self::$instance ) ) {
			self::$instance = new self();
		}

		return self::$instance;
	}

	/**
	 * Prevent cloning of this class.
	 *
	 * @since 0.2.6
	 *
	 * @return void
	 */
	public function __clone() {
		_doing_it_wrong( __FUNCTION__, __( 'Cheatin&#8217; huh?', 'gn-age-verify' ), GN_Age_Verify::VERSION );
	}

	/**
	 * Prevent unserializing of this class.
	 *
	 * @since 0.2.6
	 *
	 * @return void
	 */
	public function __wakeup() {
		_doing_it_wrong( __FUNCTION__, __( 'Cheatin&#8217; huh?', 'gn-age-verify' ), GN_Age_Verify::VERSION );
	}

	/**
	 * Construct the class!
	 *
	 * @since 0.2.6
	 *
	 * @return void
	 */
	public function __construct() {

		/**
		 * The settings callbacks.
		 */
		require( plugin_dir_path( __FILE__ ) . 'settings.php' );

		// Add the settings page.
		add_action( 'admin_menu', array( $this, 'add_settings_page' ) );

		// Add and register the settings sections and fields.
		add_action( 'admin_init', array( $this, 'register_settings' ) );

		// Add the "Settings" link to the plugin row.
		add_filter( 'plugin_action_links_gn-age-verify/gn-age-verify.php', array( $this, 'add_settings_link' ), 10 );

		// Enqueue the script.
		add_action( 'admin_enqueue_scripts', array( $this, 'enqueue_scripts' ) );

		// Only load with post-specific stuff if enabled.
		if ( 'content' == get_option( '_gn_av_require_for' ) ) {

			// Add a "restrict" checkbox to individual posts/pages.
			add_action( 'post_submitbox_misc_actions', array( $this, 'add_submitbox_checkbox' ) );

			// Save the "restrict" checkbox value.
			add_action( 'save_post', array( $this, 'save_post' ) );

		}
	}

	/**
	 * Add to the settings page.
	 *
	 * @since 0.2.6
	 *
	 * @return void
	 */
	public function add_settings_page() {

		add_options_page (
			__( 'GN Age Verify', 'gn-age-verify' ),
			__( 'GN Age Verify', 'gn-age-verify' ),
			'manage_options',
			'gn-age-verify',
			'gn_av_settings_page'
		);
	}

	/**
	 * Add and register the settings sections and fields.
	 *
	 * @since 0.2.6
	 *
	 * @return void
	 */
	public function register_settings() {

		/* General Section */
		add_settings_section( 'gn_av_settings_general', null, 'gn_av_settings_callback_section_general', 'gn-age-verify' );

	 	// What to protect (entire site or specific content)
		add_settings_field( '_gn_av_require_for', __( 'Require verification for', 'gn-age-verify' ), 'gn_av_settings_callback_require_for_field', 'gn-age-verify', 'gn_av_settings_general' );
	 	register_setting  ( 'gn-age-verify', '_gn_av_require_for', 'esc_attr' );

	 	// Who to verify (logged in or all)
		add_settings_field( '_gn_av_always_verify', __( 'Verify the age of', 'gn-age-verify' ), 'gn_av_settings_callback_always_verify_field', 'gn-age-verify', 'gn_av_settings_general' );
	 	register_setting  ( 'gn-age-verify', '_gn_av_always_verify', 'esc_attr' );

	 	// Minimum Age
		add_settings_field( '_gn_av_minimum_age', '<label for="_gn_av_minimum_age">' . __( 'Visitors must be', 'gn-age-verify' ) . '</label>', 'gn_av_settings_callback_minimum_age_field', 'gn-age-verify', 'gn_av_settings_general' );
	 	register_setting  ( 'gn-age-verify', '_gn_av_minimum_age', 'intval' );

	 	// Memory Length
	 	add_settings_field( '_gn_av_cookie_duration', '<label for="_gn_av_cookie_duration">' . __( 'Remember visitors for', 'gn-age-verify' ) . '</label>', 'gn_av_settings_callback_cookie_duration_field', 'gn-age-verify', 'gn_av_settings_general' );
	 	register_setting  ( 'gn-age-verify', '_gn_av_cookie_duration', 'intval' );

	 	add_settings_field( '_gn_av_membership', __( 'Membership', 'gn-age-verify' ), 'gn_av_settings_callback_membership_field', 'gn-age-verify', 'gn_av_settings_general' );
	 	register_setting  ( 'gn-age-verify', '_gn_av_membership', 'intval' );

	 	/* Display Section */
	 	add_settings_section( 'gn_av_settings_display', __( 'Display Options', 'gn-age-verify' ), 'gn_av_settings_callback_section_display', 'gn-age-verify' );

	 	// Heading
	 	add_settings_field( '_gn_av_heading', '<label for="_gn_av_heading">' . __( 'Overlay Heading', 'gn-age-verify' ) . '</label>', 'gn_av_settings_callback_heading_field', 'gn-age-verify', 'gn_av_settings_display' );
	 	register_setting  ( 'gn-age-verify', '_gn_av_heading', 'esc_attr' );

	 	// Description
	 	add_settings_field( '_gn_av_description', '<label for="_gn_av_description">' . __( 'Overlay Description', 'gn-age-verify' ) . '</label>', 'gn_av_settings_callback_description_field', 'gn-age-verify', 'gn_av_settings_display' );
	 	register_setting  ( 'gn-age-verify', '_gn_av_description', 'esc_attr' );

	 	// Input Type
	 	add_settings_field( '_gn_av_input_type', '<label for="_gn_av_input_type">' . __( 'Verify ages using', 'gn-age-verify' ) . '</label>', 'gn_av_settings_callback_input_type_field', 'gn-age-verify', 'gn_av_settings_display' );
	 	register_setting  ( 'gn-age-verify', '_gn_av_input_type', 'esc_attr' );

	 	// Enable CSS
	 	add_settings_field( '_gn_av_styling', __( 'Styling', 'gn-age-verify' ), 'gn_av_settings_callback_styling_field', 'gn-age-verify', 'gn_av_settings_display' );
	 	register_setting  ( 'gn-age-verify', '_gn_av_styling', 'intval' );

	 	// Overlay Color
	 	add_settings_field( '_gn_av_overlay_color', __( 'Overlay Color', 'gn-age-verify' ), 'gn_av_settings_callback_overlay_color_field', 'gn-age-verify', 'gn_av_settings_display' );
	 	register_setting  ( 'gn-age-verify', '_gn_av_overlay_color', array( $this, 'validate_color' ) );

	 	// Background Color
	 	add_settings_field( '_gn_av_bgcolor', __( 'Background Color', 'gn-age-verify' ), 'gn_av_settings_callback_bgcolor_field', 'gn-age-verify', 'gn_av_settings_display' );
	 	register_setting  ( 'gn-age-verify', '_gn_av_bgcolor', array( $this, 'validate_color' ) );

		do_action( 'gn_av_register_settings' );
	}

	/**
	 * Add a direct link to the Age Verify settings page from the plugins page.
	 *
	 * @since 0.2.6
	 *
	 * @param array  $actions The links beneath the plugin's name.
	 * @param string $file    The plugin filename.
	 * @return string
	 */
	public function add_settings_link( $actions ) {

		$settings_link = '<a href="' . esc_url( add_query_arg( 'page', 'gn-age-verify', admin_url( 'options-general.php' ) ) ) . '">';
			$settings_link .= __( 'Settings', 'gn-age-verify' );
		$settings_link .='</a>';

		array_unshift( $actions, $settings_link );

		return $actions;
	}

	/**
	 * Validates the color inputs from the settings.
	 *
	 * @since 0.2.6
	 *
	 * @param  string $color A color hex.
	 * @return string $color The validated color hex.
	 */
	public function validate_color( $color ) {

		$color = preg_replace( '/[^0-9a-fA-F]/', '', $color );

		if ( strlen( $color ) == 6 || strlen( $color ) == 3 ) {
			$color = $color;
		} else {
			$color = '';
		}

		return $color;
	}

	/**
	 * Enqueue the scripts.
	 *
	 * @since 0.2.6
	 *
	 * @param string $page The current admin page.
	 * @return void
	 */
	public function enqueue_scripts( $page ) {

		if ( 'settings_page_gn-age-verify' != $page ) {
			return;
		}

		wp_enqueue_style( 'wp-color-picker' );

		wp_enqueue_script( 'gn-av-admin-scripts', plugin_dir_url( __FILE__ ) . 'assets/scripts.js', array(
			'jquery',
			'wp-color-picker'
		) );
	}

	/**
	 * Add a "restrict" checkbox to individual posts/pages.
	 *
	 * @since 0.2.6
	 *
	 * @return void
	 */
	public function add_submitbox_checkbox() { ?>

		<div class="misc-pub-section verify-age">

			<?php wp_nonce_field( 'gn_av_save_post', 'gn_av_nonce' ); ?>

			<input type="checkbox" name="_gn_av_needs_verify" id="_gn_av_needs_verify" value="1" <?php checked( 1, get_post_meta( get_the_ID(), '_gn_av_needs_verify', true ) ); ?> />
			<label for="_gn_av_needs_verify" class="selectit">
				<?php esc_html_e( 'Require age verification for this content', 'gn-age-verify' ); ?>
			</label>

		</div><!-- .misc-pub-section -->

	<?php }

	/**
	 * Save the "restrict" checkbox value.
	 *
	 * @since 0.2.6
	 *
	 * @param int $post_id The current post ID.
	 * @return void
	 */
	public function save_post( $post_id ) {

		if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
			return;
		}

		$nonce = ( isset( $_POST['gn_av_nonce'] ) ) ? $_POST['gn_av_nonce'] : '';

		if ( ! wp_verify_nonce( $nonce, 'gn_av_save_post' ) ) {
			return;
		}

		$needs_verify = ( isset( $_POST['_gn_av_needs_verify'] ) ) ? (int) $_POST['_gn_av_needs_verify'] : 0;

		update_post_meta( $post_id, '_gn_av_needs_verify', $needs_verify );
	}
}
