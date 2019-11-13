<?php

    $background = get_option('zabit_general_general_left_image', null);

    query_posts(array(
        'post_type'  => 'event',
        'lang'       => pll_current_language('slug'),
        'showposts'  => 1,
        'order'      => 'ASC',
        'meta_key'   => 'info_date',
        'orderby'    => 'meta_value',
        'meta_query' => array(
            array(
                'key' => 'results_result',
                'compare' => 'NOT EXISTS'
            )
        )
    ));

?>
<aside class="aside aside_left aside_full aside_event">
    <?php
        if ($background) get_background($background, 'left');

        if (have_posts()) {
	        get_block('event');
        } else {
            get_title(__('Recent fights', 'zabit'));
            get_block('stats');
        }
    ?>
</aside>
<?php
    wp_reset_query();
    wp_reset_postdata();