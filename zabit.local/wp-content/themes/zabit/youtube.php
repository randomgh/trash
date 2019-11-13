<?php

    function get_youtube($id, $echo = true) {
        ob_start();
        ?>
        <div class="youtube" data-id="<?php echo $id; ?>"></div>
        <?php
        $result = ob_get_contents();
        ob_end_clean();

        if ($echo) echo $result;

        return $result;
    }