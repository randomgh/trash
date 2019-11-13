<?php
/**
 * Zabit legacy functionality
 *
 * Prevents Zabit from running on WordPress versions prior to 5.1,
 * since this theme is not meant to be backward compatible beyond that and
 * relies on many newer functions and markup changes introduced in 5.1.
 *
 * @package WordPress
 * @subpackage Zabit
 * @since Zabit 0.1
 */

/**
 * Prevent switching to Zabit on old versions of WordPress.
 *
 * Switches to the default theme.
 *
 * @since Zabit 0.1
 */
function zabit_after_switch_theme() {
	switch_theme( WP_DEFAULT_THEME, WP_DEFAULT_THEME );

	unset( $_GET['activated'] );

	add_action( 'admin_notices', 'zabit_admin_notices' );
}
add_action( 'after_switch_theme', 'zabit_after_switch_theme' );

/**
 * Adds a message for unsuccessful theme switch.
 *
 * Prints an update nag after an unsuccessful attempt to switch to
 * Zabit on WordPress versions prior to 5.1.
 *
 * @since Zabit 0.1
 *
 * @global string $wp_version WordPress version.
 */
function zabit_admin_notices() {
	$message = sprintf( __( 'Zabit requires at least WordPress version 5.1. You are running version %s. Please upgrade and try again.', 'zabit' ), $GLOBALS['wp_version'] );
	printf( '<div class="error"><p>%s</p></div>', $message );
}

/**
 * Prevents the Customizer from being loaded on WordPress versions prior to 5.1.
 *
 * @since Zabit 0.1
 *
 * @global string $wp_version WordPress version.
 */
function zabit_load_customize() {
	wp_die(
		sprintf( __( 'Zabit requires at least WordPress version 5.1. You are running version %s. Please upgrade and try again.', 'zabit' ), $GLOBALS['wp_version'] ),
		'',
		array(
			'back_link' => true,
		)
	);
}
add_action( 'load-customize.php', 'zabit_load_customize' );

/**
 * Prevents the Theme Preview from being loaded on WordPress versions prior to 5.1.
 *
 * @since Zabit 0.1
 *
 * @global string $wp_version WordPress version.
 */
function zabit_template_redirect() {
	if ( isset( $_GET['preview'] ) ) {
		wp_die( sprintf( __( 'Zabit requires at least WordPress version 5.1. You are running version %s. Please upgrade and try again.', 'zabit' ), $GLOBALS['wp_version'] ) );
	}
}
add_action( 'template_redirect', 'zabit_template_redirect' );
