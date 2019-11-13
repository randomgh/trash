<div class="pagination pagination_hidden" data-type="<?php echo $wp_query->query_vars['post_type']; ?>" data-lang="<?php echo $wp_query->query_vars['lang']; ?>" data-page="<?php echo get_query_var('paged') == 0 ? 1 : get_query_var('paged'); ?>" data-pages="<?php echo $wp_query->max_num_pages; ?>">
    <?php get_block('loader'); ?>
</div>