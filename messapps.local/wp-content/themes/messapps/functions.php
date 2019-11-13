<?php

	if((defined('WP_DEBUG') && WP_DEBUG) || (defined('WP_DEBUG_DISPLAY') && WP_DEBUG_DISPLAY)){
		error_reporting(E_ALL);
		ini_set('display_errors', 1);
	}

	if (version_compare($GLOBALS['wp_version'], '5.2.1', '<')) {
		require get_template_directory().'/core/legacy.php';
	}

	if (!function_exists('ma_setup')) {
		function ma_setup() {
			load_theme_textdomain('ma', get_template_directory().'/languages');

			add_theme_support('automatic-feed-links');
			add_theme_support('html5', array('caption'));
			add_theme_support('post-thumbnails');

			update_option('thumbnail_size_w', 0);
			update_option('thumbnail_size_h', 0);
			update_option('thumbnail_crop', 0);

			update_option('medium_size_w', 0);
			update_option('medium_size_h', 0);
			update_option('medium_crop', 0);

			update_option('large_size_w', 0);
			update_option('large_size_h', 0);
			update_option('large_crop', 0);
		}
	}
	add_action('after_setup_theme', 'ma_setup');

	function ma_enqueue_scripts(){
		$cache = '';

		wp_register_style('ma-style', get_theme_file_uri('/css/build/style.css'), array(), $cache);
		wp_register_style('ma', get_stylesheet_uri(), array('ma-style'), $cache);

		wp_register_script('ma-html5shiv', get_theme_file_uri('/js/vendor/html5shiv.min.js'), array(), '3.7.3');
		wp_script_add_data('ma-html5shiv', 'conditional', 'lt IE 9');
		wp_register_script('ma-html5shiv-printshiv', get_theme_file_uri('/js/vendor/html5shiv-printshiv.min.js'), array(), '3.7.3');
		wp_script_add_data('ma-html5shiv-printshiv', 'conditional', 'lt IE 9');
		wp_register_script('ma-respond', get_theme_file_uri('/js/vendor/respond.min.js'), array(), '1.4.2');
		wp_script_add_data('ma-respond', 'conditional', 'lt IE 9');
		wp_register_script('ma', get_theme_file_uri('/js/build/script.js'), array('ma-html5shiv', 'ma-html5shiv-printshiv', 'ma-respond', 'jquery'), $cache, true);

		wp_localize_script('ma', 'WP', array(
			'url' => admin_url('admin-ajax.php')
		));

		wp_enqueue_style('ma');
		wp_enqueue_script('ma');
	}
	add_action('wp_enqueue_scripts', 'ma_enqueue_scripts');

	function ma_upload_mimes($mimes, $user) {
		return array_merge($mimes, array('svg' => 'image/svg+xml'));
	}
	add_filter('upload_mimes', 'ma_upload_mimes', 99, 2);