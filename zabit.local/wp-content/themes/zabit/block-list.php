<?php

    global $route;

    $type = !is_main_query() && $route == 'index' ? 'news' : $route;

?>
<div class="<?php echo $type; ?>-list">
	<?php while (have_posts()) {
		the_post();
		get_excerpt($type);
	}

	if ($wp_query->max_num_pages > 1) :
		if (is_main_query() && get_query_var('paged') == 0) :
			get_block('pagination');
		else : ?>
            <div class="<?php echo $type; ?>-list__nav">
                <a class="<?php echo $type; ?>-list__link" href="<?php echo get_post_type_archive_link($type); ?>" title="<?php printf(__('view all %s', 'zabit'), $type == 'news' ? $type : $type.'s'); ?>"><?php printf(__('view all %s', 'zabit'), $type == 'news' ? $type : $type.'s'); ?></a>
            </div>
		<?php endif;
	endif; ?>
</div>