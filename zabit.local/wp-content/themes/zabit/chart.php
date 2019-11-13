<?php

    function get_chart($type, $parameters, $echo = true) {
        ob_start();

        $class = implode(' ', array_filter(array('chart', 'chart_hidden', 'chart_'.$type, isset($parameters['class']) ? $parameters['class'] : null)));

        switch ($type) :
            case 'progress':
                $dasharray = 256;
                $value = isset($parameters['value']) ? $parameters['value'] : 0; ?>
                <svg class="<?php echo $class; ?>" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 268 24" xml:space="preserve">
                    <path class="chart__background" d="M256,24H0c-6.6,0-12-5.4-12-12C-12,5.4-6.6,0,0,0h256c6.6,0,12,5.4,12,12C268,18.6,262.6,24,256,24z" />
                    <line class="chart__value" fill="none" stroke-width="24" stroke-dasharray="<?php printf('%dpx', $dasharray); ?>" stroke-dashoffset="<?php printf('%dpx', round($dasharray * (1 - $value))); ?>" stroke-linecap="round" x1="0" y1="12" x2="256" y2="12" />
                </svg>
                <?php break;
            case 'columns':
                $dasharray = 34;
                $value_first = isset($parameters['values']) && isset($parameters['values'][0]) ? $parameters['values'][0] : 0;
                $value_last = isset($parameters['values']) && isset($parameters['values'][1]) ? $parameters['values'][1] : 0; ?>
                <svg class="<?php echo $class; ?>" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 40 40" xml:space="preserve">
                    <line class="chart__value chart__value_first" fill="none" stroke-width="15" stroke-dasharray="<?php printf('%dpx', $dasharray); ?>" stroke-dashoffset="<?php printf('%dpx', round($dasharray * (1 - $value_last))); ?>" x1="31.5" y1="37" x2="31.5" y2="3" />
                    <line class="chart__value chart__value_last" fill="none" stroke-width="15" stroke-dasharray="<?php printf('%dpx', $dasharray); ?>" stroke-dashoffset="<?php printf('%dpx', round($dasharray * (1 - $value_first))); ?>" x1="8.5" y1="37" x2="8.5" y2="3" />
                </svg>
                <?php break;
            case 'circle':
                $dasharray = 327;
                $value_first = isset($parameters['values']) && isset($parameters['values'][0]) ? $parameters['values'][0] : 0;
                $value_last = isset($parameters['values']) && isset($parameters['values'][1]) ? $parameters['values'][1] : 0; ?>
                <svg class="<?php echo $class; ?>" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 122 122" xml:space="preserve">
                    <path class="chart__background" d="M61,122C27.4,122,0,94.6,0,61C0,27.4,27.4,0,61,0c33.6,0,61,27.4,61,61C122,94.6,94.6,122,61,122z M61,18
        c-23.7,0-43,19.3-43,43s19.3,43,43,43s43-19.3,43-43S84.7,18,61,18z" />
                    <path class="chart__value chart__value_first" fill="none" stroke-width="18" stroke-dasharray="<?php printf('%dpx', $dasharray); ?>" stroke-dashoffset="<?php printf('%dpx', round($dasharray * (1 - $value_first))); ?>" d="M61,9c28.7,0,52,23.3,52,52s-23.3,52-52,52 S9,89.7,9,61S32.3,9,61,9" />
                    <path class="chart__value chart__value_last" fill="none" stroke-width="18" stroke-dasharray="<?php printf('%dpx', $dasharray); ?>" stroke-dashoffset="<?php printf('%dpx', round($dasharray * (1 - $value_last))); ?>" d="M61,9C32.3,9,9,32.3,9,61s23.3,52,52,52 s52-23.3,52-52S89.7,9,61,9" />
                    <text class="chart__label" transform="translate(61, 67.5)" text-anchor="middle"><?php echo isset($parameters['label']) ? $parameters['label'] : ''; ?></text>
                </svg>
                <?php break;
        endswitch;

        $result = ob_get_contents();
        ob_end_clean();

        if ($echo) echo $result;

        return $result;
    }