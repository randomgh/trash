<?php

$result = get_post_meta(get_the_ID(), 'results_result', true);
$round = get_post_meta(get_the_ID(), 'results_round', true);
$time = get_post_meta(get_the_ID(), 'results_time', true);
$method = get_post_meta(get_the_ID(), 'results_method', true);

$total_strikes1 = get_post_meta(get_the_ID(), 'opponent1_total_strikes', true);
$total_strikes_attempted1 = get_post_meta(get_the_ID(), 'opponent1_total_strikes_attempted', true);
$sig_strikes1 = get_post_meta(get_the_ID(), 'opponent1_sig_strikes', true);
$sig_strikes_attempted1 = get_post_meta(get_the_ID(), 'opponent1_sig_strikes_attempted', true);
$takedowns1 = get_post_meta(get_the_ID(), 'opponent1_takedowns', true);
$takedowns_attempted1 = get_post_meta(get_the_ID(), 'opponent1_takedowns_attempted', true);
$knockdowns1 = get_post_meta(get_the_ID(), 'opponent1_knockdowns', true);
$sub_attempted1 = get_post_meta(get_the_ID(), 'opponent1_sub_attempted', true);
$pass1 = get_post_meta(get_the_ID(), 'opponent1_pass', true);
$rev1 = get_post_meta(get_the_ID(), 'opponent1_rev', true);
$standing1 = get_post_meta(get_the_ID(), 'opponent1_standing', true);
$clinch1 = get_post_meta(get_the_ID(), 'opponent1_clinch', true);
$ground1 = get_post_meta(get_the_ID(), 'opponent1_ground', true);

$total_strikes2 = get_post_meta(get_the_ID(), 'opponent2_total_strikes', true);
$total_strikes_attempted2 = get_post_meta(get_the_ID(), 'opponent2_total_strikes_attempted', true);
$sig_strikes2 = get_post_meta(get_the_ID(), 'opponent2_sig_strikes', true);
$sig_strikes_attempted2 = get_post_meta(get_the_ID(), 'opponent2_sig_strikes_attempted', true);
$takedowns2 = get_post_meta(get_the_ID(), 'opponent2_takedowns', true);
$takedowns_attempted2 = get_post_meta(get_the_ID(), 'opponent2_takedowns_attempted', true);
$knockdowns2 = get_post_meta(get_the_ID(), 'opponent2_knockdowns', true);
$sub_attempted2 = get_post_meta(get_the_ID(), 'opponent2_sub_attempted', true);
$pass2 = get_post_meta(get_the_ID(), 'opponent2_pass', true);
$rev2 = get_post_meta(get_the_ID(), 'opponent2_rev', true);
$standing2 = get_post_meta(get_the_ID(), 'opponent2_standing', true);
$clinch2 = get_post_meta(get_the_ID(), 'opponent2_clinch', true);
$ground2 = get_post_meta(get_the_ID(), 'opponent2_ground', true);

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

if ($opponent1 != '') {
	$opponent1Title = explode(' ', get_the_title($opponent1));
	$opponent1TitleCount = count($opponent1Title);

	$opponent1_first_name = implode(' ', $opponent1TitleCount > 1 ? array_slice($opponent1Title, 0, -1) : $opponent1Title);
	$opponent1_last_name = $opponent1TitleCount > 1 ? $opponent1Title[$opponent1TitleCount - 1] : '';

	if (has_post_thumbnail($opponent1)) {
		list($src1, $width1, $height1) = wp_get_attachment_image_src(get_post_thumbnail_id($opponent1), 'opponent');
	}

	$rank1 = get_post_meta($opponent1, 'bio_rank', true);
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

	$rank2 = get_post_meta($opponent2, 'bio_rank', true);
}

$athlete = get_option('zabit_general_general_athlete', null);

