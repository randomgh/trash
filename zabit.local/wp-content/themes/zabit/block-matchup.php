<?php

    $countries = json_decode(file_get_contents(get_template_directory().'/core/data/countries.json'), true);

    $opponent1 = get_post_meta(get_the_ID(), 'info_opponent', true);
    $opponent2 = get_option('zabit_bio_general_athlete', null);

    if ($opponent1 != '') {
        $opponent1Title = explode(' ', get_the_title($opponent1));
        $opponent1TitleCount = count($opponent1Title);

        $opponent1_first_name = implode(' ', $opponent1TitleCount > 1 ? array_slice($opponent1Title, 0, -1) : $opponent1Title);
        $opponent1_last_name = $opponent1TitleCount > 1 ? $opponent1Title[$opponent1TitleCount - 1] : '';

        if (has_post_thumbnail($opponent1)) {
            list($src1, $width1, $height1) = wp_get_attachment_image_src(get_post_thumbnail_id($opponent1), 'opponent');
        }

	    $record_streak1 = get_post_meta($opponent1, 'fights_record_streak', true);
	    $record_knockouts1 = get_post_meta($opponent1, 'fights_record_knockouts', true);
	    $record_submissions1 = get_post_meta($opponent1, 'fights_record_submissions', true);

	    $last1 = get_post_meta($opponent1, 'fights_last', true);

	    $rank1 = get_post_meta($opponent1, 'bio_rank', true);
	    $country_code1 = get_post_meta($opponent1, 'bio_country', true);
	    $height1 = get_post_meta($opponent1, 'bio_height', true);
	    $weight1 = get_post_meta($opponent1, 'bio_weight', true);
	    $hand_reach1 = get_post_meta($opponent1, 'bio_hand_reach', true);
	    $leg_reach1 = get_post_meta($opponent1, 'bio_leg_reach', true);

	    if ($country_code1) {
		    $country_found1 = array_values(array_filter($countries, function($country_object) use ($country_code1) {
			    return $country_object['code'] == $country_code1;
		    }));

		    $country1 = count($country_found1) == 1 ? $country_found1[0] : null;
	    }

	    $win_knockouts1 = get_post_meta($opponent1, 'fights_win_knockouts', true);
	    $win_submissions1 = get_post_meta($opponent1, 'fights_win_submissions', true);
	    $win_decisions1 = get_post_meta($opponent1, 'fights_win_decisions', true);

	    $loss_knockouts1 = get_post_meta($opponent1, 'fights_loss_knockouts', true);
	    $loss_submissions1 = get_post_meta($opponent1, 'fights_loss_submissions', true);
	    $loss_decisions1 = get_post_meta($opponent1, 'fights_loss_decisions', true);

	    $draws1 = get_post_meta($opponent1, 'fights_draws', true);

	    $time1 = get_post_meta($opponent1, 'stats_time', true);
	    $knockdown1 = get_post_meta($opponent1, 'stats_knockdown', true);

	    $strikes_attempted1 = get_post_meta($opponent1, 'strikes_attempted', true);
	    $strikes_landed1 = get_post_meta($opponent1, 'strikes_landed', true);
	    $strikes_landed_ratio1 = get_post_meta($opponent1, 'strikes_landed_ratio', true);
	    $strikes_absorbed_ratio1 = get_post_meta($opponent1, 'strikes_absorbed_ratio', true);
	    $strikes_defence1 = get_post_meta($opponent1, 'strikes_defence', true);

	    $grappling_landed1 = get_post_meta($opponent1, 'grappling_landed', true);
	    $grappling_attempted1 = get_post_meta($opponent1, 'grappling_attempted', true);
	    $grappling_landed_ratio1 = get_post_meta($opponent1, 'grappling_landed_ratio', true);
	    $grappling_submission_ratio1 = get_post_meta($opponent1, 'grappling_submission_ratio', true);
	    $grappling_defence1 = get_post_meta($opponent1, 'grappling_defence', true);
    }

    if ($opponent2 != '') {
        $opponent2 = pll_get_post($opponent2);

        $opponent2Title = explode(' ', get_the_title($opponent2));
        $opponent2TitleCount = count($opponent2Title);

        $opponent2_first_name = implode(' ', $opponent2TitleCount > 1 ? array_slice($opponent2Title, 0, -1) : $opponent2Title);
        $opponent2_last_name = $opponent2TitleCount > 1 ? $opponent2Title[$opponent2TitleCount - 1] : '';

        if (has_post_thumbnail($opponent2)) {
            list($src2, $width2, $height2) = wp_get_attachment_image_src(get_post_thumbnail_id($opponent2), 'opponent');
        }

	    $record_streak2 = get_post_meta($opponent2, 'fights_record_streak', true);
	    $record_knockouts2 = get_post_meta($opponent2, 'fights_record_knockouts', true);
	    $record_submissions2 = get_post_meta($opponent2, 'fights_record_submissions', true);

	    $last2 = get_post_meta($opponent2, 'fights_last', true);

	    $rank2 = get_post_meta($opponent2, 'bio_rank', true);
	    $country_code2 = get_post_meta($opponent2, 'bio_country', true);
	    $height2 = get_post_meta($opponent2, 'bio_height', true);
	    $weight2 = get_post_meta($opponent2, 'bio_weight', true);
	    $hand_reach2 = get_post_meta($opponent2, 'bio_hand_reach', true);
	    $leg_reach2 = get_post_meta($opponent2, 'bio_leg_reach', true);

	    if ($country_code2) {
		    $country_found2 = array_values(array_filter($countries, function($country_object) use ($country_code2) {
			    return $country_object['code'] == $country_code2;
		    }));

		    $country2 = count($country_found2) == 1 ? $country_found2[0] : null;
	    }

	    $win_knockouts2 = get_post_meta($opponent2, 'fights_win_knockouts', true);
	    $win_submissions2 = get_post_meta($opponent2, 'fights_win_submissions', true);
	    $win_decisions2 = get_post_meta($opponent2, 'fights_win_decisions', true);

	    $loss_knockouts2 = get_post_meta($opponent2, 'fights_loss_knockouts', true);
	    $loss_submissions2 = get_post_meta($opponent2, 'fights_loss_submissions', true);
	    $loss_decisions2 = get_post_meta($opponent2, 'fights_loss_decisions', true);

	    $draws2 = get_post_meta($opponent2, 'fights_draws', true);

	    $time2 = get_post_meta($opponent2, 'stats_time', true);
	    $knockdown2 = get_post_meta($opponent2, 'stats_knockdown', true);

	    $strikes_attempted2 = get_post_meta($opponent2, 'strikes_attempted', true);
	    $strikes_landed2 = get_post_meta($opponent2, 'strikes_landed', true);
	    $strikes_landed_ratio2 = get_post_meta($opponent2, 'strikes_landed_ratio', true);
	    $strikes_absorbed_ratio2 = get_post_meta($opponent2, 'strikes_absorbed_ratio', true);
	    $strikes_defence2 = get_post_meta($opponent2, 'strikes_defence', true);

	    $grappling_landed2 = get_post_meta($opponent2, 'grappling_landed', true);
	    $grappling_attempted2 = get_post_meta($opponent2, 'grappling_attempted', true);
	    $grappling_landed_ratio2 = get_post_meta($opponent2, 'grappling_landed_ratio', true);
	    $grappling_submission_ratio2 = get_post_meta($opponent2, 'grappling_submission_ratio', true);
	    $grappling_defence2 = get_post_meta($opponent2, 'grappling_defence', true);
    }

    $athlete = get_option('zabit_general_general_athlete', null);

