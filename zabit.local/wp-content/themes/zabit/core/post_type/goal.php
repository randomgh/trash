<?php

function goal_init(){
	register_post_type('goal', array(
		'label' => __('Goals', 'zabit'),
		'labels' => array(
			'name' => __('Goals', 'zabit'),
			'singular_name' => __('Goal', 'zabit'),
			'menu_name' => __('Goals', 'zabit'),
			'name_admin_bar' => __('Goal', 'zabit'),
			'add_new' => __('Add new', 'zabit'),
			'add_new_item' => __('Add new goal', 'zabit'),
			'new_item' => __('New goal', 'zabit'),
			'edit_item' => __('Edit goal', 'zabit'),
			'view_item' => __('View goal', 'zabit'),
			'view_items' => __('View goals', 'zabit'),
			'all_items' => __('All goals', 'zabit'),
			'search_items' => __('Search goals', 'zabit'),
			'parent_item_colon' => __('Parent goal:', 'zabit'),
			'not_found' => __('No goals found.', 'zabit'),
			'not_found_in_trash' => __('No goals found in Trash.', 'zabit'),
			'archives' => __('Goals archives', 'zabit'),
			'attributes' => __('Goals attributes', 'zabit'),
			'insert_into_item' => __('Insert into goals', 'zabit'),
			'uploaded_to_this_item' => __('Uploaded to this goal', 'zabit'),
			'featured_image' => __('Featured image', 'zabit'),
			'set_featured_image' => __('Set featured image', 'zabit'),
			'remove_featured_image' => __('Remove featured image', 'zabit'),
			'use_featured_image' => __('Use as featured image', 'zabit'),
			'filter_items_list' => __('Filter goals list', 'zabit'),
			'items_list_navigation' => __('Goals list navigation', 'zabit'),
			'items_list' => __('Goals list', 'zabit'),
			'item_published' => __('Goal published.', 'zabit'),
			'item_published_privately' => __('Goal published privately.', 'zabit'),
			'item_reverted_to_draft' => __('Goal reverted to draft.', 'zabit'),
			'item_scheduled' => __('Goal scheduled.', 'zabit'),
			'item_updated' => __('Goal updated.', 'zabit'),
		),
		'description' => __('Goals.', 'zabit'),
		'public' => true,
		'exclude_from_search' => false,
		'publicly_queryable' => true,
		'show_ui' => true,
		'show_in_nav_menus' => true,
		'show_in_menu' => true,
		'show_in_admin_bar' => true,
		'query_var' => true,
		'rewrite' => array('slug' => 'goals'),
		'capability_type' => 'page',
		'has_archive' => true,
		'hierarchical' => false,
		'menu_position' => 6,
		'menu_icon' => 'dashicons-awards',
		'supports' => array('title'),
		'delete_with_user' => false,
		'map_meta_cap' => null,
		'show_in_rest' => true,
		'rest_base' => 'goals'
	));

	register_taxonomy(
		'accomplishment',
		array('goal'),
		array(
			'label' => _x('Accomplishments', 'taxonomy general name', 'zabit'),
			'labels' => array(
				'name' => _x('Accomplishments', 'taxonomy general name', 'zabit'),
				'singular_name' => _x('Accomplishment', 'taxonomy singular name', 'zabit'),
				'menu_name' => __('Accomplishments', 'zabit'),
				'all_items' => __('All accomplishments', 'zabit'),
				'edit_item' => __('Edit accomplishment', 'zabit'),
				'view_item' => __('View accomplishment', 'zabit'),
				'update_item' => __('Update accomplishment', 'zabit'),
				'add_new_item' => __('Add accomplishment', 'zabit'),
				'new_item_name' => __('New accomplishment name', 'zabit'),
				'parent_item' => __('Parent accomplishment', 'zabit'),
				'parent_item_colon' => __('Parent accomplishment:', 'zabit'),
				'search_items' => __('Search accomplishment', 'zabit'),
				'popular_items' => __('Popular accomplishments', 'zabit'),
				'separate_items_with_commas' => __('Separate accomplishments with commas', 'zabit'),
				'add_or_remove_items' => __('Add or remove accomplishments', 'zabit'),
				'choose_from_most_used' => __('Choose from the most used accomplishments', 'zabit'),
				'not_found' => __('No accomplishments found.', 'zabit')
			),
			'description' => __('Accomplishment.', 'zabit'),
			'public' => true,
			'publicly_queryable' => true,
			'show_ui' => true,
			'show_in_menu' => true,
			'show_in_nav_menus' => true,
			'show_tagcloud' => true,
			'show_in_quick_edit' => true,
			'show_admin_column' => true,
			'hierarchical' => false,
			'sort' => true,
			'rewrite' => array('slug' => 'accomplishment')
		)
	);

	new MetaBox(array(
		'id'       => 'general',
		'title'    => __('General', 'zabit'),
		'screen'   => 'goal',
		'context'  => 'normal',
		'priority' => 'default'
	), array(array(
		'id'          => 'title',
		'type'        => 'editor',
		'description' => __('Title.', 'zabit'),
		'placeholder' => __('Title', 'zabit')
	), array(
		'id'          => 'description',
		'type'        => 'editor',
		'description' => __('Description.', 'zabit'),
		'placeholder' => __('Description', 'zabit')
	)));

	//TODO: remove apps non-html fix
	new MetaBox(array(
		'id'       => 'apps',
		'title'    => __('Apps', 'zabit'),
		'screen'   => 'goal',
		'context'  => 'normal',
		'priority' => 'default'
	), array(array(
		'id'          => 'title',
		'type'        => 'textarea',
		'description' => __('Title.', 'zabit'),
		'placeholder' => __('Title', 'zabit')
	), array(
		'id'          => 'description',
		'type'        => 'textarea',
		'description' => __('Description.', 'zabit'),
		'placeholder' => __('Description', 'zabit')
	)));
}
add_action('init', 'goal_init');

