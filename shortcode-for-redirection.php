<?php
/**
 * Plugin Name:     Redirecter
 * Plugin URI:      https://wordpress.org/plugins/shortcode-for-redirection/
 * Description:     A super easy way to automatically redirect a user to another page when viewing a post/page on your site.
 * Author:          Productineer
 * Author URI:      https://profiles.wordpress.org/productineer/
 * Text Domain:     sfr
 * Domain Path:     /languages
 * Version:         1.0
 * License:         GPLv3 or later
 * License URI:     https://www.gnu.org/licenses/gpl-3.0.html
 * @package         WordPress
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}


/**
 * Plugin textdomain.
 */
function sfr_textdomain() {
	load_plugin_textdomain( 'srf', false, basename( dirname( __FILE__ ) ) . '/languages' );
}
add_action( 'plugins_loaded', 'sfr_textdomain' );

/**
 * Plugin activation.
 */
function sfr_activation() {
	// Activation code here.
}
register_activation_hook( __FILE__, 'sfr_activation' );

/**
 * Plugin deactivation.
 */
function sfr_deactivation() {
	// Deactivation code here.
}
register_deactivation_hook( __FILE__, 'sfr_deactivation' );

/**
 * Register shortcode.
 *
 * @param array $atts Shortcode attributes.
 * @return string
 */
if( ! function_exists( 'sfr_register_shortcode' ) ){
	function sfr_register_shortcode( $atts ) {
		$atts = shortcode_atts(
			array(
				'redirect_to' => '',
				'time_delay' => 0,
			),
			$atts,
			'redirecter'
		);
		if ( isset( $atts['time_delay'] ) && empty( $atts['time_delay'] ) ) {
			return '';
		}

		if ( isset( $atts['redirect_to'] ) && empty( $atts['redirect_to'] ) ) {
			return '';
		}
		if ( ! is_admin() ) {
			$meta_string = '<meta http-equiv="refresh" content="' . $atts['time_delay'] . '; url=' . $atts['redirect_to'] . '">';
			$meta_string .= wp_sprintf( __( 'Please wait while you are redirected...or <a href="%1$s">Click Here</a> if you do not want to wait.', 'srf' ), $atts['redirect_to'] );
			return $meta_string;
		}
		return '';
	}
	add_shortcode( 'redirecter', 'sfr_register_shortcode' );
}