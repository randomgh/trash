<?php

	if((defined('WP_DEBUG') && WP_DEBUG) || (defined('WP_DEBUG_DISPLAY') && WP_DEBUG_DISPLAY)){
		error_reporting(E_ALL);
		ini_set('display_errors', 1);
	}

	if (version_compare($GLOBALS['wp_version'], '5.1-alpha', '<')) {
		require get_template_directory().'/core/legacy.php';
	}

	if (!function_exists( 'zabit_setup')) :
		function zabit_setup() {
			load_theme_textdomain('zabit', get_template_directory().'/languages');

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

			add_image_size('background-left', 76.25 * 8, 112.5 * 8, true);
			add_image_size('background-right', 27.5 * 8, 112.5 * 8, true);
			add_image_size('background-static', 180 * 8, 112.5 * 8, true);
			add_image_size('background-full', 180 * 8, 112.5 * 8, true);

			add_image_size('social-fb', 1200, 630, true);
			add_image_size('social-tw', 1024, 512, true);
			add_image_size('social-vk', 537, 240, true);

			add_image_size('excerpt', 56 * 8, 56 * 8, true);
			add_image_size('icon', 6 * 8, 6 * 8, true);
			add_image_size('opponent', 8 * 8, 8 * 8, true);

			add_image_size('media', 54 * 8, 30 * 8, true);
		}
	endif; // zabit_setup
	add_action('after_setup_theme', 'zabit_setup');

	function zabit_enqueue_scripts(){
		$cache = '20190816';

		wp_register_style('zabit-style', get_theme_file_uri('/css/build/style.css'), array(), $cache);
		wp_register_style('zabit-ie', get_theme_file_uri('/css/build/ie.css'), array(), $cache);
		wp_style_add_data('zabit-ie', 'conditional', 'IE');
		wp_register_style('zabit-jquery-fancybox', get_theme_file_uri('/css/vendor/jquery.fancybox.min.css'), array(), '3.5.7');
		wp_register_style('zabit', get_stylesheet_uri(), array('zabit-style', 'zabit-ie', 'zabit-jquery-fancybox'), $cache);

		wp_register_script('zabit-html5shiv', get_theme_file_uri('/js/vendor/html5shiv.min.js'), array(), '3.7.3');
		wp_script_add_data('zabit-html5shiv', 'conditional', 'lt IE 9');
		wp_register_script('zabit-html5shiv-printshiv', get_theme_file_uri('/js/vendor/html5shiv-printshiv.min.js'), array(), '3.7.3');
		wp_script_add_data('zabit-html5shiv-printshiv', 'conditional', 'lt IE 9');
		wp_register_script('zabit-respond', get_theme_file_uri('/js/vendor/respond.min.js'), array(), '1.4.2');
		wp_script_add_data('zabit-respond', 'conditional', 'lt IE 9');
		wp_register_script('zabit-youtube', 'https://www.youtube.com/player_api', array(), 'vflf9U9oY');
		wp_register_script('zabit-jquery-visible', get_theme_file_uri('/js/vendor/jquery.visible.min.js'), array('jquery'), '0.0.0', true);
		wp_register_script('zabit-jquery-fullscreen', get_theme_file_uri('/js/vendor/jquery.fullscreen.min.js'), array('jquery'), '0.6.0', true);
		wp_register_script('zabit-jquery-ytplayer', get_theme_file_uri('/js/vendor/jquery.mb.YTPlayer.min.js'), array('jquery'), '3.2.10', true);
		wp_register_script('zabit-jquery-fancybox', get_theme_file_uri('/js/vendor/jquery.fancybox.min.js'), array('jquery'), '3.5.7', true);
		wp_register_script('zabit', get_theme_file_uri('/js/build/script.js'), array('zabit-html5shiv', 'zabit-html5shiv-printshiv', 'zabit-respond', 'jquery', 'zabit-jquery-visible', 'zabit-jquery-fullscreen', 'zabit-jquery-ytplayer', 'zabit-jquery-fancybox', 'zabit-youtube'), $cache, true);

		wp_localize_script('zabit', 'WP', array(
			'url' => admin_url('admin-ajax.php')
		));

		wp_enqueue_style('zabit');
		wp_enqueue_script('zabit');
	}
	add_action('wp_enqueue_scripts', 'zabit_enqueue_scripts');

	function zabit_upload_mimes($mimes, $user) {
		return array_merge($mimes, array('svg' => 'image/svg+xml'));
	}
	add_filter('upload_mimes', 'zabit_upload_mimes', 99, 2);

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
	require_once 'core/post_type/athlete.php';
	require_once 'core/post_type/event.php';
	require_once 'core/post_type/goal.php';

	require_once 'core/walkers/NavMenuWalker.php';
	require_once 'core/walkers/LanguageMenuWalker.php';

	require_once 'core/meta.php';

	require_once 'core/ajax.php';

	require_once 'core/woo.php';

	require_once 'router.php';
	require_once 'overlay.php';

	require_once 'title.php';
	require_once 'background.php';
	require_once 'youtube.php';
	require_once 'video.php';
	require_once 'chart.php';
