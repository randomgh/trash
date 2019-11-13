<?php

    function get_title($title = null, $echo = true) {
        if (!$title) $title = get_the_title();

        ob_start();
        ?>
        <div class="title">
            <div class="title__text"><?php echo $title; ?></div>
        </div>
        <?php
        $result = ob_get_contents();
        ob_end_clean();

        if ($echo) echo $result;

        return $result;
    }