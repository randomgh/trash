<?php

    global $route;

    // TODO: Add screen readers support & microdata attributes & order tabindex

    get_header();

    switch ($route) {
        case 'index':
	        the_post();
	        the_content();
//            get_section('home_head');
//            get_section('home_form1');
//            get_section('home_features');
//            get_section('home_tabs');
//            get_section('home_cards');
//            get_section('home_slider');
//            get_section('home_form2');
            break;
        case 'about':
	        the_post();
	        the_content();
//            get_section('about-main');
//            get_section('about-menu');
//            get_section('about-description');
//            get_section('about-food_intake_list');
//            get_section('about-description');
//            get_section('about-food_intake');
//            get_section('about-appeal');
            break;
	    case 'contacts':
		    the_post();
		    the_content();
//		    get_section('contacts_head');
//		    get_section('contacts_columns');
//		    get_section('contacts_list1');
//		    get_section('contacts_list2');
//		    get_section('contacts_partners');
//		    get_section('contacts_legal');
		    break;
	    case 'error':
	    	$errorID = get_option('dem_general_general_error_page', null);

	    	if ($errorID) {
			    if (get_the_ID() == $errorID) {
				    the_post();
			    } else {
				    $errorQuery = new WP_Query(array('post_id' => $errorID));

				    $errorQuery->the_post();
			    }

			    the_content();
		    } else {
		        get_section('error');
		    }
		    break;
	    case 'page':
		    the_post();
//		    the_content();
		    get_section('page');
		    break;
	    case 'archive-post':
//		    get_section();
		    break;
	    case 'post':
		    the_post();
		    the_content();
//		    get_section();
		    break;
	    case 'archive-news':
//		    get_section('archive-news_head');
//		    get_section('archive-news_list');
//		    get_section('archive-news_newsletter');
		    break;
	    case 'news':
		    the_post();
		    the_content();
//		    get_section('news');
		    break;
	    case 'archive-story':
//		    get_section('archive-story_head');
//		    get_section('archive-story_list');
		    break;
	    case 'story':
		    the_post();
		    the_content();
//		    get_section('story');
		    break;
        case 'registration':
            get_section('authorization_registration');
            break;
        case 'registration-phone':
            get_section('authorization_registration-phone');
            break;
        case 'login':
            get_section('authorization_login');
            break;
        case 'restore-password':
            get_section('authorization_restore-password');
            break;
        case 'new-password':
            get_section('authorization_new-password');
            break;
        default:
            get_section();
    }

    get_footer();