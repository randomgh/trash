<?php

    $athlete = get_option('zabit_bio_general_athlete', null);

    if ($athlete) {
        $athlete = pll_get_post($athlete);

	    $win_knockouts = get_post_meta($athlete, 'fights_win_knockouts', true);
	    $win_submissions = get_post_meta($athlete, 'fights_win_submissions', true);
	    $win_decisions = get_post_meta($athlete, 'fights_win_decisions', true);

	    $loss_knockouts = get_post_meta($athlete, 'fights_loss_knockouts', true);
	    $loss_submissions = get_post_meta($athlete, 'fights_loss_submissions', true);
	    $loss_decisions = get_post_meta($athlete, 'fights_loss_decisions', true);

	    $draws = get_post_meta($athlete, 'fights_draws', true);
    }

?>
<ul class="stats">
    <?php if (isset($win_knockouts) && isset($win_submissions) && isset($win_decisions) && isset($loss_knockouts) && isset($loss_submissions) && isset($loss_decisions) && isset($draws)) : ?>
        <li class="stats__indicator">
            <span class="stats__indicator__value"><?php printf('%d-%d-%d', ($win_knockouts == '' ? 0 : intval($win_knockouts)) + ($win_submissions == '' ? 0 : intval($win_submissions)) + ($win_decisions == '' ? 0 : intval($win_decisions)), ($loss_knockouts == '' ? 0 : intval($loss_knockouts)) + ($loss_submissions == '' ? 0 : intval($loss_submissions)) + ($loss_decisions == '' ? 0 : intval($loss_decisions)), ($draws == '' ? 0 : intval($draws))); ?></span>
            <span class="stats__indicator__title"><?php _e('Record', 'zabit'); ?></span>
        </li>
    <?php endif; ?>
</ul>