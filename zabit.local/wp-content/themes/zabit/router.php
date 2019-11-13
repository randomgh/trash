<?php

	function router_wp($wp) {
		global $route;

		switch(true){
			case is_404():
				$route = 'error';
				break;
			case is_front_page() || is_home():
				$route = 'index';
				break;
			case is_single() || is_page():
				switch(true){
					case get_the_ID() == wc_get_page_id('myaccount'):
						$route = 'myaccount';
						break;
					case get_the_ID() == wc_get_page_id('shop'):
						$route = 'shop';
						break;
					case get_the_ID() == wc_get_page_id('cart'):
						$route = 'cart';
						break;
					case get_the_ID() == wc_get_page_id('checkout'):
						$route = 'checkout';
						break;
					case get_the_ID() == wc_get_page_id('view_order'):
						$route = 'view_order';
						break;
					case get_the_ID() == wc_get_page_id('terms'):
						$route = 'terms';
						break;
					case get_the_ID() == pll_get_post(get_option('zabit_general_general_about_page', null)):
						$route = 'about';
						break;
					case is_singular(array('product')):
						$route = 'product';
						break;
					case is_singular(array('news')):
						$route = 'news';
						break;
					case is_singular(array('event')):
						$route = 'event';
						break;
					default:
						$route = 'post';
						break;
				}
				break;
			case is_archive():
				switch(true){
					case is_post_type_archive('news'):
						$route = 'news';
						break;
					case is_post_type_archive('event'):
						$route = 'event';
						break;
					case is_post_type_archive('product') || is_tax(array_map(function($taxonomy) {
							return "pa_$taxonomy->attribute_name";
						}, wc_get_attribute_taxonomies())):
						$route = 'product';
						break;
					default:
						$route = 'post';
						break;
				}
				break;
			default:
				$route = '';
				break;
		}
	}
	add_action('wp', 'router_wp', 10, 1);