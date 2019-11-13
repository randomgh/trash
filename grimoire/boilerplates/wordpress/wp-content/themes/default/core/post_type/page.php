<?php

function madtd_page_init(){
	foreach (array('post-formats', 'trackbacks', 'comments', 'author', 'custom-fields', 'page-attributes', 'thumbnail') as $feature) {
		remove_post_type_support('page', $feature);
	}

	foreach (array('excerpt') as $feature) {
		add_post_type_support('page', $feature);
	}
}
add_action('init', 'madtd_page_init');