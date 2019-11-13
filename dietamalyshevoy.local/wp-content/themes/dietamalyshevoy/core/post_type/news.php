<?php

function news_init(){
	register_post_type('news', array(
		'label' => __('News', 'dem'),
		'labels' => array(
			'name' => __('News', 'dem'),
			'singular_name' => __('News post', 'dem'),
			'menu_name' => __('News', 'dem'),
			'name_admin_bar' => __('News post', 'dem'),
			'add_new' => __('Add new', 'dem'),
			'add_new_item' => __('Add new news post', 'dem'),
			'new_item' => __('New news post', 'dem'),
			'edit_item' => __('Edit news post', 'dem'),
			'view_item' => __('View news post', 'dem'),
			'view_items' => __('View news', 'dem'),
			'all_items' => __('All news', 'dem'),
			'search_items' => __('Search news', 'dem'),
			'parent_item_colon' => __('Parent news post:', 'dem'),
			'not_found' => __('No news found.', 'dem'),
			'not_found_in_trash' => __('No news found in Trash.', 'dem'),
			'archives' => __('News archives', 'dem'),
			'attributes' => __('News attributes', 'dem'),
			'insert_into_item' => __('Insert into news', 'dem'),
			'uploaded_to_this_item' => __('Uploaded to this news post', 'dem'),
			'featured_image' => __('Featured image', 'dem'),
			'set_featured_image' => __('Set featured image', 'dem'),
			'remove_featured_image' => __('Remove featured image', 'dem'),
			'use_featured_image' => __('Use as featured image', 'dem'),
			'filter_items_list' => __('Filter news list', 'dem'),
			'items_list_navigation' => __('News list navigation', 'dem'),
			'items_list' => __('News list', 'dem'),
			'item_published' => __('News post published.', 'dem'),
			'item_published_privately' => __('News post published privately.', 'dem'),
			'item_reverted_to_draft' => __('News post reverted to draft.', 'dem'),
			'item_scheduled' => __('News post scheduled.', 'dem'),
			'item_updated' => __('News post updated.', 'dem'),
		),
		'description' => __('News.', 'dem'),
		'public' => true,
		'exclude_from_search' => false,
		'publicly_queryable' => true,
		'show_ui' => true,
		'show_in_nav_menus' => true,
		'show_in_menu' => true,
		'show_in_admin_bar' => true,
		'query_var' => true,
		'rewrite' => array('slug' => 'news'),
		'capability_type' => 'post',
		'has_archive' => true,
		'hierarchical' => false,
		'menu_position' => 3,
		'menu_icon' => 'dashicons-media-document',
		'supports' => array('title', 'editor', 'thumbnail', 'revisions'),
		'delete_with_user' => false,
		'map_meta_cap' => null,
		'show_in_rest' => true,
		'rest_base' => 'news'
	));
}
add_action('init', 'news_init');