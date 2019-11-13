<?php

function madtd_post_init(){
	foreach (array('post-formats', 'trackbacks', 'comments', 'author', 'custom-fields', 'page-attributes', 'excerpt', 'thumbnail') as $feature) {
		remove_post_type_support('post', $feature);
	}

	foreach (array() as $feature) {
		add_post_type_support('post', $feature);
	}
}
add_action('init', 'madtd_post_init');