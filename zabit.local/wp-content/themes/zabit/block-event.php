<?php

    the_post();

    $date = get_post_meta(get_the_ID(), 'info_date', true);
    $timezone = get_post_meta(get_the_ID(), 'info_timezone', true);
    $place = get_post_meta(get_the_ID(), 'info_place', true);

    if ($timezone) {
	    $sign = $timezone < 0 ? '-' : '+';
	    $offset = abs($timezone);
	    $offset = $offset < 10 ? '0'.$offset : "{$offset}";
	    $timezone = $sign.$offset;
    }

    $opponent1 = get_post_meta(get_the_ID(), 'info_opponent', true);
    $opponent2 = get_option('zabit_bio_general_athlete', null);

    if ($opponent1) {
        $opponent1Title = explode(' ', get_the_title($opponent1));
        $opponent1TitleCount = count($opponent1Title);

	    $opponent1_first_name = implode(' ', $opponent1TitleCount > 1 ? array_slice($opponent1Title, 0, -1) : $opponent1Title);
	    $opponent1_last_name = $opponent1TitleCount > 1 ? $opponent1Title[$opponent1TitleCount - 1] : '';
    }

    if ($opponent2) {
	    $opponent2 = pll_get_post($opponent2);

        $opponent2Title = explode(' ', get_the_title($opponent2));
        $opponent2TitleCount = count($opponent2Title);

	    $opponent2_first_name = implode(' ', $opponent2TitleCount > 1 ? array_slice($opponent2Title, 0, -1) : $opponent2Title);
	    $opponent2_last_name = $opponent2TitleCount > 1 ? $opponent2Title[$opponent2TitleCount - 1] : '';
    }
?>
<div class="event">
	<?php if ((isset($opponent1TitleCount) && $opponent1TitleCount) || (isset($opponent2TitleCount) && $opponent2TitleCount)) : ?>
        <div class="event__header">
            <div class="event__header__sup"><?php _e('upcoming', 'zabit'); ?></div>
            <?php if (isset($opponent1TitleCount) && $opponent1TitleCount) : ?>
                <div class="event__header__opponent"><?php echo $opponent1_last_name ? $opponent1_last_name : $opponent1_first_name; ?></div>
            <?php endif;
            if (isset($opponent1TitleCount) && $opponent1TitleCount && isset($opponent2TitleCount) && $opponent2TitleCount) : ?>
                <div class="event__header__separator"><?php _e('vs.', 'zabit'); ?></div>
            <?php endif;
            if (isset($opponent2TitleCount) && $opponent2TitleCount) : ?>
                <div class="event__header__opponent"><?php echo $opponent2_last_name ? $opponent2_last_name : $opponent2_first_name; ?></div>
            <?php endif; ?>
        </div>
	<?php endif; ?>
	<?php if ($date || $place) : ?>
        <div class="event__details">
            <div class="event__details__text"><?php _e('details', 'zabit'); ?></div>
            <?php if ($date) : ?>
                <div class="event__details__date"><?php printf('%s %s', date_i18n(__('D, M j / g:i a', 'zabit'), $date), $timezone ? $timezone : ''); ?></div>
            <?php endif;
            if ($place) : ?>
                <div class="event__details__place"><?php echo $place; ?></div>
            <?php endif; ?>
        </div>
	<?php endif; ?>
    <div class="event__nav">
        <a class="event__nav__link" href="<?php the_permalink(); ?>" title="<?php _e('view fight details', 'zabit'); ?>"><?php _e('view fight details', 'zabit'); ?></a>
    </div>
</div>