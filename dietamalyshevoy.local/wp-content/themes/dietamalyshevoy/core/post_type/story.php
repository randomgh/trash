<?php

function story_init(){
    register_post_type('story', array(
        'label' => __('Stories', 'dem'),
        'labels' => array(
            'name' => __('Stories', 'dem'),
            'singular_name' => __('Story', 'dem'),
            'menu_name' => __('Stories', 'dem'),
            'name_admin_bar' => __('Story', 'dem'),
            'add_new' => __('Add new', 'dem'),
            'add_new_item' => __('Add new story', 'dem'),
            'new_item' => __('New story', 'dem'),
            'edit_item' => __('Edit story', 'dem'),
            'view_item' => __('View story', 'dem'),
            'view_items' => __('View stories', 'dem'),
            'all_items' => __('All stories', 'dem'),
            'search_items' => __('Search stories', 'dem'),
            'parent_item_colon' => __('Parent story:', 'dem'),
            'not_found' => __('No stories found.', 'dem'),
			'not_found_in_trash' => __('No stories found in Trash.', 'dem'),
			'archives' => __('Stories archives', 'dem'),
			'attributes' => __('Stories attributes', 'dem'),
			'insert_into_item' => __('Insert into stories', 'dem'),
			'uploaded_to_this_item' => __('Uploaded to this story', 'dem'),
			'featured_image' => __('Featured image', 'dem'),
			'set_featured_image' => __('Set featured image', 'dem'),
			'remove_featured_image' => __('Remove featured image', 'dem'),
			'use_featured_image' => __('Use as featured image', 'dem'),
			'filter_items_list' => __('Filter stories list', 'dem'),
			'items_list_navigation' => __('Stories list navigation', 'dem'),
			'items_list' => __('Stories list', 'dem'),
			'item_published' => __('Story published.', 'dem'),
			'item_published_privately' => __('Story published privately.', 'dem'),
			'item_reverted_to_draft' => __('Story reverted to draft.', 'dem'),
			'item_scheduled' => __('Story scheduled.', 'dem'),
			'item_updated' => __('Story updated.', 'dem'),
		),
		'description' => __('Stories.', 'dem'),
		'public' => true,
		'exclude_from_search' => false,
		'publicly_queryable' => true,
		'show_ui' => true,
		'show_in_nav_menus' => true,
		'show_in_menu' => true,
		'show_in_admin_bar' => true,
		'query_var' => true,
		'rewrite' => array('slug' => 'stories'),
		'capability_type' => 'post',
		'has_archive' => true,
		'hierarchical' => false,
		'menu_position' => 3,
		'menu_icon' => 'dashicons-smiley',
		'supports' => array('title', 'editor', 'revisions'),
		'delete_with_user' => false,
		'map_meta_cap' => null,
		'show_in_rest' => true,
		'rest_base' => 'stories'
	));

	new MetaBox(array(
		'id' => 'photos',
		'title' => __('Photos', 'dem'),
		'screen' => 'story',
		'context' => 'side',
		'priority' => 'default'
	), array(
		array(
			'id'          => 'before',
			'title'       => __('Before', 'dem'),
			'type'        => 'media',
			'description' => __('Before.', 'dem'),
			'sanitize'    => 'esc_attr',
			'single'      => true,
			'default'     => '',
			'class'       => '',
			'options'     => array(
				'type' => 'image'
			)
		),
		array(
			'id'          => 'after',
			'title'       => __('After', 'dem'),
			'type'        => 'media',
			'description' => __('After.', 'dem'),
			'sanitize'    => 'esc_attr',
			'single'      => true,
			'default'     => '',
			'class'       => '',
			'options'     => array(
				'type' => 'image'
			)
		)
	));

	new MetaBox(array(
		'id'       => 'quote',
		'title'    => __('Quote', 'dem'),
		'screen'   => 'story',
		'context'  => 'normal',
		'priority' => 'default'
	), array(array(
		'id'          => 'text',
		'type'        => 'editor',
		'description' => __('Quote.', 'dem'),
		'placeholder' => __('Quote', 'dem')
	)));

	new MetaBox(array(
		'id'       => 'bio',
		'title'    => __('Bio', 'dem'),
		'screen'   => 'story',
		'context'  => 'normal',
		'priority' => 'default'
	), array(
		array(
			'id'          => 'bday',
			'type'        => 'datetime',
			'title'       => __('BDay', 'dem'),
			'description' => __('BDay.', 'dem'),
			'options'     => array('yy', 'mm', 'dd')
		),
		array(
			'id'          => 'city',
			'type'        => 'text',
			'title'       => __('City', 'dem'),
			'description' => __('City.', 'dem'),
			'placeholder' => __('City', 'dem')
		)
	));

	new MetaBox(array(
		'id'       => 'product',
		'title'    => __('Product', 'dem'),
		'screen'   => 'story',
		'context'  => 'normal',
		'priority' => 'default'
	), array(
		array(
			'id'          => 'from',
			'type'        => 'datetime',
			'title'       => __('From', 'dem'),
			'description' => __('From.', 'dem'),
			'options'     => array('yy', 'mm')
		),
		array(
			'id'          => 'till',
			'type'        => 'datetime',
			'title'       => __('Till', 'dem'),
			'description' => __('Till.', 'dem'),
			'options'     => array('yy', 'mm')
		),
		array(
			'id'          => 'program',
			'type'        => 'text',
			'title'       => __('Program', 'dem'),
			'description' => __('Program.', 'dem'),
			'placeholder' => __('Program', 'dem')
		),
		array(
			'id'          => 'weight',
			'type'        => 'number',
			'title'       => __('Weight', 'dem'),
			'description' => __('Weight.', 'dem'),
			'options'     => array(
				'min'  => 0,
				'step' => 1
			)
		)
	));
}
add_action('init', 'story_init');