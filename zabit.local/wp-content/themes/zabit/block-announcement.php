<?php

    query_posts(array(
        'post_type'  => 'event',
        'lang'       => pll_current_language('slug'),
        'showposts'  => 1,
        'order'      => 'DESC',
        'meta_key'   => 'info_date',
        'orderby'    => 'meta_value',
        'meta_query' => array(
            array(
                'key'     => 'results_result',
                'compare' => 'NOT EXISTS'
            )
        )
    ));

    $athlete = get_option('zabit_general_general_athlete', null);

    if (have_posts()) :
	    the_post();

        $date = get_post_meta(get_the_ID(), 'info_date', true);
        $opponent = get_post_meta(get_the_ID(), 'info_opponent', true);

        if ($opponent) {
	        $win_knockouts = get_post_meta($opponent, 'fights_win_knockouts', true);
	        $win_submissions = get_post_meta($opponent, 'fights_win_submissions', true);
	        $win_decisions = get_post_meta($opponent, 'fights_win_decisions', true);

	        $loss_knockouts = get_post_meta($opponent, 'fights_loss_knockouts', true);
	        $loss_submissions = get_post_meta($opponent, 'fights_loss_submissions', true);
	        $loss_decisions = get_post_meta($opponent, 'fights_loss_decisions', true);

	        $draws = get_post_meta($opponent, 'fights_draws', true);
        }
        ?>
        <a class="announcement" href="<?php the_permalink(); ?>" title="<?php _e('fight details', 'zabit'); ?>">
            <?php if ($date) : ?>
                <span class="announcement__date">
                    <span class="announcement__date__day"><?php echo date_i18n(__('d', 'zabit'), $date); ?></span>
                    <span class="announcement__date__details">
                        <span class="announcement__date__month"><?php echo date_i18n(__('F, Y', 'zabit'), $date); ?></span>
                        <span class="announcement__date__time"><?php printf(__('at %s', 'zabit'), date_i18n(__('h:i a', 'zabit'), $date)); ?></span>
                    </span>
                </span>
            <?php endif;
            if ($opponent) : ?>
                <span class="announcement__opponent">
                    <span class="announcement__opponent__image">
                        <?php if (has_post_thumbnail($opponent)) :
                            list($src, $width, $height) = wp_get_attachment_image_src(get_post_thumbnail_id($opponent), 'icon'); ?>
                            <img src="<?php echo $src; ?>" title="<?php echo get_the_title($opponent); ?>" alt="<?php echo get_the_title($opponent); ?>">
                        <?php elseif ($athlete) :
                            echo new SVG($athlete);
                        endif; ?>
                    </span>
                    <span class="announcement__opponent__caption">
                        <span class="announcement__opponent__name"><?php echo get_the_title($opponent); ?></span>
                        <span class="announcement__opponent__stats"><?php printf('%d-%d-%d', ($win_knockouts == '' ? 0 : intval($win_knockouts)) + ($win_submissions == '' ? 0 : intval($win_submissions)) + ($win_decisions == '' ? 0 : intval($win_decisions)), ($loss_knockouts == '' ? 0 : intval($loss_knockouts)) + ($loss_submissions == '' ? 0 : intval($loss_submissions)) + ($loss_decisions == '' ? 0 : intval($loss_decisions)), ($draws == '' ? 0 : intval($draws))); ?></span>
                    </span>
                </span>
            <?php endif; ?>
            <span class="announcement__link"><?php _e('fight details', 'zabit'); ?></span>
        </a>
    <?php endif;

    wp_reset_query();
    wp_reset_postdata();