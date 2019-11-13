<?php

function page_init(){
    foreach (array('post-formats', 'trackbacks', 'comments', 'author', 'custom-fields', 'page-attributes', 'thumbnail', 'excerpt') as $feature) {
        remove_post_type_support('page', $feature);
    }

    foreach (array() as $feature) {
        add_post_type_support('page', $feature);
    }
}
add_action('init', 'page_init');