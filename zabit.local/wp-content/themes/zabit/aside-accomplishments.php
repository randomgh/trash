<?php

    $athlete = get_option('zabit_bio_general_athlete', null);

    if ($athlete) {
        $athlete = pll_get_post($athlete);

        $division_slug = get_post_meta($athlete, 'bio_division', true);
        $division_rank = get_post_meta($athlete, 'bio_division_rank', true);

        $divisions = json_decode(file_get_contents(get_template_directory().'/core/data/divisions.json'), true);

        if ($division_slug) {
            $division_found = array_values(array_filter($divisions, function($division_object) use ($division_slug) {
                return $division_object['slug'] == $division_slug;
            }));

            $division = count($division_found) == 1 ? $division_found[0] : null;
        }
    }

?>
<aside class="aside aside_left aside_full aside_accomplishments">
    <?php get_title(__('accomplishments', 'zabit'));

    if (isset($division_rank) && isset($division)) : ?>
        <ul class="stats">
            <li class="stats__indicator">
                <span class="stats__indicator__value"><?php printf(__('#%d', 'zabit'), $division_rank); ?></span>
                <span class="stats__indicator__title"><?php printf(__('ufc %s', 'zabit'), $division['name']); ?></span>
            </li>
        </ul>
    <?php endif; ?>
</aside>