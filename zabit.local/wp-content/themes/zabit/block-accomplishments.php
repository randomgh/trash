<?php

    $taxonomies = get_terms(array(
        'taxonomy'     => 'accomplishment',
        'hide_empty'   => true,
        'fields'       => 'all',
        'hierarchical' => false
    ));

    $accomplishments = array();

    foreach($taxonomies as $taxonomy){
	    $taxonomy_option = get_option("taxonomy_".$taxonomy->term_id, 0);

	    $accomplishments[] = array(
            'taxonomy' => $taxonomy,
            'priority' => esc_attr($taxonomy_option['priority'])
        );
    }

    usort($accomplishments, function($a, $b) {
        if ($a['priority'] == $b['priority']) {
            return 0;
        } else if ($a['priority'] > $b['priority']) {
            return 1;
        } else {
            return -1;
        }
    });

    $accomplishments = array_map(function($accomplishment) {
        return array(
	        'title' => $accomplishment['taxonomy']->name,
            'goals' => array_map(function($goal) {
                return array(
	                'title'       => get_post_meta($goal->ID, 'general_title', true),
	                'description' => get_post_meta($goal->ID, 'general_description', true)
                );
            }, get_posts(array(
	            'post_type'   => 'goal',
	            'numberposts' => -1,
	            'tax_query'   => array(
		            array(
			            'taxonomy'         => 'accomplishment',
			            'field'            => 'id',
			            'terms'            => $accomplishment['taxonomy']->term_id,
			            'include_children' => false
		            )
	            )
            )))
        );
    }, $accomplishments);

    if (isset($accomplishments) && count($accomplishments)) : ?>
        <ul class="accomplishments">
            <?php array_map(function($accomplishment) { ?>
                <li class="accomplishments__item">
                    <?php if (isset($accomplishment['title'])) : ?>
                        <div class="accomplishments__item__title"><?php echo $accomplishment['title']; ?></div>
                    <?php endif;
                    if (isset($accomplishment['goals']) && count($accomplishment['goals'])) : ?>
                        <ul class="accomplishments__goals accomplishments__item__goals">
                            <?php array_map(function($goal) { ?>
                                <li class="accomplishments__goals__item">
                                    <?php if (isset($goal['title'])) : ?>
                                        <p class="accomplishments__goals__item__title"><?php echo $goal['title']; ?></p>
                                    <?php endif;
                                    if (isset($goal['description'])) : ?>
                                        <span class="accomplishments__goals__item__description"><?php echo $goal['description']; ?></span>
                                    <?php endif; ?>
                                </li>
                                <?php return $goal;
                            }, $accomplishment['goals']); ?>
                        </ul>
                    <?php endif; ?>
                </li>
                <?php return $accomplishment;
            }, $accomplishments); ?>
        </ul>
    <?php endif;
