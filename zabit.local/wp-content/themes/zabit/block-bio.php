<?php

    $athlete = get_option('zabit_bio_general_athlete', null);

    if ($athlete) {
        $athlete = pll_get_post($athlete);

        $hometown = get_post_meta($athlete, 'bio_town', true);
        $birthday = get_post_meta($athlete, 'bio_birthday', true);
        $height = get_post_meta($athlete, 'bio_height', true);
        $weight = get_post_meta($athlete, 'bio_weight', true);
	    $mma_debut = get_post_meta($athlete, 'bio_mma_debut', true);
	    $octagon_debut = get_post_meta($athlete, 'bio_octagon_debut', true);
        $hand_reach = get_post_meta($athlete, 'bio_hand_reach', true);
        $leg_reach = get_post_meta($athlete, 'bio_leg_reach', true);

        $age  = date('Y') - date('Y', $birthday);
        if (date('m') <= date('m', $birthday) && date('d') < date('d', $birthday)) $age--;
    }

    if (isset($hometown) || isset($birthday) || isset($height) || isset($weight) || isset($octagon_debut) || isset($hand_reach) || isset($leg_reach)) : ?>
        <ul class="bio">
            <?php if (isset($hometown) && $hometown != '') : ?>
                <li class="bio__indicator">
                    <span class="bio__indicator__title"><?php _e('hometown', 'zabit'); ?></span>
                    <span class="bio__indicator__value"><?php echo $hometown; ?></span>
                </li>
            <?php endif;
            if (isset($birthday) && $birthday != '') : ?>
                <li class="bio__indicator">
                    <span class="bio__indicator__title"><?php _e('age', 'zabit'); ?></span>
                    <span class="bio__indicator__value"><?php echo $age; ?></span>
                </li>
            <?php endif;
            if (isset($height) && $height != '') : ?>
                <li class="bio__indicator">
                    <span class="bio__indicator__title"><?php _e('height', 'zabit'); ?></span>
                    <span class="bio__indicator__value"><?php echo $height; ?></span>
                </li>
            <?php endif;
            if (isset($weight) && $weight != '') : ?>
                <li class="bio__indicator">
                    <span class="bio__indicator__title"><?php _e('weight', 'zabit'); ?></span>
                    <span class="bio__indicator__value"><?php echo $weight; ?></span>
                </li>
            <?php endif;
            if (isset($mma_debut) && $mma_debut != '') : ?>
                <li class="bio__indicator">
                    <span class="bio__indicator__title"><?php _e('debut in mma', 'zabit'); ?></span>
                    <span class="bio__indicator__value"><?php echo date_i18n(__('F d, Y', 'zabit'), $mma_debut); ?></span>
                </li>
            <?php endif;
            if (isset($octagon_debut) && $octagon_debut != '') : ?>
                <li class="bio__indicator">
                    <span class="bio__indicator__title"><?php _e('debut in ufc', 'zabit'); ?></span>
                    <span class="bio__indicator__value"><?php echo date_i18n(__('F d, Y', 'zabit'), $octagon_debut); ?></span>
                </li>
            <?php endif;
            if (isset($hand_reach) && $hand_reach != '') : ?>
                <li class="bio__indicator">
                    <span class="bio__indicator__title"><?php _e('arm reach', 'zabit'); ?></span>
                    <span class="bio__indicator__value"><?php echo $hand_reach; ?></span>
                </li>
            <?php endif;
            if (isset($leg_reach) && $leg_reach != '') : ?>
                <li class="bio__indicator">
                    <span class="bio__indicator__title"><?php _e('leg reach', 'zabit'); ?></span>
                    <span class="bio__indicator__value"><?php echo $leg_reach; ?></span>
                </li>
            <?php endif; ?>
        </ul>
    <?php endif;