<?php

    if ((defined('WP_DEBUG') && WP_DEBUG) || (defined('WP_DEBUG_DISPLAY') && WP_DEBUG_DISPLAY)) {
        error_reporting(E_ALL);
        ini_set('display_errors', 1);
    }

    if (version_compare($GLOBALS['wp_version'], '5.2.1', '<')) {
        require get_template_directory().'/core/legacy.php';
    }

    if (!function_exists('dem_setup')) {
        function dem_setup() {
            load_theme_textdomain('dem', get_template_directory().'/languages');

            update_option('thumbnail_size_w', 0);
            update_option('thumbnail_size_h', 0);
            update_option('thumbnail_crop', 0);

            update_option('medium_size_w', 0);
            update_option('medium_size_h', 0);
			update_option('medium_crop', 0);

			update_option('large_size_w', 0);
			update_option('large_size_h', 0);
			update_option('large_crop', 0);

			$x = 4;
		}
	}
	add_action('after_setup_theme', 'dem_setup');

	function dem_enqueue_scripts() {
		$cache = '0.0.1';

		wp_register_style('dem-style', get_theme_file_uri('/css/build/style.css'), array(), $cache);
		wp_register_style('dem', get_stylesheet_uri(), array('dem-style'), $cache);

		wp_register_script('dem-html5shiv', get_theme_file_uri('/js/vendor/html5shiv.min.js'), array(), '3.7.3');
		wp_script_add_data('dem-html5shiv', 'conditional', 'lt IE 9');
		wp_register_script('dem-html5shiv-printshiv', get_theme_file_uri('/js/vendor/html5shiv-printshiv.min.js'), array(), '3.7.3');
		wp_script_add_data('dem-html5shiv-printshiv', 'conditional', 'lt IE 9');
		wp_register_script('dem-respond', get_theme_file_uri('/js/vendor/respond.min.js'), array(), '1.4.2');
		wp_script_add_data('dem-respond', 'conditional', 'lt IE 9');
		wp_register_script('dem-jquery-fullscreen', get_theme_file_uri('/js/vendor/jquery.fullscreen.min.js'), array('jquery'), '0.6.0');
		wp_register_script('dem-jquery-visible', get_theme_file_uri('/js/vendor/jquery.visible.min.js'), array('jquery'), '0.6.0');
		wp_register_script('dem-youtube', 'https://www.youtube.com/player_api', array(), 'vflf9U9oY');
		wp_register_script('dem', get_theme_file_uri('/js/build/script.js'), array('dem-html5shiv', 'dem-html5shiv-printshiv', 'dem-respond', 'jquery', 'dem-jquery-fullscreen', 'dem-jquery-visible', 'dem-youtube'), $cache, true);

		wp_localize_script('dem', 'WP', array(
			'url' => admin_url('admin-ajax.php')
		));

        add_action('wp_print_scripts','include_scripts');
        function include_scripts(){
            wp_localize_script( 'jquery', 'ajax_var', array('url' => admin_url('admin-ajax.php')));
        }

		wp_enqueue_style('dem');
		wp_enqueue_script('dem');
	}
	add_action('wp_enqueue_scripts', 'dem_enqueue_scripts');

	function dem_upload_mimes($mimes, $user) {
		return array_merge($mimes, array('svg' => 'image/svg+xml'));
	}
	add_filter('upload_mimes', 'dem_upload_mimes', 99, 2);

    require_once 'core/admin_page.php';
    require_once 'core/meta_box.php';
    require_once 'core/taxonomy_meta.php';

    require_once 'core/admin.php';
    require_once 'core/template.php';
    require_once 'core/widgets.php';
    require_once 'core/menu.php';
	require_once 'core/mce.php';
    require_once 'core/svg.php';

    require_once 'core/post_type/post.php';
    require_once 'core/post_type/page.php';
    require_once 'core/post_type/news.php';
    require_once 'core/post_type/story.php';
    require_once 'core/post_type/landing.php';

	require_once 'core/walkers/NavMenuWalker.php';

    require_once 'core/meta.php';

	require_once 'router.php';

	require_once 'breadcrumbs.php';
