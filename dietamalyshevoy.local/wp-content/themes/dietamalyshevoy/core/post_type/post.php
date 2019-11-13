<?php

function post_init(){
    foreach (array('post-formats', 'trackbacks', 'comments', 'custom-fields', 'page-attributes', 'excerpt') as $feature) {
        remove_post_type_support('post', $feature);
    }

    foreach (array('thumbnail', 'author') as $feature) {
        add_post_type_support('post', $feature);
    }
}
add_action('init', 'post_init');