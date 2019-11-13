<?php

function ajax_pagination() {
	$args = array();

	switch ($_POST['type']) {
		case 'news':
			$args = array();
			break;
		case 'event':
			$args = array(
				'order'      => 'DESC',
				'meta_key'   => 'info_date',
				'orderby'    => 'meta_value',
				'meta_query' => array(
					array(
						'key'     => 'results_result',
						'compare' => 'EXISTS'
					)
				)
			);
			break;
	}

	query_posts(array_merge(array(
		'post_type'      => $_POST['type'],
		'lang'           => $_POST['lang'],
		'posts_per_page' => get_option('posts_per_page', -1),
		'paged'          => $_POST['page']
	), $args));

	while (have_posts()) {
		the_post();
		get_excerpt($_POST['type']);
	}

	wp_reset_postdata();

	wp_die();
}

if (wp_doing_ajax()) {
	add_action('wp_ajax_pagination', 'ajax_pagination');
	add_action('wp_ajax_nopriv_pagination', 'ajax_pagination');
}