?>
<div class="matchup">
    <div class="heading"><?php _e('matchup stats', 'zabit'); ?></div>
    <?php if ($opponent1 != '' && $opponent2 != '') : ?>
        <div class="table table_columns_3">
            <div class="table__row">
                <div class="table__cell">
                    <div class="table__indicator">
                        <div class="table__indicator__opponent">
                            <div class="table__indicator__opponent__image">
                                <?php if (isset($src1)) : ?>
                                    <img src="<?php echo $src1; ?>" title="<?php echo get_the_title($opponent1); ?>" alt="<?php echo get_the_title($opponent1); ?>">
                                <?php elseif ($athlete != '') :
                                    echo new SVG($athlete);
                                endif; ?>
                            </div>
                            <?php if (isset($opponent1TitleCount) && $opponent1TitleCount) : ?>
                                <div class="table__indicator__opponent__name"><?php echo implode('<br>', array_filter(array($opponent1_first_name, $opponent1_last_name))); ?></div>
                            <?php endif; ?>
                            <div class="table__indicator__opponent__rank"><?php echo $rank1 != '' ? sprintf('#%d', $rank1) : __('unranked', 'zabit'); ?></div>
                        </div>
                    </div>
                </div>
                <div class="table__cell"></div>
                <div class="table__cell">
                    <div class="table__indicator">
                        <div class="table__indicator__opponent">
                            <div class="table__indicator__opponent__image">
                                <?php if (isset($src2)) : ?>
                                    <img src="<?php echo $src2; ?>" title="<?php echo get_the_title($opponent2); ?>" alt="<?php echo get_the_title($opponent2); ?>">
                                <?php elseif ($athlete != '') :
                                    echo new SVG($athlete);
                                endif; ?>
                            </div>
                            <?php if (isset($opponent2TitleCount) && $opponent2TitleCount) : ?>
                                <div class="table__indicator__opponent__name"><?php echo implode('<br>', array_filter(array($opponent2_first_name, $opponent2_last_name))); ?></div>
                            <?php endif; ?>
                            <div class="table__indicator__opponent__rank"><?php echo $rank2 != '' ? sprintf('#%d', $rank2) : __('unranked', 'zabit'); ?></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="table table_columns_3">
            <div class="table__row">
                <div class="table__cell">
                    <div class="table__indicator">
                        <span class="table__indicator__value table__indicator__value_small"><?php $win_knockouts1 != '' || $win_submissions1 != '' || $win_decisions1 != '' || $loss_knockouts1 != '' || $loss_submissions1 != '' || $loss_submissions1 != '' || $draws1 != '' ? printf('%d-%d-%d', ($win_knockouts1 == '' ? 0 : intval($win_knockouts1)) + ($win_submissions1 == '' ? 0 : intval($win_submissions1)) + ($win_decisions1 == '' ? 0 : intval($win_decisions1)), ($loss_knockouts1 == '' ? 0 : intval($loss_knockouts1)) + ($loss_submissions1 == '' ? 0 : intval($loss_submissions1)) + ($loss_decisions1 == '' ? 0 : intval($loss_decisions1)), ($draws1 == '' ? 0 : intval($draws1))) : _e('&mdash;', 'zabit'); ?></span>
                    </div>
                </div>
                <div class="table__cell">
                    <div class="table__indicator">
                        <span class="table__indicator__title"><?php _e('record', 'zabit'); ?></span>
                    </div>
                </div>
                <div class="table__cell">
                    <div class="table__indicator">
                        <span class="table__indicator__value table__indicator__value_small"><?php $win_knockouts2 != '' || $win_submissions2 != '' || $win_decisions2 != '' || $loss_knockouts2 != '' || $loss_submissions2 != '' || $loss_submissions2 != '' || $draws2 != '' ? printf('%d-%d-%d', ($win_knockouts2 == '' ? 0 : intval($win_knockouts2)) + ($win_submissions2 == '' ? 0 : intval($win_submissions2)) + ($win_decisions2 == '' ? 0 : intval($win_decisions2)), ($loss_knockouts2 == '' ? 0 : intval($loss_knockouts2)) + ($loss_submissions2 == '' ? 0 : intval($loss_submissions2)) + ($loss_decisions2 == '' ? 0 : intval($loss_decisions2)), ($draws2 == '' ? 0 : intval($draws2))) : _e('&mdash;', 'zabit'); ?></span>
                    </div>
                </div>
            </div>
            <div class="table__row">
                <div class="table__cell">
                    <div class="table__indicator">
                        <span class="table__indicator__value table__indicator__value_small"><?php echo $last1 != '' ? $last1 : __('&mdash;', 'zabit'); ?></span>
                    </div>
                </div>
                <div class="table__cell">
                    <div class="table__indicator">
                        <span class="table__indicator__title"><?php _e('last fight', 'zabit'); ?></span>
                    </div>
                </div>
                <div class="table__cell">
                    <div class="table__indicator">
                        <span class="table__indicator__value table__indicator__value_small"><?php echo $last2 != '' ? $last2 : __('&mdash;', 'zabit'); ?></span>
                    </div>
                </div>
            </div>
            <div class="table__row">
                <div class="table__cell">
                    <div class="table__indicator">
                        <span class="table__indicator__value table__indicator__value_small"><?php echo isset($country1) ? $country1['name'] : __('&mdash;', 'zabit'); ?></span>
                    </div>
                </div>
                <div class="table__cell">
                    <div class="table__indicator">
                        <span class="table__indicator__title"><?php _e('country', 'zabit'); ?></span>
                    </div>
                </div>
                <div class="table__cell">
                    <div class="table__indicator">
                        <span class="table__indicator__value table__indicator__value_small"><?php echo isset($country2) ? $country2['name'] : __('&mdash;', 'zabit'); ?></span>
                    </div>
                </div>
            </div>
            <div class="table__row">
                <div class="table__cell">
                    <div class="table__indicator">
                        <span class="table__indicator__value table__indicator__value_small"><?php echo $height1 != '' ? $height1 : __('&mdash;', 'zabit'); ?></span>
                    </div>
                </div>
                <div class="table__cell">
                    <div class="table__indicator">
                        <span class="table__indicator__title"><?php _e('height (inch)', 'zabit'); ?></span>
                    </div>
                </div>
                <div class="table__cell">
                    <div class="table__indicator">
                        <span class="table__indicator__value table__indicator__value_small"><?php echo $height2 != '' ? $height2 : __('&mdash;', 'zabit'); ?></span>
                    </div>
                </div>
            </div>
            <div class="table__row">
                <div class="table__cell">
                    <div class="table__indicator">
                        <span class="table__indicator__value table__indicator__value_small"><?php echo $weight1 != '' ? $weight1 : __('&mdash;', 'zabit'); ?></span>
                    </div>
                </div>
                <div class="table__cell">
                    <div class="table__indicator">
                        <span class="table__indicator__title"><?php _e('weight (lb)', 'zabit'); ?></span>
                    </div>
                </div>
                <div class="table__cell">
                    <div class="table__indicator">
                        <span class="table__indicator__value table__indicator__value_small"><?php echo $weight2 != '' ? $weight2 : __('&mdash;', 'zabit'); ?></span>
                    </div>
                </div>
            </div>
            <div class="table__row">
                <div class="table__cell">
                    <div class="table__indicator">
                        <span class="table__indicator__value table__indicator__value_small"><?php echo $hand_reach1 != '' ? $hand_reach1 : __('&mdash;', 'zabit'); ?></span>
                    </div>
                </div>
                <div class="table__cell">
                    <div class="table__indicator">
                        <span class="table__indicator__title"><?php _e('reach (inch)', 'zabit'); ?></span>
                    </div>
                </div>
                <div class="table__cell">
                    <div class="table__indicator">
                        <span class="table__indicator__value table__indicator__value_small"><?php echo $hand_reach2 != '' ? $hand_reach2 : __('&mdash;', 'zabit'); ?></span>
                    </div>
                </div>
            </div>
            <div class="table__row">
                <div class="table__cell">
                    <div class="table__indicator">
                        <span class="table__indicator__value table__indicator__value_small"><?php echo $leg_reach1 != '' ? $leg_reach1 : __('&mdash;', 'zabit'); ?></span>
                    </div>
                </div>
                <div class="table__cell">
                    <div class="table__indicator">
                        <span class="table__indicator__title"><?php _e('leg reach (inch)', 'zabit'); ?></span>
                    </div>
                </div>
                <div class="table__cell">
                    <div class="table__indicator">
                        <span class="table__indicator__value table__indicator__value_small"><?php echo $leg_reach2 != '' ? $leg_reach2 : __('&mdash;', 'zabit'); ?></span>
                    </div>
                </div>
            </div>
        </div>
    <?php endif; ?>
    <hr class="divider" />
    <div class="subheading"><?php _e('win by', 'zabit'); ?></div>
    <?php if (isset($win_knockouts1) && isset($win_submissions1) && isset($win_decisions1) && isset($win_knockouts2) && isset($win_submissions2) && isset($win_decisions2)) :
        $win1 = ($win_knockouts1 != '' ? $win_knockouts1 : 0) + ($win_submissions1 != '' ? $win_submissions1 : 0) + ($win_decisions1 != '' ? $win_decisions1 : 0);
        list($win_knockouts_ratio1, $win_submissions_ratio1, $win_decisions_ratio1) = $win1 > 0 ? array($win_knockouts1 / $win1, $win_submissions1 / $win1, $win_decisions1 / $win1) : array(0, 0, 0);

	    $win2 = ($win_knockouts2 != '' ? $win_knockouts2 : 0) + ($win_submissions2 != '' ? $win_submissions2 : 0) + ($win_decisions2 != '' ? $win_decisions2 : 0);
	    list($win_knockouts_ratio2, $win_submissions_ratio2, $win_decisions_ratio2) = $win2 > 0 ? array($win_knockouts2 / $win2, $win_submissions2 / $win2, $win_decisions2 / $win2) : array(0, 0, 0); ?>
        <div class="table table_columns_5">
            <div class="table__row">
                <div class="table__cell">
	                <?php get_chart('progress', array(
		                'class' => 'table__indicator__chart chart_flip',
		                'value' => $win_knockouts_ratio1
	                )); ?>
                </div>
                <div class="table__cell">
                    <div class="table__indicator">
                        <span class="table__indicator__value table__indicator__value_small"><?php $win_knockouts1 != '' && $win_submissions1 != '' && $win_decisions1 != '' ? printf(__('%d%%', 'zabit'), round(100 * $win_knockouts_ratio1)) : _e('&mdash;', 'zabit'); ?></span>
                    </div>
                </div>
                <div class="table__cell">
                    <div class="table__indicator">
                        <span class="table__indicator__title"><?php _e('ko/tko', 'zabit'); ?></span>
                    </div>
                </div>
                <div class="table__cell">
                    <div class="table__indicator">
                        <span class="table__indicator__value table__indicator__value_small"><?php $win_knockouts2 != '' && $win_submissions2 != '' && $win_decisions2 != '' ? printf(__('%d%%', 'zabit'), round(100 * $win_knockouts_ratio2)) : _e('&mdash;', 'zabit'); ?></span>
                    </div>
                </div>
                <div class="table__cell">
	                <?php get_chart('progress', array(
		                'class' => 'table__indicator__chart',
		                'value' => $win_knockouts_ratio2
	                )); ?>
                </div>
            </div>
            <div class="table__row">
                <div class="table__cell">
	                <?php get_chart('progress', array(
		                'class' => 'table__indicator__chart chart_flip',
		                'value' => $win_submissions_ratio1
	                )); ?>
                </div>
                <div class="table__cell">
                    <div class="table__indicator">
                        <span class="table__indicator__value table__indicator__value_small"><?php $win_knockouts1 != '' && $win_submissions1 != '' && $win_decisions1 != '' ? printf(__('%d%%', 'zabit'), round(100 * $win_submissions_ratio1)) : _e('&mdash;', 'zabit'); ?></span>
                    </div>
                </div>
                <div class="table__cell">
                    <div class="table__indicator">
                        <span class="table__indicator__title"><?php _e('sub', 'zabit'); ?></span>
                    </div>
                </div>
                <div class="table__cell">
                    <div class="table__indicator">
                        <span class="table__indicator__value table__indicator__value_small"><?php $win_knockouts2 != '' && $win_submissions2 != '' && $win_decisions2 != '' ? printf(__('%d%%', 'zabit'), round(100 * $win_submissions_ratio2)) : _e('&mdash;', 'zabit'); ?></span>
                    </div>
                </div>
                <div class="table__cell">
	                <?php get_chart('progress', array(
		                'class' => 'table__indicator__chart',
		                'value' => $win_submissions_ratio2
	                )); ?>
                </div>
            </div>
            <div class="table__row">
                <div class="table__cell">
	                <?php get_chart('progress', array(
		                'class' => 'table__indicator__chart chart_flip',
		                'value' => $win_decisions_ratio1
	                )); ?>
                </div>
                <div class="table__cell">
                    <div class="table__indicator">
                        <span class="table__indicator__value table__indicator__value_small"><?php $win_knockouts1 != '' && $win_submissions1 != '' && $win_decisions1 != '' ? printf(__('%d%%', 'zabit'), round(100 * $win_decisions_ratio1)) : _e('&mdash;', 'zabit'); ?></span>
                    </div>
                </div>
                <div class="table__cell">
                    <div class="table__indicator">
                        <span class="table__indicator__title"><?php _e('dec', 'zabit'); ?></span>
                    </div>
                </div>
                <div class="table__cell">
                    <div class="table__indicator">
                        <span class="table__indicator__value table__indicator__value_small"><?php $win_knockouts2 != '' && $win_submissions2 != '' && $win_decisions2 != '' ? printf(__('%d%%', 'zabit'), round(100 * $win_decisions_ratio2)) : _e('&mdash;', 'zabit'); ?></span>
                    </div>
                </div>
                <div class="table__cell">
	                <?php get_chart('progress', array(
		                'class' => 'table__indicator__chart',
		                'value' => $win_decisions_ratio2
	                )); ?>
                </div>
            </div>
        </div>
    <?php endif; ?>
    <div class="table table_columns_5">
        <?php if (isset($time1) && isset($time2)) : ?>
        <div class="table__row">
            <div class="table__cell"></div>
            <div class="table__cell">
                <div class="table__indicator">
                    <span class="table__indicator__value table__indicator__value_small"><?php echo $time1 != '' ? date_i18n(__('i:s', 'zabit'), $time1) : __('&mdash;', 'zabit'); ?></span>
                </div>
            </div>
            <div class="table__cell">
                <div class="table__indicator">
                    <span class="table__indicator__title"><?php _e('avg fight time', 'zabit'); ?></span>
                </div>
            </div>
            <div class="table__cell">
                <div class="table__indicator">
                    <span class="table__indicator__value table__indicator__value_small"><?php echo $time2 != '' ? date_i18n(__('i:s', 'zabit'), $time2) : __('&mdash;', 'zabit'); ?></span>
                </div>
            </div>
            <div class="table__cell"></div>
        </div>
        <?php endif;
        if (isset($knockdown1) && isset($knockdown2)) : ?>
        <div class="table__row">
            <div class="table__cell"></div>
            <div class="table__cell">
                <div class="table__indicator">
                    <span class="table__indicator__value table__indicator__value_small"><?php echo $knockdown1 != '' ? $knockdown1 : __('&mdash;', 'zabit'); ?></span>
                </div>
            </div>
            <div class="table__cell">
                <div class="table__indicator">
                    <span class="table__indicator__title"><?php _e('knockdown avg', 'zabit'); ?></span>
                    <span class="table__indicator__title"><?php _e('per 15 min', 'zabit'); ?></span>
                </div>
            </div>
            <div class="table__cell">
                <div class="table__indicator">
                    <span class="table__indicator__value table__indicator__value_small"><?php echo $knockdown2 != '' ? $knockdown2 : __('&mdash;', 'zabit'); ?></span>
                </div>
            </div>
            <div class="table__cell"></div>
        </div>
        <?php endif; ?>
    </div>
    <hr class="divider" />
    <div class="subheading"><?php _e('significant strikes', 'zabit'); ?></div>
    <div class="table table_columns_3">
        <?php if (isset($strikes_landed_ratio1) && isset($strikes_landed_ratio2)) : ?>
            <div class="table__row">
                <div class="table__cell">
                    <div class="table__indicator">
                        <span class="table__indicator__value"><?php echo $strikes_landed_ratio1 != '' ? $strikes_landed_ratio1 : __('&mdash;', 'zabit'); ?></span>
                    </div>
                </div>
                <div class="table__cell">
                    <div class="table__indicator">
                        <?php
                        $strikes_landed_ratio_max = $strikes_landed_ratio1 != '' && $strikes_landed_ratio2 != '' ? max($strikes_landed_ratio1, $strikes_landed_ratio2) : 0;

                        get_chart('columns', array(
                            'class' => 'table__indicator__chart',
                            'values' => $strikes_landed_ratio_max > 0 ? array($strikes_landed_ratio1 / $strikes_landed_ratio_max, $strikes_landed_ratio2 / $strikes_landed_ratio_max) : array(0, 0)
                        ));
                        ?>
                        <span class="table__indicator__title"><?php _e('landed per min', 'zabit'); ?></span>
                    </div>
                </div>
                <div class="table__cell">
                    <div class="table__indicator">
                        <span class="table__indicator__value"><?php echo $strikes_landed_ratio2 != '' ? $strikes_landed_ratio2 : __('&mdash;', 'zabit'); ?></span>
                    </div>
                </div>
            </div>
        <?php endif;
        if (isset($strikes_landed1) && isset($strikes_attempted1) && isset($strikes_landed2) && isset($strikes_attempted2)) :
            $strikes_accuracy1 = $strikes_landed1 != '' && $strikes_attempted1 != '' && $strikes_attempted1 > 0 ? $strikes_landed1 / $strikes_attempted1 : 0;
            $strikes_accuracy2 = $strikes_landed2 != '' && $strikes_attempted2 != '' && $strikes_attempted2 > 0 ? $strikes_landed2 / $strikes_attempted2 : 0;
            ?>
            <div class="table__row">
                <div class="table__cell">
                    <div class="table__indicator">
                        <span class="table__indicator__value"><?php $strikes_landed1 != '' && $strikes_attempted1 != '' ? printf('%d%%', round($strikes_accuracy1 * 100)) : _e('&mdash;', 'zabit'); ?></span>
                    </div>
                </div>
                <div class="table__cell">
                    <div class="table__indicator">
                        <?php
                        $strikes_accuracy1_ratio = $strikes_accuracy1 > 0 || $strikes_accuracy2 > 0 ? min($strikes_accuracy1, $strikes_accuracy2) / max($strikes_accuracy1, $strikes_accuracy2) * 0.5 : 0;

                        get_chart('circle', array(
                            'class' => 'table__indicator__chart',
                            'values' => $strikes_accuracy1 > 0 || $strikes_accuracy2 > 0 ? $strikes_accuracy1 > $strikes_accuracy2 ? array($strikes_accuracy1_ratio, 1 - $strikes_accuracy1_ratio) : array(1 - $strikes_accuracy1_ratio, $strikes_accuracy1_ratio) : array(0, 0)
                        ));
                        ?>
                        <span class="table__indicator__title"><?php _e('significant strikes accuracy', 'zabit'); ?></span>
                    </div>
                </div>
                <div class="table__cell">
                    <div class="table__indicator">
                        <span class="table__indicator__value"><?php $strikes_landed2 != '' && $strikes_attempted2 != '' ? printf('%d%%', round($strikes_accuracy2 * 100)) : _e('&mdash;', 'zabit'); ?></span>
                    </div>
                </div>
            </div>
        <?php endif;
        if (isset($strikes_absorbed_ratio1) && isset($strikes_absorbed_ratio2)) : ?>
            <div class="table__row">
                <div class="table__cell">
                    <div class="table__indicator">
                        <span class="table__indicator__value"><?php echo $strikes_absorbed_ratio1 != '' ? $strikes_absorbed_ratio1 : __('&mdash;', 'zabit'); ?></span>
                    </div>
                </div>
                <div class="table__cell">
                    <div class="table__indicator">
                        <?php
                        $strikes_absorbed_ratio_max = $strikes_absorbed_ratio1 != '' && $strikes_absorbed_ratio2 != '' ? max($strikes_absorbed_ratio1, $strikes_absorbed_ratio2) : 0;

                        get_chart('columns', array(
                            'class' => 'table__indicator__chart',
                            'values' => $strikes_absorbed_ratio_max > 0 ? array($strikes_absorbed_ratio1 / $strikes_absorbed_ratio_max, $strikes_absorbed_ratio2 / $strikes_absorbed_ratio_max) : array(0, 0)
                        ));
                        ?>
                        <span class="table__indicator__title"><?php _e('absobrbed per min', 'zabit'); ?></span>
                    </div>
                </div>
                <div class="table__cell">
                    <div class="table__indicator">
                        <span class="table__indicator__value"><?php echo $strikes_absorbed_ratio2 != '' ? $strikes_absorbed_ratio2 : __('&mdash;', 'zabit'); ?></span>
                    </div>
                </div>
            </div>
        <?php endif;
        if (isset($strikes_defence1) && isset($strikes_defence2)) : ?>
        <div class="table__row">
            <div class="table__cell">
                <div class="table__indicator">
                    <span class="table__indicator__value"><?php $strikes_defence1 != '' ? printf('%d%%', $strikes_defence1) : _e('&mdash;', 'zabit'); ?></span>
                </div>
            </div>
            <div class="table__cell">
                <div class="table__indicator">
                    <?php
                    $strikes_defence_ratio = $strikes_defence1 != '' && $strikes_defence2 != '' && ($strikes_defence1 > 0 || $strikes_defence2 > 0) ? min($strikes_defence1, $strikes_defence2) / max($strikes_defence1, $strikes_defence2) * 0.5 : 0;

                    get_chart('circle', array(
                        'class' => 'table__indicator__chart',
                        'values' =>  $strikes_defence1 != '' && $strikes_defence2 != '' ? $strikes_defence1 > $strikes_defence2 ? array($strikes_defence_ratio, 1 - $strikes_defence_ratio) : array(1 - $strikes_defence_ratio, $strikes_defence_ratio) : array(0, 0)
                    ));
                    ?>
                    <span class="table__indicator__title"><?php _e('defence', 'zabit'); ?></span>
                </div>
            </div>
            <div class="table__cell">
                <div class="table__indicator">
                    <span class="table__indicator__value"><?php $strikes_defence2 != '' ? printf('%d%%', $strikes_defence2) : _e('&mdash;', 'zabit'); ?></span>
                </div>
            </div>
        </div>
        <?php endif; ?>
    </div>
    <hr class="divider" />
    <div class="subheading"><?php _e('grappling', 'zabit'); ?></div>
    <div class="table table_columns_3">
        <?php if (isset($grappling_landed_ratio1) && isset($grappling_landed_ratio2)) : ?>
            <div class="table__row">
                <div class="table__cell">
                    <div class="table__indicator">
                        <span class="table__indicator__value"><?php echo $grappling_landed_ratio1 != '' ? $grappling_landed_ratio1 : __('&mdash;', 'zabit'); ?></span>
                    </div>
                </div>
                <div class="table__cell">
                    <div class="table__indicator">
                        <?php
                        $grappling_landed_ratio_max = $grappling_landed_ratio1 != '' && $grappling_landed_ratio2 != '' ? max($grappling_landed_ratio1, $grappling_landed_ratio2) : 0;

                        get_chart('columns', array(
                            'class' => 'table__indicator__chart',
                            'values' => $grappling_landed_ratio_max > 0 ? array($grappling_landed_ratio1 / $grappling_landed_ratio_max, $grappling_landed_ratio2 / $grappling_landed_ratio_max) : array(0, 0)
                        ));
                        ?>
                        <span class="table__indicator__title"><?php _e('takedown avg (per 15 min)', 'zabit'); ?></span>
                    </div>
                </div>
                <div class="table__cell">
                    <div class="table__indicator">
                        <span class="table__indicator__value"><?php echo $grappling_landed_ratio2 != '' ? $grappling_landed_ratio2 : __('&mdash;', 'zabit'); ?></span>
                    </div>
                </div>
            </div>
        <?php endif;
        if (isset($grappling_landed1) && isset($grappling_attempted1) && isset($grappling_landed2) && isset($grappling_attempted2)) :
            $grappling_accuracy1 = $grappling_landed1 != '' && $grappling_attempted1 != '' && $grappling_attempted1 > 0 ? $grappling_landed1 / $grappling_attempted1 : 0;
            $grappling_accuracy2 = $grappling_landed2 != '' && $grappling_attempted2 != '' && $grappling_attempted2 > 0 ? $grappling_landed2 / $grappling_attempted2 : 0;
            ?>
            <div class="table__row">
                <div class="table__cell">
                    <div class="table__indicator">
                        <span class="table__indicator__value"><?php $grappling_landed1 != '' && $grappling_attempted1 != '' ? printf('%d%%', round($grappling_accuracy1 * 100)) : _e('&mdash;', 'zabit'); ?></span>
                    </div>
                </div>
                <div class="table__cell">
                    <div class="table__indicator">
                        <?php
                            $grappling_accuracy_ratio = $grappling_accuracy1 > 0 || $grappling_accuracy2 > 0 ? min($grappling_accuracy1, $grappling_accuracy2) / max($grappling_accuracy1, $grappling_accuracy2) * 0.5 : 0;

                            get_chart('circle', array(
                                'class' => 'table__indicator__chart',
                                'values' => $grappling_accuracy1 > 0 || $grappling_accuracy2 > 0 ? $grappling_accuracy1 > $grappling_accuracy2 ? array($grappling_accuracy_ratio, 1 - $grappling_accuracy_ratio) : array(1 - $grappling_accuracy_ratio, $grappling_accuracy_ratio) : array(0, 0)
                            ));
                        ?>
                        <span class="table__indicator__title"><?php _e('takedown accuracy', 'zabit'); ?></span>
                    </div>
                </div>
                <div class="table__cell">
                    <div class="table__indicator">
                        <span class="table__indicator__value"><?php $grappling_landed2 != '' && $grappling_attempted2 != '' ? printf('%d%%', round($grappling_accuracy2 * 100)) : _e('&mdash;', 'zabit'); ?></span>
                    </div>
                </div>
            </div>
        <?php endif;
        if (isset($grappling_defence1) && isset($grappling_defence2)) : ?>
            <div class="table__row">
                <div class="table__cell">
                    <div class="table__indicator">
                        <span class="table__indicator__value"><?php $grappling_defence1 != '' ? printf('%d%%', $grappling_defence1) : _e('&mdash;', 'zabit'); ?></span>
                    </div>
                </div>
                <div class="table__cell">
                    <div class="table__indicator">
                        <?php
                            $grappling_defence_ratio = $grappling_defence1 != '' && $grappling_defence2 != '' && ($grappling_defence1 > 0 || $grappling_defence2 > 0) ? min($grappling_defence1, $grappling_defence2) / max($grappling_defence1, $grappling_defence2) * 0.5 : 0;

                            get_chart('circle', array(
                                'class' => 'table__indicator__chart',
                                'values' => $grappling_defence1 != '' && $grappling_defence2 != '' ? $grappling_defence1 > $grappling_defence2 ? array($grappling_defence_ratio, 1 - $grappling_defence_ratio) : array(1 - $grappling_defence_ratio, $grappling_defence_ratio) : array(0, 0)
                            ));
                        ?>
                        <span class="table__indicator__title"><?php _e('takedown defence', 'zabit'); ?></span>
                    </div>
                </div>
                <div class="table__cell">
                    <div class="table__indicator">
                        <span class="table__indicator__value"><?php $grappling_defence2 != '' ? printf('%d%%', $grappling_defence2) : _e('&mdash;', 'zabit'); ?></span>
                    </div>
                </div>
            </div>
        <?php endif;
        if (isset($grappling_submission_ratio1) && isset($grappling_submission_ratio2)) : ?>
            <div class="table__row">
                <div class="table__cell">
                    <div class="table__indicator">
                        <span class="table__indicator__value"><?php echo $grappling_submission_ratio1 != '' ? $grappling_submission_ratio1 : __('&mdash;', 'zabit'); ?></span>
                    </div>
                </div>
                <div class="table__cell">
                    <div class="table__indicator">
                        <?php
                        $grappling_submission_ratio_max = $grappling_submission_ratio1 != '' && $grappling_submission_ratio2 != '' ? max($grappling_submission_ratio1, $grappling_submission_ratio2) : 0;

                        get_chart('columns', array(
                            'class' => 'table__indicator__chart',
                            'values' => $grappling_submission_ratio_max > 0 ? array($grappling_submission_ratio1 / $grappling_submission_ratio_max, $grappling_submission_ratio2 / $grappling_submission_ratio_max) : array(0, 0)
                        ));
                        ?>
                        <span class="table__indicator__title"><?php _e('submission avg (per 15 min)', 'zabit'); ?></span>
                    </div>
                </div>
                <div class="table__cell">
                    <div class="table__indicator">
                        <span class="table__indicator__value"><?php echo $grappling_submission_ratio2 != '' ? $grappling_submission_ratio2 : __('&mdash;', 'zabit'); ?></span>
                    </div>
                </div>
            </div>
        <?php endif; ?>
    </div>
</div>