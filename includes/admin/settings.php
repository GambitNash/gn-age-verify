<?php

// Don't access this directly, please
if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * Define the settings page.
 *
 * @since 0.1
 */
function av_settings_page() { ?>

	<div class="wrap">

		<?php screen_icon(); ?>

		<h2><?php esc_html_e( 'GN Age Verify Settings', 'gn-age-verify' ) ?></h2>

		<form action="options.php" method="post">

			<?php settings_fields( 'gn-age-verify' ); ?>

			<?php do_settings_sections( 'gn-age-verify' ); ?>

			<?php submit_button(); ?>

		</form>

		<div class="plugin-footer">
			<p><small>The <a href="https://github.com/GambitNash/gn-age-verify" title="Gambit Nash: Age Verify Plugin Fork">GN Age Verify</a> plugin is based on <a href="https://github.com/ChaseWiseman/age-verify" title="Age Verify by Chase Wiseman">Age Verify</a> by Chase Wiseman</small></p>
		</div>
	</div>

<?php }


/**********************************************************/
/******************** General Settings ********************/
/**********************************************************/

/**
 * Prints the general settings section heading.
 *
 * @since 0.1
 */
function av_settings_callback_section_general() {

	// Something should go here
}

/**
 * Prints the "require for" settings field.
 *
 * @since 0.2
 */
function av_settings_callback_require_for_field() { ?>

	<fieldset>
		<legend class="screen-reader-text">
			<span><?php esc_html_e( 'Require verification for', 'gn-age-verify' ); ?></span>
		</legend>
		<label>
			<input type="radio" name="_gn_av_require_for" value="site" <?php checked( 'site', get_option( '_gn_av_require_for', 'site' ) ); ?>/>
			 <?php esc_html_e( 'Entire site', 'gn-age-verify' ); ?><br />
		</label>
		<br />
		<label>
			<input type="radio" name="_gn_av_require_for" value="content" <?php checked( 'content', get_option( '_gn_av_require_for', 'site' ) ); ?>/>
			 <?php esc_html_e( 'Specific content', 'gn-age-verify' ); ?>
		</label>
	</fieldset>

<?php }

/**
 * Prints the "who to verify" settings field.
 *
 * @since 0.1
 */
function av_settings_callback_always_verify_field() { ?>

	<fieldset>
		<legend class="screen-reader-text">
			<span><?php esc_html_e( 'Verify the age of', 'gn-age-verify' ); ?></span>
		</legend>
		<label>
			<input type="radio" name="_gn_av_always_verify" value="guests" <?php checked( 'guests', get_option( '_gn_av_always_verify', 'guests' ) ); ?>/>
			 <?php esc_html_e( 'Guests only', 'gn-age-verify' ); ?> <span class="description"><?php esc_html_e( 'Logged-in users will not need to verify their age.', 'gn-age-verify' ); ?></span><br />
		</label>
		<br />
		<label>
			<input type="radio" name="_gn_av_always_verify" value="all" <?php checked( 'all', get_option( '_gn_av_always_verify', 'guests' ) ); ?>/>
			 <?php esc_html_e( 'All visitors', 'gn-age-verify' ); ?>
		</label>
	</fieldset>

<?php }

/**
 * Prints the minimum age settings field.
 *
 * @since 0.1
 */
function av_settings_callback_minimum_age_field() { ?>

	<input name="_gn_av_minimum_age" type="number" id="_gn_av_minimum_age" step="1" min="10" class="small-text" value="<?php echo esc_attr( get_option( '_gn_av_minimum_age', '21' ) ); ?>" /> <?php esc_html_e( 'years old or older to view this site', 'gn-age-verify' ); ?>

<?php }

/**
 * Prints the cookie duration settings field.
 *
 * @since 0.1
 */
function av_settings_callback_cookie_duration_field() { ?>

	<input name="_gn_av_cookie_duration" type="number" id="_gn_av_cookie_duration" step="15" min="15" class="small-text" value="<?php echo esc_attr( get_option( '_gn_av_cookie_duration', '720' ) ); ?>" /> <?php esc_html_e( 'minutes', 'gn-age-verify' ); ?>

<?php }

/**
 * Prints the membership settings field.
 *
 * @since 0.1
 */
