<?php

	global $route;
	global $overlay;

	$overlay = array(
		'left'  => apply_filters('zabit_overlay_left', '', $post),
		'right' => apply_filters('zabit_overlay_right', '', $post)
	);

	get_header();

	switch ($route) {
		case 'index':
			get_section('post');

			query_posts(array(
				'post_type'      => 'news',
				'lang'           => pll_current_language('slug'),
				'posts_per_page' => get_option('posts_per_page', -1)
			));

			get_section('news');

			wp_reset_query();
			wp_reset_postdata();
			break;
		case 'about':
			get_section('post');
			get_section('statistics');
			get_section('accomplishments');
			break;
		case 'shop':
		case 'cart':
		case 'checkout':
		case 'product':
			get_section('wc');
			break;
		default:
			switch (true) {
				case is_404() || is_archive():
					get_section($route);
					break;
				case is_single() || is_page():
					get_section('post');
					break;
				default:
					get_section();
			}
	}

	get_footer();