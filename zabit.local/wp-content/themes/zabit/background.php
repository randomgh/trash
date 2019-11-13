<?php

    function get_background($attachment_id = null, $type = 'news', $echo = true) {
        $random = md5($type.($attachment_id ? $attachment_id : '').rand());

        list($src, $width, $height) = $attachment_id ? wp_get_attachment_image_src($attachment_id, "background-{$type}") : array('', 0, 0);

        ob_start();
        ?>
        <svg class="background background_<?php echo $type; ?> <?php echo $attachment_id == null ? 'background_hidden' : ''; ?>" <?php echo $attachment_id ? sprintf('viewBox="%d %d %d %d"', 0, 0, $width, $height) : ''; ?> preserveAspectRatio="xMidYMid slice" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" xml:space="preserve">
            <defs>
                <?php /*
                <filter id="background--<?php echo $random; ?>" x="0%" y="0%" width="100%" height="100%" color-interpolation-filters="sRGB">
                    <feColorMatrix type="matrix" values="0.33 0.33 0.33 0 0
                                                         0.33 0.33 0.33 0 0
                                                         0.33 0.33 0.33 0 0
                                                         0    0    0    1 0"></feColorMatrix>
                </filter>
                */ ?>
                <?php switch ($type) :
	                case 'static': ?>
                        <linearGradient id="background-static-1--<?php echo $random; ?>" x1="7.1%" y1="73.9%" x2="92.4%" y2="100.6%" gradientUnits="userSpaceOnUse">
                            <stop offset="0" stop-color="#282828"/>
                            <stop offset="0.5" stop-color="#282828" stop-opacity="0.5"/>
                            <stop offset="1" stop-color="#282828"/>
                        </linearGradient>
                        <linearGradient id="background-static-2--<?php echo $random; ?>" x1="49.9%" y1="107.1%" x2="49.9%" y2="15.9%" gradientUnits="userSpaceOnUse">
                            <stop offset="0" stop-color="#282828"/>
                            <stop offset="1" stop-color="#282828" stop-opacity="0"/>
                        </linearGradient>
		                <?php break;
	                case 'full': ?>
                        <linearGradient id="background-full-1--<?php echo $random; ?>" x1="7.1%" y1="73.9%" x2="92.4%" y2="100.6%" gradientUnits="userSpaceOnUse">
                            <stop offset="0" stop-color="#282828"/>
                            <stop offset="0.5" stop-color="#282828" stop-opacity="0.5"/>
                            <stop offset="1" stop-color="#282828"/>
                        </linearGradient>
                        <linearGradient id="background-full-2--<?php echo $random; ?>" x1="49.9%" y1="107.1%" x2="49.9%" y2="15.9%" gradientUnits="userSpaceOnUse">
                            <stop offset="0" stop-color="#282828"/>
                            <stop offset="1" stop-color="#282828" stop-opacity="0"/>
                        </linearGradient>
		                <?php break;
                    case 'left': ?>
                        <linearGradient id="background-left-1--<?php echo $random; ?>" x1="0" y1="0" x2="124.3%" y2="51.8%" gradientUnits="userSpaceOnUse">
                            <stop offset="0" stop-color="#282A2D" stop-opacity="0"/>
                            <stop offset="0.85" stop-color="#282828"/>
                        </linearGradient>
                        <?php break;
                    case 'right': ?>
                        <linearGradient id="background-right-1--<?php echo $random; ?>" x1="7.1%" y1="61.9%" x2="95.6%" y2="62.7%" gradientUnits="userSpaceOnUse">
                            <stop offset="0" stop-color="#282828"/>
                            <stop offset="0.5" stop-color="#282828" stop-opacity="0.9"/>
                            <stop offset="0.85" stop-color="#282828"/>
                        </linearGradient>
                        <linearGradient id="background-right-2--<?php echo $random; ?>" x1="12.8%" y1="57.3%" x2="56.9%" y2="57.3%" gradientUnits="userSpaceOnUse">
                            <stop offset="0" stop-color="#282828"/>
                            <stop offset="1" stop-color="#141414" stop-opacity="0"/>
                        </linearGradient>
                        <?php break;
                    case 'news': ?>
                        <linearGradient id="background-news-1--<?php echo $random; ?>" x1="0" y1="0" x2="93.9%" y2="85.2%" gradientUnits="userSpaceOnUse">
                            <stop offset="0" stop-color="#282A2D" stop-opacity="0"/>
                            <stop offset="0.85" stop-color="#282828"/>
                        </linearGradient>
                        <?php break;
                endswitch; ?>
            </defs>

            <image class="background__img" x="0" y="0" width="100%" height="100%"<?php /* filter="url(#background--<?php echo $random; ?>)" */ ?> xlink:href="<?php echo $src; ?>" opacity="0.7" preserveAspectRatio="xMidYMid slice"></image>

            <?php switch ($type) :
	            case 'static': ?>
                    <rect class="background__gradient" width="100%" height="100%" fill="url(#background-static-1--<?php echo $random; ?>)" style="mix-blend-mode:exclusion"/>
                    <rect class="background__gradient" width="100%" height="100%" fill="url(#background-static-2--<?php echo $random; ?>)"/>
		            <?php break;
	            case 'full': ?>
                    <rect class="background__gradient" width="100%" height="100%" fill="url(#background-full-1--<?php echo $random; ?>)" style="mix-blend-mode:exclusion"/>
                    <rect class="background__gradient" width="100%" height="100%" fill="url(#background-full-2--<?php echo $random; ?>)"/>
		            <?php break;
                case 'left': ?>
                    <rect class="background__gradient" width="100%" height="100%" fill="url(#background-left-1--<?php echo $random; ?>)"/>
                    <?php break;
                case 'right': ?>
                    <rect class="background__gradient" width="100%" height="100%" fill="url(#background-right-1--<?php echo $random; ?>)" style="mix-blend-mode:exclusion"/>
                    <rect class="background__gradient" width="100%" height="100%" fill="url(#background-right-2--<?php echo $random; ?>)" fill-opacity="0.7"/>
                    <?php break;
                case 'news': ?>
                    <rect class="background__gradient" width="100%" height="100%" fill="url(#background-news-1--<?php echo $random; ?>)"/>
                    <?php break;
            endswitch; ?>
        </svg>
        <?php
        $result = ob_get_contents();
        ob_end_clean();

        if ($echo) echo $result;

        return $result;
    }