function goal_use_block_editor_for_post_type($current_status, $post_type) {
	return $post_type === 'goal' ? false : $current_status;
}
add_filter('use_block_editor_for_post_type', 'goal_use_block_editor_for_post_type', 10, 2);

function zabit_term_meta_add_form_fields(){
	?>
    <div class="form-field term-priority-wrap">
        <label for="term_meta[priority]"><?php _e('Priority', 'zabit'); ?></label>
        <input name="term_meta[priority]" id="term_meta[priority]" type="number" value="0" size="40">
        <p><?php _e('Priority number.', 'zabit'); ?></p>
    </div>
	<?php
}
add_action('accomplishment_add_form_fields', 'zabit_term_meta_add_form_fields', 10, 2);

function zabit_term_meta_edit_form_fields($term) {
	$term_meta = get_option("taxonomy_".$term->term_id);
	$value = esc_attr($term_meta['priority']); ?>
    <tr class="form-field term-priority-wrap">
        <th scope="row"><label for="term_meta[priority]"><?php _e('Priority', 'zabit'); ?></label></th>
        <td>
            <input name="term_meta[priority]" id="term_meta[priority]" type="number" value="<?php echo $value ? $value : '0'; ?>" size="40">
            <p class="description"><?php _e('Priority number.', 'zabit'); ?></p>
        </td>
    </tr>
	<?php
}
add_action('accomplishment_edit_form_fields', 'zabit_term_meta_edit_form_fields', 10, 2);

function zabit_save_term_meta($term_id){
	if(isset($_POST['term_meta'])){
		$term_meta = get_option("taxonomy_".$term_id);

		foreach(array_unique(array_merge(array_keys($_POST['term_meta']), (is_array($term_meta))?(array_keys($term_meta)):(array()))) as $key){
			if(isset($_POST['term_meta'][$key]) && ($key != 'priority' || $_POST['term_meta'][$key])){
				$term_meta[$key] = $_POST['term_meta'][$key];
			}else if(isset($term_meta[$key])){
				unset($term_meta[$key]);
			}
		}
		update_option("taxonomy_".$term_id, $term_meta);
	}
}
add_action('edited_accomplishment', 'zabit_save_term_meta', 10, 2);
add_action('create_accomplishment', 'zabit_save_term_meta', 10, 2);

function goal_item_rss() {
	global $wp_query;
	global $post;

	if ($post->post_type == 'goal') {
		?>
        <query_total><?php echo $wp_query->found_posts; ?></query_total>
        <query_current><?php echo $wp_query->current_post + 1; ?></query_current>

        <accomplishments>
			<?php array_map(function($accomplishment) { ?>
                <accomplishment id="<?php echo $accomplishment->term_id; ?>"><?php echo $accomplishment->name; ?></accomplishment>
				<?php return $accomplishment;
			}, wp_get_post_terms($post->ID, 'accomplishment', array('fields' => 'all'))); ?>
        </accomplishments>
		<?php
	}
}
add_action('rss2_item', 'goal_item_rss');

function goal_entity_rss() {
	global $post;

	if ($post->post_type == 'goal') {
		$previous = get_previous_post();
		$next = get_next_post();

		if ($previous) :
			?>
            <previous id="<?php echo $previous->ID; ?>"><?php echo get_permalink($previous); ?></previous>
		<?php
		endif;

		if ($next) :
			?>
            <next id="<?php echo $next->ID; ?>"><?php echo get_permalink($next); ?></next>
		<?php
		endif;

		?>
        <accomplishments>
			<?php array_map(function($accomplishment) { ?>
                <accomplishment id="<?php echo $accomplishment['taxonomy']->term_id; ?>" priority="<?php echo $accomplishment['priority']; ?>"><?php echo $accomplishment['taxonomy']->name; ?></accomplishment>
				<?php return $accomplishment;
			}, wp_get_post_terms($post->ID, 'accomplishment', array('fields' => 'all'))); ?>
        </accomplishments>
		<?php
	}
}
add_action('commentsrss2_head', 'goal_entity_rss');