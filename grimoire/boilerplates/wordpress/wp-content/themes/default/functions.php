<?php

if((defined('WP_DEBUG') && WP_DEBUG) || (defined('WP_DEBUG_DISPLAY') && WP_DEBUG_DISPLAY)){
    error_reporting(E_ALL);
    ini_set('display_errors', 1);
}

if (version_compare($GLOBALS['wp_version'], '5.2', '<')) {
    require get_template_directory().'/core/legacy.php';
}

if (!function_exists( 'madtd_setup')) {
    function madtd_setup() {
        load_theme_textdomain('madtd', get_template_directory().'/languages');
    }
}
add_action('after_setup_theme', 'madtd_setup');

function madtd_enqueue_scripts(){
    $cache = '';

    wp_register_style('madtd-style', get_theme_file_uri('/css/build/style.css'), array(), $cache);
    wp_register_style('madtd', get_stylesheet_uri(), array('madtd-style'), $cache);

    wp_register_script('madtd-html5shiv', get_theme_file_uri('/js/vendor/html5shiv.min.js'), array(), '3.7.3');
    wp_script_add_data('madtd-html5shiv', 'conditional', 'lt IE 9');
    wp_register_script('madtd-html5shiv-printshiv', get_theme_file_uri('/js/vendor/html5shiv-printshiv.min.js'), array(), '3.7.3');
    wp_script_add_data('madtd-html5shiv-printshiv', 'conditional', 'lt IE 9');
    wp_register_script('madtd-respond', get_theme_file_uri('/js/vendor/respond.min.js'), array(), '1.4.2');
    wp_script_add_data('madtd-respond', 'conditional', 'lt IE 9');
    wp_register_script('madtd', get_theme_file_uri('/js/build/script.js'), array('madtd-html5shiv', 'madtd-html5shiv-printshiv', 'madtd-respond', 'jquery'), $cache, true);

    wp_localize_script('madtd', 'WP', array(
        'url' => admin_url('admin-ajax.php')
    ));

    wp_enqueue_style('madtd');
    wp_enqueue_script('madtd');
}
add_action('wp_enqueue_scripts', 'madtd_enqueue_scripts');

function madtd_upload_mimes($mimes, $user) {
    return array_merge($mimes, array('svg' => 'image/svg+xml'));
}
add_filter('upload_mimes', 'madtd_upload_mimes', 99, 2);

require_once 'core/template.php';
require_once 'core/widgets.php';
require_once 'core/svg.php';

require_once 'core/post_type/post.php';
require_once 'core/post_type/page.php';