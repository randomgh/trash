<?php

    global $overlay;

    $athlete = get_option('zabit_bio_general_athlete', null);

    if ($athlete) {
        $athlete = pll_get_post($athlete);

        $strikes_landed = get_post_meta($athlete, 'strikes_landed', true);
        $strikes_attempted = get_post_meta($athlete, 'strikes_attempted', true);

        $grappling_landed = get_post_meta($athlete, 'grappling_landed', true);
        $grappling_attempted = get_post_meta($athlete, 'grappling_attempted', true);

        $strikes_landed_ratio = get_post_meta($athlete, 'strikes_landed_ratio', true);
        $strikes_absorbed_ratio = get_post_meta($athlete, 'strikes_absorbed_ratio', true);

        $grappling_landed_ratio = get_post_meta($athlete, 'grappling_landed_ratio', true);
        $grappling_submission_ratio = get_post_meta($athlete, 'grappling_submission_ratio', true);

        $strikes_defence = get_post_meta($athlete, 'strikes_defence', true);
        $grappling_defence = get_post_meta($athlete, 'grappling_defence', true);

        $stats_knockdown = get_post_meta($athlete, 'stats_knockdown', true);
        $stats_time = get_post_meta($athlete, 'stats_time', true);
    }

?>
<section class="section section_statistics">
    <?php
        get_aside('statistics');
        if ($overlay['right']) get_aside('right');
	?>
	<div class="content">
        <?php if ((isset($strikes_landed) && isset($strikes_attempted)) || (isset($grappling_landed) && isset($grappling_attempted))) : ?>
            <ul class="indicators">
	            <?php if (isset($strikes_landed) && isset($strikes_attempted)) : ?>
                    <li class="indicators__item">
                        <div class="indicators__item__caption">
                            <p class="indicators__item__title"><?php _e('striking accuracy', 'zabit'); ?></p>
                            <div class="indicators__item__parameter">
                                <span class="indicators__item__parameter__title"><?php _e('sig. strikes landed', 'zabit'); ?></span>
                                <span class="indicators__item__parameter__value"><?php echo $strikes_landed; ?></span>
                            </div>
                            <div class="indicators__item__parameter">
                                <span class="indicators__item__parameter__title"><?php _e('sig. strikes attempted', 'zabit'); ?></span>
                                <span class="indicators__item__parameter__value"><?php echo $strikes_attempted; ?></span>
                            </div>
                        </div>
                        <?php
                            $strikes_value = $strikes_landed / $strikes_attempted;

                            get_chart('circle', array(
                                'class' => 'indicators__item__chart',
                                'values' => array($strikes_value),
                                'label' => sprintf('%d%%', round($strikes_value * 100))
                            ));
                        ?>
                    </li>
	            <?php endif;
	            if (isset($grappling_landed) && isset($grappling_attempted)) : ?>
                    <li class="indicators__item">
                        <div class="indicators__item__caption">
                            <p class="indicators__item__title"><?php _e('grappling accuracy', 'zabit'); ?></p>
                            <div class="indicators__item__parameter">
                                <span class="indicators__item__parameter__title"><?php _e('takedowns landed', 'zabit'); ?></span>
                                <span class="indicators__item__parameter__value"><?php echo $grappling_landed; ?></span>
                            </div>
                            <div class="indicators__item__parameter">
                                <span class="indicators__item__parameter__title"><?php _e('takedowns attempted', 'zabit'); ?></span>
                                <span class="indicators__item__parameter__value"><?php echo $grappling_attempted; ?></span>
                            </div>
                        </div>
	                    <?php
                            $grappling_value = $grappling_landed / $grappling_attempted;

                            get_chart('circle', array(
                                'class' => 'indicators__item__chart',
                                'values' => array($grappling_value),
                                'label' => sprintf('%d%%', round($grappling_value * 100))
                            ));
	                    ?>
                    </li>
	            <?php endif; ?>
            </ul>
	        <?php if ((isset($strikes_landed_ratio) && isset($strikes_absorbed_ratio)) || (isset($grappling_landed_ratio) && isset($grappling_submission_ratio)) || (isset($strikes_defence) && isset($grappling_defence)) || (isset($stats_knockdown) && isset($stats_time))) : ?>
                <hr class="divider" />
	        <?php endif; ?>
        <?php endif;
        if ((isset($strikes_landed_ratio) && isset($strikes_absorbed_ratio)) || (isset($grappling_landed_ratio) && isset($grappling_submission_ratio))) : ?>
            <div class="table table_slim">
	            <?php if (isset($strikes_landed_ratio) && isset($strikes_absorbed_ratio)) : ?>
                    <div class="table__row">
                        <div class="table__cell">
                            <div class="table__indicator">
                                <span class="table__indicator__value"><?php echo $strikes_landed_ratio; ?></span>
                                <span class="table__indicator__title"><?php printf(__('sig. str.%slanded', 'zabit'), '<br>'); ?></span>
                            </div>
                        </div>
                        <div class="table__cell">
                            <div class="table__indicator">
	                            <?php
	                                $strikes_max = max($strikes_landed_ratio, $strikes_absorbed_ratio);

                                    get_chart('columns', array(
                                        'class' => 'table__indicator__chart',
                                        'values' => array($strikes_landed_ratio / $strikes_max, $strikes_absorbed_ratio / $strikes_max)
                                    ));
	                            ?>
                                <span class="table__indicator__title"><?php _e('per min', 'zabit'); ?></span>
                            </div>
                        </div>
                        <div class="table__cell">
                            <div class="table__indicator">
                                <span class="table__indicator__value"><?php echo $strikes_absorbed_ratio; ?></span>
                                <span class="table__indicator__title"><?php printf(__('sig. str.%sabsorbed', 'zabit'), '<br>'); ?></span>
                            </div>
                        </div>
                    </div>
	            <?php endif;
	            if (isset($grappling_landed_ratio) && isset($grappling_submission_ratio)) : ?>
                    <div class="table__row">
                        <div class="table__cell">
                            <div class="table__indicator">
                                <span class="table__indicator__value"><?php echo $grappling_landed_ratio; ?></span>
                                <span class="table__indicator__title"><?php printf(__('takedown%savg', 'zabit'), '<br>'); ?></span>
                            </div>
                        </div>
                        <div class="table__cell">
                            <div class="table__indicator">
	                            <?php
                                    $grappling_max = max($grappling_landed_ratio, $grappling_submission_ratio);

                                    get_chart('columns', array(
                                        'class' => 'table__indicator__chart',
                                        'values' => array($grappling_landed_ratio / $grappling_max, $grappling_submission_ratio / $grappling_max)
                                    ));
                                ?>
                                <span class="table__indicator__title"><?php _e('per 15 min', 'zabit'); ?></span>
                            </div>
                        </div>
                        <div class="table__cell">
                            <div class="table__indicator">
                                <span class="table__indicator__value"><?php echo $grappling_submission_ratio; ?></span>
                                <span class="table__indicator__title"><?php printf(__('submission%savg', 'zabit'), '<br>'); ?></span>
                            </div>
                        </div>
                    </div>
	            <?php endif; ?>
            </div>
            <?php if ((isset($strikes_defence) && isset($grappling_defence)) || (isset($stats_knockdown) && isset($stats_time))) : ?>
                <hr class="divider" />
	        <?php endif; ?>
        <?php endif;
        if ((isset($strikes_defence) && isset($grappling_defence)) || (isset($stats_knockdown) && isset($stats_time))) : ?>
            <div class="table table_slim">
	            <?php if (isset($strikes_defence) && isset($grappling_defence)) : ?>
                    <div class="table__row">
                        <div class="table__cell">
                            <div class="table__indicator">
                                <span class="table__indicator__value"><?php printf(__('%d%%', 'zabit'), $strikes_defence); ?></span>
                                <span class="table__indicator__title"><?php printf(__('sig. str.%sdefence', 'zabit'), '<br>'); ?></span>
                            </div>
                        </div>
                        <div class="table__cell">
                            <div class="table__indicator">
	                            <?php get_chart('circle', array(
		                            'class' => 'table__indicator__chart',
		                            'values' => array($strikes_defence / 100)
	                            )); ?>
                                <span class="table__indicator__title"><?php _e('per 15 min', 'zabit'); ?></span>
                            </div>
                        </div>
                        <div class="table__cell">
                            <div class="table__indicator">
                                <span class="table__indicator__value"><?php printf(__('%d%%', 'zabit'), $grappling_defence); ?></span>
                                <span class="table__indicator__title"><?php printf(__('takedown%sdefence', 'zabit'), '<br>'); ?></span>
                            </div>
                        </div>
                    </div>
	            <?php endif;
	            if (isset($stats_knockdown) && isset($stats_time)) : ?>
                    <div class="table__row">
                        <div class="table__cell">
                            <div class="table__indicator">
                                <span class="table__indicator__value"><?php echo $stats_knockdown; ?></span>
                                <span class="table__indicator__title"><?php printf(__('knockdown%sration', 'zabit'), '<br>'); ?></span>
                            </div>
                        </div>
                        <div class="table__cell"></div>
                        <div class="table__cell">
                            <div class="table__indicator">
                                <span class="table__indicator__value"><?php echo date_i18n(__('i:s', 'zabit'), $stats_time); ?></span>
                                <span class="table__indicator__title"><?php printf(__('average fight%stime', 'zabit'), '<br>'); ?></span>
                            </div>
                        </div>
                    </div>
	            <?php endif; ?>
            </div>
		<?php endif; ?>
	</div>
</section>