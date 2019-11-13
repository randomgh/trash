<?php

	function router_wp($wp) {
		global $route;

		switch (true) {
			case is_front_page():
				$route = 'index';
				break;
			case is_home():
				$route = 'post';
				break;
			case is_404():
				$route = 'error';
				break;
			case is_archive():
				switch (true) {
					case is_post_type_archive('news'):
						$route = 'archive-news';
						break;
					case is_post_type_archive('story'):
						$route = 'archive-story';
						break;
					case is_post_type_archive('landing'):
						$route = 'archive-landing';
						break;
					default:
						$route = 'archive-post';
						break;
				}
				break;
			case is_single():
				switch(true){
					case is_singular(array('news')):
						$route = 'news';
						break;
					case is_singular(array('story')):
						$route = 'story';
						break;
					case is_singular(array('landing')):
						$route = 'landing';
						break;
					default:
						$route = 'post';
						break;
				}
				break;
			case is_page():
				switch(true){
					case get_the_ID() == get_option('page_on_front', null):
						$route = 'index';
						break;
					case get_the_ID() == get_option('page_for_posts', null):
						$route = 'post';
						break;
					case get_the_ID() == get_option('dem_general_general_about_page', null):
						$route = 'about';
						break;
					case get_the_ID() == get_option('dem_general_general_contacts_page', null):
						$route = 'contacts';
						break;
					case get_the_ID() == get_option('dem_general_general_error_page', null):
						$route = 'error';
						break;
                    case get_the_ID() == get_option('dem_general_general_registration_page', null):
                        $route = 'registration';
                        break;
                    case get_the_ID() == get_option('dem_general_general_registration-phone_page', null):
                        $route = 'registration-phone';
                        break;
                    case get_the_ID() == get_option('dem_general_general_login_page', null):
                        $route = 'login';
                        break;
                    case get_the_ID() == get_option('dem_general_general_restore-password_page', null):
                        $route = 'restore-password';
                        break;
                    case get_the_ID() == get_option('dem_general_general_new-password_page', null):
                        $route = 'new-password';
                        break;
					default:
						$route = 'page';
						break;
				}
				break;
			default:
				$route = '';
				break;
		}
	}
	add_action('wp', 'router_wp', 10, 1);