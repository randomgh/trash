<?php

	function breadcrumbs_wp($wp) {
		global $breadcrumbs;

		$breadcrumbs = array();

		// TODO: Consider using $route to count crumbs
		if (!is_front_page()) {
			switch (true) {
				case is_home():
					$id = get_option('page_for_posts', null);

					$breadcrumbs[] = array(
						'title' => get_the_title($id),
						'href' => get_the_permalink($id)
					);
					break;
				case is_404():
					$id = get_option('dem_general_general_error_page', null);

					$breadcrumbs[] = array(
						'title' => get_the_title($id),
						'href' => get_the_permalink($id)
					);
					break;
				case is_archive():
					switch(true){
						case is_post_type_archive('news'):
							$breadcrumbs[] = array(
								'title' => __('Новости', 'dem'),
								'href' => get_post_type_archive_link('news')
							);
							break;
						case is_post_type_archive('story'):
							$breadcrumbs[] = array(
								'title' => __('Истории успеха', 'dem'),
								'href' => get_post_type_archive_link('story')
							);
							break;
						case is_post_type_archive('landing'):
							$breadcrumbs[] = array(
								'title' => __('Landings', 'dem'),
								'href' => get_post_type_archive_link('landing')
							);
							break;
						default:
							$id = get_option('page_for_posts', null);

							$breadcrumbs[] = array(
								'title' => get_the_title($id),
								'href' => get_the_permalink($id)
							);
							break;
					}
					break;
				case is_single():
					switch (true) {
						case is_singular(array('news')):
							$breadcrumbs[] = array(
								'title' => __('Новости', 'dem'),
								'href' => get_post_type_archive_link('news')
							);
							break;
						case is_singular(array('story')):
							$breadcrumbs[] = array(
								'title' => __('Истории успеха', 'dem'),
								'href' => get_post_type_archive_link('story')
							);
							break;
						case is_singular(array('landing')):
							$breadcrumbs[] = array(
								'title' => __('Landings', 'dem'),
								'href' => get_post_type_archive_link('landing')
							);
							break;
						default:
							$id = get_option('page_for_posts', null);

							$breadcrumbs[] = array(
								'title' => get_the_title($id),
								'href' => get_the_permalink($id)
							);
							break;
					}

					$id = get_the_ID();

					$breadcrumbs[] = array(
						'title' => get_the_title($id),
						'href' => get_the_permalink($id)
					);
					break;
				case is_page():
					$id = get_the_ID();

					while ($id) {
						array_unshift($breadcrumbs, array(
							'title' => get_the_title($id),
							'href' => get_the_permalink($id)
						));

						$id = wp_get_post_parent_id($id);
					}

					break;
			}

			array_unshift($breadcrumbs, array(
				'title' => get_the_title(get_option('page_on_front')),
				'href' => home_url()
			));
		}
	}
	add_action('wp', 'breadcrumbs_wp', 10, 1);