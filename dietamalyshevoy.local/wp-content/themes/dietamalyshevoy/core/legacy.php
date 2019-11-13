<?php

function dem_after_switch_theme() {
    switch_theme(WP_DEFAULT_THEME, WP_DEFAULT_THEME);

    unset($_GET['activated']);

    add_action('admin_notices', 'dem_admin_notices');
}
add_action('after_switch_theme', 'dem_after_switch_theme');

function dem_admin_notices() {
    $message = sprintf(__('Dietamalyshevoy requires at least WordPress version 5.2.1. You are running version %s. Please upgrade and try again.', 'dem'), $GLOBALS['wp_version']);
    printf('<div class="error"><p>%s</p></div>', $message);
}

function dem_load_customize() {
    wp_die(
        sprintf(__('Dietamalyshevoy requires at least WordPress version 5.2.1. You are running version %s. Please upgrade and try again.', 'dem'), $GLOBALS['wp_version'] ),
        '',
        array(
            'back_link' => true,
        )
    );
}
add_action('load-customize.php', 'dem_load_customize');

function dem_template_redirect() {
    if (isset($_GET['preview'])) {
        wp_die(sprintf(__('Dietamalyshevoy requires at least WordPress version 5.2.1. You are running version %s. Please upgrade and try again.', 'dem'), $GLOBALS['wp_version']));
    }
}
add_action('template_redirect', 'dem_template_redirect');
