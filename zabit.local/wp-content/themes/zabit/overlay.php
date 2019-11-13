<?php

	function zabit_overlay_left($result, $post) {
		global $route;

		ob_start();

		if (!(in_array($route, array('post', 'event', 'product', 'myaccount', 'shop', 'cart', 'checkout', 'view_order', 'terms'))) && !(is_page() || is_single()) && !is_404()) {
			echo ' ';
		}

		$result = ob_get_contents();
		ob_end_clean();

		return $result;
	}
	add_filter('zabit_overlay_left', 'zabit_overlay_left', 10, 2);

	function zabit_overlay_right($result, $post) {
		global $route;

		ob_start();

		$events = get_posts(array(
			'post_type'  => 'event',
			'lang'       => pll_current_language('slug'),
			'showposts'  => 1,
			'order'      => 'ASC',
			'meta_key'   => 'info_date',
			'orderby'    => 'meta_value',
			'meta_query' => array(
				array(
					'key' => 'results_result',
					'compare' => 'NOT EXISTS'
				)
			)
		));

		if (count($events) && (((is_page() || is_single()) && !in_array($route, array('news', 'event', 'product', 'myaccount', 'shop', 'cart', 'checkout', 'view_order', 'terms'))) || (is_archive() && !in_array($route, array('event', 'product', 'myaccount', 'shop', 'cart', 'checkout', 'view_order', 'terms'))) || is_404())) {
			$background = get_option('zabit_general_general_right_image', null);

			if ($background) get_background($background, 'right');

			get_block('announcement');
		}

		$result = ob_get_contents();
		ob_end_clean();

		return $result;
	}
	add_filter('zabit_overlay_right', 'zabit_overlay_right', 10, 2);