?>
<div class="results results_<?php echo $result; ?>">
    <div class="heading"><?php _e('fight results', 'zabit'); ?></div>
    <div class="table table_fixed">
        <div class="table__row">
            <div class="table__cell">
                <div class="table__indicator table__indicator__inversed">
                    <span class="table__indicator__title"><?php _e('round', 'zabit'); ?></span>
                    <span class="table__indicator__title"><?php echo $round != '' ? $round : __('&mdash;', 'zabit'); ?></span>
                </div>
            </div>
            <div class="table__cell">
                <div class="table__indicator table__indicator__inversed">
                    <span class="table__indicator__title"><?php _e('time', 'zabit'); ?></span>
                    <span class="table__indicator__title"><?php echo $time != '' ? date_i18n(__('i:s', 'zabit'), $time) : __('&mdash;', 'zabit'); ?></span>
                </div>
            </div>
            <div class="table__cell">
                <div class="table__indicator table__indicator__inversed">
                    <span class="table__indicator__title"><?php _e('method', 'zabit'); ?></span>
                    <span class="table__indicator__title"><?php echo $method != '' ? $method : __('&mdash;', 'zabit'); ?></span>
                </div>
                </div>
            </div>
        </div>
    </div>
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
                            <div class="table__indicator__opponent__rank"><?php echo $rank1 ? sprintf('#%d', $rank1) : __('unranked', 'zabit'); ?></div>
                            <div class="table__indicator__opponent__status"><?php echo $result == 'loss' ? __('Winner', 'zabit') : '&nbsp;'; ?></div>
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
                            <div class="table__indicator__opponent__rank"><?php echo $rank2 ? sprintf('#%d', $rank2) : __('unranked', 'zabit'); ?></div>
                            <div class="table__indicator__opponent__status"><?php echo $result == 'win' ? __('Winner', 'zabit') : '&nbsp;'; ?></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
	<?php endif; ?>
    <div class="table table_columns_3">
	    <?php
            $total_strikes_sum1 = $total_strikes1 != '' && $total_strikes_attempted1 != '' ? $total_strikes1 + $total_strikes_attempted1 : 0;
            $total_strikes_ratio1 = $total_strikes_sum1 > 0 ? $total_strikes1 / $total_strikes_sum1 : 0;
            $total_strikes_sum2 = $total_strikes2 != '' && $total_strikes_attempted2 != '' ? $total_strikes2 + $total_strikes_attempted2 : 0;
	        $total_strikes_ratio2 = $total_strikes_sum2 > 0 ? $total_strikes2 / $total_strikes_sum2 : 0;
        ?>
        <div class="table__row">
            <div class="table__cell">
                <div class="table__indicator">
                    <span class="table__indicator__value"><?php echo $total_strikes1 != '' ? $total_strikes1 : __('&mdash;', 'zabit'); ?></span>
                    <span class="table__indicator__title"><?php $total_strikes1 != '' && $total_strikes_attempted1 != '' ? printf(__('%d%% of %d', 'zabit'), round(100 * $total_strikes_ratio1), $total_strikes_sum1) : _e('&mdash;', 'zabit'); ?></span>
                </div>
            </div>
            <div class="table__cell">
                <div class="table__indicator">
                    <?php
                    $total_strikes_max = max($total_strikes_ratio1, $total_strikes_ratio2);

                    get_chart('columns', array(
                        'class' => 'table__indicator__chart',
                        'values' => $total_strikes_max > 0 ? array($total_strikes_ratio1 / $total_strikes_max, $total_strikes_ratio2 / $total_strikes_max) : array(0, 0)
                    ));
                    ?>
                    <span class="table__indicator__title"><?php _e('total strikes', 'zabit'); ?></span>
                </div>
            </div>
            <div class="table__cell">
                <div class="table__indicator">
                    <span class="table__indicator__value"><?php echo $total_strikes2 != '' ? $total_strikes2 : __('&mdash;', 'zabit'); ?></span>
                    <span class="table__indicator__title"><?php $total_strikes2 != '' && $total_strikes_attempted2 != '' ? printf(__('%d%% of %d', 'zabit'), round(100 * $total_strikes_ratio2), $total_strikes_sum2) : _e('&mdash;', 'zabit'); ?></span>
                </div>
            </div>
        </div>
	    <?php
            $sig_strikes_sum1 = $sig_strikes1 != '' && $sig_strikes_attempted1 != '' ? $sig_strikes1 + $sig_strikes_attempted1 : 0;
            $sig_strikes_ratio1 = $sig_strikes_sum1 > 0 ? $sig_strikes1 / $sig_strikes_sum1 : 0;
	        $sig_strikes_sum2 = $sig_strikes2 != '' && $sig_strikes_attempted2 != '' ? $sig_strikes2 + $sig_strikes_attempted2 : 0;
            $sig_strikes_ratio2 = $sig_strikes_sum2 > 0 ? $sig_strikes2 / $sig_strikes_sum2 : 0;
	    ?>
        <div class="table__row">
            <div class="table__cell">
                <div class="table__indicator">
                    <span class="table__indicator__value"><?php echo $sig_strikes1 != '' ? $sig_strikes1 : __('&mdash;', 'zabit'); ?></span>
                    <span class="table__indicator__title"><?php $sig_strikes1 != '' && $sig_strikes_attempted1 != '' ? printf(__('%d%% of %d', 'zabit'), round(100 * $sig_strikes_ratio1), $sig_strikes_sum1) : _e('&mdash;', 'zabit'); ?></span>
                </div>
            </div>
            <div class="table__cell">
                <div class="table__indicator">
                    <?php
                    $sig_strikes_max = max($sig_strikes_ratio1, $sig_strikes_ratio2);

                    get_chart('columns', array(
                        'class' => 'table__indicator__chart',
                        'values' => $sig_strikes_max > 0 ? array($sig_strikes_ratio1 / $sig_strikes_max, $sig_strikes_ratio2 / $sig_strikes_max) : array(0, 0)
                    ));
                    ?>
                    <span class="table__indicator__title"><?php _e('sig. strikes', 'zabit'); ?></span>
                </div>
            </div>
            <div class="table__cell">
                <div class="table__indicator">
                    <span class="table__indicator__value"><?php echo $sig_strikes2 != '' ? $sig_strikes2 : __('&mdash;', 'zabit'); ?></span>
                    <span class="table__indicator__title"><?php $sig_strikes2 != '' && $sig_strikes_attempted2 != '' ? printf(__('%d%% of %d', 'zabit'), round(100 * $sig_strikes_ratio2), $sig_strikes_sum2) : _e('&mdash;', 'zabit'); ?></span>
                </div>
            </div>
        </div>
	    <?php
            $takedowns_sum1 = $takedowns1 != '' && $takedowns_attempted1 != '' ? $takedowns1 + $takedowns_attempted1 : 0;
            $takedowns_ratio1 = $takedowns_sum1 > 0 ? $takedowns1 / $takedowns_sum1 : 0;
            $takedowns_sum2 = $takedowns2 != '' && $takedowns_attempted2 != '' ? $takedowns2 + $takedowns_attempted2 : 0;
            $takedowns_ratio2 = $takedowns_sum2 > 0 ? $takedowns2 / $takedowns_sum2 : 0;
	    ?>
        <div class="table__row">
            <div class="table__cell">
                <div class="table__indicator">
                    <span class="table__indicator__value"><?php echo $takedowns1 != '' ? $takedowns1 : __('&mdash;', 'zabit'); ?></span>
                    <span class="table__indicator__title"><?php $takedowns1 != '' && $takedowns_attempted1 != '' ? printf(__('%d%% of %d', 'zabit'), round(100 * $takedowns_ratio1), $takedowns_sum1) : _e('&mdash;', 'zabit'); ?></span>
                </div>
            </div>
            <div class="table__cell">
                <div class="table__indicator">
                    <?php
                    $takedowns_max = max($takedowns_ratio1, $takedowns_ratio2);

                    get_chart('columns', array(
                        'class' => 'table__indicator__chart',
                        'values' => $takedowns_max > 0 ? array($takedowns_ratio1 / $takedowns_max, $takedowns_ratio2 / $takedowns_max) : array(0, 0)
                    ));
                    ?>
                    <span class="table__indicator__title"><?php _e('takedowns', 'zabit'); ?></span>
                </div>
            </div>
            <div class="table__cell">
                <div class="table__indicator">
                    <span class="table__indicator__value"><?php echo $takedowns2 != '' ? $takedowns2 : __('&mdash;', 'zabit'); ?></span>
                    <span class="table__indicator__title"><?php $takedowns2 != '' && $takedowns_attempted2 != '' ? printf(__('%d%% of %d', 'zabit'), round(100 * $takedowns_ratio2), $takedowns_sum2) : _e('&mdash;', 'zabit'); ?></span>
                </div>
            </div>
        </div>
    </div>
    <hr class="divider" />
    <div class="circles">
        <div class="circles__item <?php if ($knockdowns1 != '' && $knockdowns2 != '' && $knockdowns1 != $knockdowns2) echo $knockdowns1 > $knockdowns2 ? 'circles__item_loss' : 'circles__item_win'; ?>">
            <div class="circles__content">
                <div class="circles__title"><?php _e('knockdowns', 'zabit'); ?></div>
                <div class="circles__values"><?php printf('<span class="circles__values_first">%s</span> - <span class="circles__values_last">%s</span>', $knockdowns1 != '' ? $knockdowns1 : __('&mdash;', 'zabit'), $knockdowns2 != '' ? $knockdowns2 : __('&mdash;', 'zabit')); ?></div>
            </div>
        </div>
        <div class="circles__item <?php if ($sub_attempted1 != '' && $sub_attempted2 != '' && $sub_attempted1 != $sub_attempted2) echo $sub_attempted1 > $sub_attempted2 ? 'circles__item_loss' : 'circles__item_win'; ?>">
            <div class="circles__content">
                <div class="circles__title"><?php _e('sub. attempts', 'zabit'); ?></div>
                <div class="circles__values"><?php printf('<span class="circles__values_first">%s</span> - <span class="circles__values_last">%s</span>', $sub_attempted1 != '' ? $sub_attempted1 : __('&mdash;', 'zabit'), $sub_attempted2 != '' ? $sub_attempted2 : __('&mdash;', 'zabit')); ?></div>
            </div>
        </div>
        <div class="circles__item <?php if ($pass1 != '' && $pass2 != '' && $pass1 != $pass2) echo $pass1 > $pass2 ? 'circles__item_loss' : 'circles__item_win'; ?>">
            <div class="circles__content">
                <div class="circles__title"><?php _e('pass', 'zabit'); ?></div>
                <div class="circles__values"><?php printf('<span class="circles__values_first">%s</span> - <span class="circles__values_last">%s</span>', $pass1 != '' ? $pass1 : __('&mdash;', 'zabit'), $pass2 != '' ? $pass2 : __('&mdash;', 'zabit')); ?></div>
            </div>
        </div>
        <div class="circles__item <?php if ($rev1 != '' && $rev2 != '' && $rev1 != $rev2) echo $rev1 > $rev2 ? 'circles__item_loss' : 'circles__item_win'; ?>">
            <div class="circles__content">
                <div class="circles__title"><?php _e('rev.', 'zabit'); ?></div>
                <div class="circles__values"><?php printf('<span class="circles__values_first">%s</span> - <span class="circles__values_last">%s</span>', $rev1 != '' ? $rev1 : __('&mdash;', 'zabit'), $rev2 != '' ? $rev2 : __('&mdash;', 'zabit')); ?></div>
            </div>
        </div>
    </div>
    <hr class="divider" />
    <div class="subheading"><?php _e('sig. strikes by position', 'zabit'); ?></div>
    <div class="table table_columns_3">
        <div class="table__row">
            <div class="table__cell">
                <div class="table__indicator">
                    <span class="table__indicator__value"><?php echo $standing1 != '' ? $standing1 : __('&mdash;', 'zabit'); ?></span>
                    <span class="table__indicator__title"><?php $standing1 != '' ? printf(__('%d%%', 'zabit'), $sig_strikes1 != '' && $sig_strikes1 > 0 ? round(100 * $standing1 / $sig_strikes1) : 0) : _e('&mdash;', 'zabit'); ?></span>
                </div>
            </div>
            <div class="table__cell">
                <div class="table__indicator">
                    <?php
                    $standing_max = $standing1 != '' && $standing2 != '' ? max($standing1, $standing2) : 0;

                    get_chart('columns', array(
                        'class' => 'table__indicator__chart',
                        'values' => $standing_max > 0 ? array($standing1 / $standing_max, $standing2 / $standing_max) : array(0, 0)
                    ));
                    ?>
                    <span class="table__indicator__title"><?php _e('distance', 'zabit'); ?></span>
                </div>
            </div>
            <div class="table__cell">
                <div class="table__indicator">
                    <span class="table__indicator__value"><?php echo $standing2 != '' ? $standing2 : __('&mdash;', 'zabit'); ?></span>
                    <span class="table__indicator__title"><?php $standing2 != '' ? printf(__('%d%%', 'zabit'), $sig_strikes2 != '' && $sig_strikes2 > 0 ? round(100 * $standing2 / $sig_strikes2) : 0) : _e('&mdash;', 'zabit'); ?></span>
                </div>
            </div>
        </div>
        <div class="table__row">
            <div class="table__cell">
                <div class="table__indicator">
                    <span class="table__indicator__value"><?php echo $clinch1 != '' ? $clinch1 : __('&mdash;', 'zabit'); ?></span>
                    <span class="table__indicator__title"><?php $clinch1 != '' ? printf(__('%d%%', 'zabit'), $sig_strikes1 != '' && $sig_strikes1 > 0 ? round(100 * $clinch1 / $sig_strikes1) : 0) : _e('&mdash;', 'zabit'); ?></span>
                </div>
            </div>
            <div class="table__cell">
                <div class="table__indicator">
                    <?php
                    $clinch_max = $clinch1 != '' && $clinch2 != '' ? max($clinch1, $clinch2) : 0;

                    get_chart('columns', array(
                        'class' => 'table__indicator__chart',
                        'values' => $clinch_max > 0 ? array($clinch1 / $clinch_max, $clinch2 / $clinch_max) : array(0, 0)
                    ));
                    ?>
                    <span class="table__indicator__title"><?php _e('clinch', 'zabit'); ?></span>
                </div>
            </div>
            <div class="table__cell">
                <div class="table__indicator">
                    <span class="table__indicator__value"><?php echo $clinch2 != '' ? $clinch2 : __('&mdash;', 'zabit'); ?></span>
                    <span class="table__indicator__title"><?php $clinch2 != '' ? printf(__('%d%%', 'zabit'), $sig_strikes2 != '' && $sig_strikes2 > 0 ? round(100 * $clinch2 / $sig_strikes2) : 0) : _e('&mdash;', 'zabit'); ?></span>
                </div>
            </div>
        </div>
        <div class="table__row">
            <div class="table__cell">
                <div class="table__indicator">
                    <span class="table__indicator__value"><?php echo $ground1 != '' ? $ground1 : __('&mdash;', 'zabit'); ?></span>
                    <span class="table__indicator__title"><?php $ground1 != '' ? printf(__('%d%%', 'zabit'), $sig_strikes1 != '' && $sig_strikes1 > 0 ? round(100 * $ground1 / $sig_strikes1) : 0) : _e('&mdash;', 'zabit'); ?></span>
                </div>
            </div>
            <div class="table__cell">
                <div class="table__indicator">
                    <?php
                    $ground_max = $ground1 != '' && $ground2 != '' ? max($ground1, $ground2) : 0;

                    get_chart('columns', array(
                        'class' => 'table__indicator__chart',
                        'values' => $ground_max > 0 ? array($ground1 / $ground_max, $ground2 / $ground_max) : array(0, 0)
                    ));
                    ?>
                    <span class="table__indicator__title"><?php _e('ground', 'zabit'); ?></span>
                </div>
            </div>
            <div class="table__cell">
                <div class="table__indicator">
                    <span class="table__indicator__value"><?php echo $ground2 != '' ? $ground2 : __('&mdash;', 'zabit'); ?></span>
                    <span class="table__indicator__title"><?php $ground2 != '' ? printf(__('%d%%', 'zabit'), $sig_strikes2 != '' && $sig_strikes2 > 0 ? round(100 * $ground2 / $sig_strikes2) : 0) : _e('&mdash;', 'zabit'); ?></span>
                </div>
            </div>
        </div>
    </div>
</div>