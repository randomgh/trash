<?php

    function get_video($id, $echo = true) {
	    $result = sprintf('<div class="video"><video class="video__video" autoplay="autoplay" loop="loop" muted="muted">
   <source src="%s"></video></div>', wp_get_attachment_url($id));

        if ($echo) echo $result;

        return $result;
    }