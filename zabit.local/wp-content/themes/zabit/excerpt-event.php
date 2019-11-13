<?php

    $date = get_post_meta(get_the_ID(), 'info_date', true);
    $place = get_post_meta(get_the_ID(), 'info_place', true);

    $info_event = get_post_meta(get_the_ID(), 'info_event', true);
    $info_ufc = get_post_meta(get_the_ID(), 'info_ufc', true);
    $result = get_post_meta(get_the_ID(), 'results_result', true);
    $round = get_post_meta(get_the_ID(), 'results_round', true);
    $time = get_post_meta(get_the_ID(), 'results_time', true);
    $method = get_post_meta(get_the_ID(), 'results_method', true);

    if ($method != '') {
        switch ($method) {
	        case 'knockout':
		        $method = 'ko';
		        break;
	        case 'submission':
		        $method = 'sub';
		        break;
	        case 'decision':
		        $method = 'dec';
		        break;
        }
    }

    $opponent1 = get_post_meta(get_the_ID(), 'info_opponent', true);
    $opponent2 = get_option('zabit_bio_general_athlete', null);

    if ($opponent1) {
        $opponent1Title = explode(' ', get_the_title($opponent1));
        $opponent1TitleCount = count($opponent1Title);

        $opponent1_first_name = implode(' ', $opponent1TitleCount > 1 ? array_slice($opponent1Title, 0, -1) : $opponent1Title);
        $opponent1_last_name = $opponent1TitleCount > 1 ? $opponent1Title[$opponent1TitleCount - 1] : '';

        if (has_post_thumbnail($opponent1)) {
	        list($src1, $width1, $height1) = wp_get_attachment_image_src(get_post_thumbnail_id($opponent1), 'opponent');
        }
    }

    if ($opponent2) {
        $opponent2 = pll_get_post($opponent2);

        $opponent2Title = explode(' ', get_the_title($opponent2));
        $opponent2TitleCount = count($opponent2Title);

        $opponent2_first_name = implode(' ', $opponent2TitleCount > 1 ? array_slice($opponent2Title, 0, -1) : $opponent2Title);
        $opponent2_last_name = $opponent2TitleCount > 1 ? $opponent2Title[$opponent2TitleCount - 1] : '';

        if (has_post_thumbnail($opponent2)) {
            list($src2, $width2, $height2) = wp_get_attachment_image_src(get_post_thumbnail_id($opponent2), 'opponent');
        }
    }

    if ((isset($opponent1TitleCount) && $opponent1TitleCount) || (isset($opponent2TitleCount) && $opponent2TitleCount)) {
        $title = '';

	    if (isset($opponent1TitleCount) && $opponent1TitleCount) {
		    $title .= $opponent1_last_name ? $opponent1_last_name : $opponent1_first_name;
	    }
        if ((isset($opponent1TitleCount) && $opponent1TitleCount) && (isset($opponent2TitleCount) && $opponent2TitleCount)) {
            $title .= __(' vs. ', 'zabit');
        }
	    if (isset($opponent2TitleCount) && $opponent2TitleCount) {
		    $title .= $opponent2_last_name ? $opponent2_last_name : $opponent2_first_name;
	    }
    }

    $athlete = get_option('zabit_general_general_athlete', null);

?>
<a class="event-excerpt" href="<?php the_permalink(); ?>" title="<?php echo isset($title) ? $title : get_the_title(); ?>">
    <div class="event-excerpt__aside">
        <span class="event-excerpt__fighter <?php echo $result == 'loss' ? 'event-excerpt__fighter_win' : ''; ?>">
            <?php if (isset($src1)) : ?>
                <img src="<?php echo $src1; ?>" title="<?php echo get_the_title($opponent1); ?>" alt="<?php echo get_the_title($opponent1); ?>">
            <?php elseif ($athlete != '') :
                echo new SVG($athlete);
            endif; ?>
        </span>
        <span class="event-excerpt__fighter <?php echo $result == 'win' ? 'event-excerpt__fighter_win' : ''; ?>">
            <?php if (isset($src2)) : ?>
                <img src="<?php echo $src2; ?>" title="<?php echo get_the_title($opponent2); ?>" alt="<?php echo get_the_title($opponent2); ?>">
            <?php elseif ($athlete != '') :
	            echo new SVG($athlete);
            endif; ?>
        </span>
    </div>
    <div class="event-excerpt__body">
        <span class="event-excerpt__date"><?php echo date_i18n(__('F d, Y', 'zabit'), $date); ?></span>
        <div class="event-excerpt__title"><?php echo isset($title) ? $title : get_the_title(); ?></div>
        <ul class="event-excerpt__info">
            <li class="event-excerpt__indicator">
                <span class="event-excerpt__indicator__title"><?php echo $info_event != '' ? $info_event : '&mdash;'; ?></span>
                <span class="event-excerpt__indicator__value"><?php echo $info_ufc != '' ? $info_ufc : '&mdash;'; ?></span>
            </li>
            <li class="event-excerpt__indicator">
                <span class="event-excerpt__indicator__title"><?php _e('round', 'zabit'); ?></span>
                <span class="event-excerpt__indicator__value"><?php echo $round != '' ? $round : '&mdash;'; ?></span>
            </li>
            <li class="event-excerpt__indicator">
                <span class="event-excerpt__indicator__title"><?php _e('time', 'zabit'); ?></span>
                <span class="event-excerpt__indicator__value"><?php echo $time != '' ? date_i18n(__('i:s', 'zabit'), $time) : '&mdash;'; ?></span>
            </li>
            <li class="event-excerpt__indicator">
                <span class="event-excerpt__indicator__title"><?php _e('method', 'zabit'); ?></span>
                <span class="event-excerpt__indicator__value"><?php echo $method != '' ? $method : '&mdash;'; ?></span>
            </li>
        </ul>
    </div>
</a>