<?php

function madtd_after_switch_theme() {
	switch_theme(WP_DEFAULT_THEME, WP_DEFAULT_THEME);

	unset($_GET['activated']);

	add_action('admin_notices', 'madtd_admin_notices');
}
add_action('after_switch_theme', 'madtd_after_switch_theme');

function madtd_admin_notices() {
	$message = sprintf(__('madtd requires at least WordPress version 5.1. You are running version %s. Please upgrade and try again.', 'madtd'), $GLOBALS['wp_version']);
	printf('<div class="error"><p>%s</p></div>', $message);
}

function madtd_load_customize() {
	wp_die(
		sprintf(__('madtd requires at least WordPress version 5.1. You are running version %s. Please upgrade and try again.', 'madtd'), $GLOBALS['wp_version']),
		'',
		array(
			'back_link' => true,
		)
	);
}
add_action('load-customize.php', 'madtd_load_customize');

function madtd_template_redirect() {
	if (isset($_GET['preview'])) {
		wp_die(sprintf(__('madtd requires at least WordPress version 5.1. You are running version %s. Please upgrade and try again.', 'madtd'), $GLOBALS['wp_version']));
	}
}
add_action('template_redirect', 'madtd_template_redirect');