function av_settings_callback_membership_field() { ?>

	<fieldset>
		<legend class="screen-reader-text">
			<span><?php esc_html_e( 'Membership', 'gn-age-verify' ); ?></span>
		</legend>
		<label for="_gn_av_membership">
			<input name="_gn_av_membership" type="checkbox" id="_gn_av_membership" value="1" <?php checked( 1, get_option( '_gn_av_membership', 1 ) ); ?>/>
			 <?php esc_html_e( 'Require users to confirm their age before registering to this site', 'gn-age-verify' ); ?>
		</label>
	</fieldset>

<?php }


/**********************************************************/
/******************** Display Settings ********************/
/**********************************************************/

/**
 * Prints the display settings section heading.
 *
 * @since 0.1
 */
function av_settings_callback_section_display() {

	echo '<p>' . esc_html__( 'These settings change the look of your overlay. You can use <code>%s</code> to display the minimum age number from the setting above.', 'gn-age-verify' ) . '</p>';
}

/**
 * Prints the modal heading settings field.
 *
 * @since 0.1
 */
function av_settings_callback_heading_field() { ?>

	<input name="_gn_av_heading" type="text" id="_gn_av_heading" value="<?php echo esc_attr( get_option( '_gn_av_heading', __( 'You must be %s years old to visit this site.', 'gn-age-verify' ) ) ); ?>" class="regular-text" />

<?php }

/**
 * Prints the modal description settings field.
 *
 * @since 0.1
 */
function av_settings_callback_description_field() { ?>

	<input name="_gn_av_description" type="text" id="_gn_av_description" value="<?php echo esc_attr( get_option( '_gn_av_description', __( 'Please verify your age', 'gn-age-verify' ) ) ); ?>" class="regular-text" />

<?php }

/**
 * Prints the input type settings field.
 *
 * @since 0.1
 */
function av_settings_callback_input_type_field() { ?>

	<select name="_gn_av_input_type" id="_gn_av_input_type">
		<option value="dropdowns" <?php selected( 'dropdowns', get_option( '_gn_av_input_type', 'dropdowns' ) ); ?>><?php esc_html_e( 'Date dropdowns', 'gn-age-verify' ); ?></option>
		<option value="inputs" <?php selected( 'inputs', get_option( '_gn_av_input_type', 'dropdowns' ) ); ?>><?php esc_html_e( 'Inputs', 'gn-age-verify' ); ?></option>
		<option value="checkbox" <?php selected( 'checkbox', get_option( '_gn_av_input_type', 'dropdowns' ) ); ?>><?php esc_html_e( 'Confirm checkbox', 'gn-age-verify' ); ?></option>
	</select>

<?php }

/**
 * Prints the styling settings field.
 *
 * @since 0.1
 */
function av_settings_callback_styling_field() { ?>

	<fieldset>
		<legend class="screen-reader-text">
			<span><?php esc_html_e( 'Styling', 'gn-age-verify' ); ?></span>
		</legend>
		<label for="_gn_av_styling">
			<input name="_gn_av_styling" type="checkbox" id="_gn_av_styling" value="1" <?php checked( 1, get_option( '_gn_av_styling', 1 ) ); ?>/>
			 <?php esc_html_e( 'Use built-in CSS on the front-end (recommended)', 'gn-age-verify' ); ?>
		</label>
	</fieldset>

<?php }

/**
 * Prints the overlay color settings field.
 *
 * @since 0.1
 */
function av_settings_callback_overlay_color_field() { ?>

	<fieldset>

		<legend class="screen-reader-text">
			<span><?php esc_html_e( 'Overlay Color', 'gn-age-verify' ); ?></span>
		</legend>

		<?php $default_color = ' data-default-color="#fff"'; ?>

		<input type="text" name="_gn_av_overlay_color" id="_gn_av_overlay_color" value="#<?php echo esc_attr( av_get_overlay_color() ); ?>"<?php echo $default_color ?> />

	</fieldset>

<?php }

/**
 * Prints the background color settings field.
 *
 * @since 0.1
 */
function av_settings_callback_bgcolor_field() { ?>

	<fieldset>

		<legend class="screen-reader-text">
			<span><?php esc_html_e( 'Background Color' ); ?></span>
		</legend>

		<?php $default_color = '';

		if ( current_theme_supports( 'custom-background', 'default-color' ) )
			$default_color = ' data-default-color="#' . esc_attr( get_theme_support( 'custom-background', 'default-color' ) ) . '"'; ?>

		<input type="text" name="_gn_av_bgcolor" id="_gn_av_bgcolor" value="#<?php echo esc_attr( av_get_background_color() ); ?>"<?php echo $default_color ?> />

	</fieldset>

<?php }
