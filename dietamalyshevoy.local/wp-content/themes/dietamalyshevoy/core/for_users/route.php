<?php

add_action('wp_ajax_nopriv_login_me', 'login_me');
add_action('wp_ajax_login_me', 'login_me');
function login_me(){
	require_once dirname(__FILE__) . '/login.php';
}

add_action('wp_ajax_logout_me', 'logout_me');
function logout_me() {
   require_once dirname(__FILE__) . '/logout.php';
}

add_action('wp_ajax_register_me', 'register_me');
add_action('wp_ajax_nopriv_register_me', 'register_me');
function register_me() {
    require_once dirname(__FILE__) . '/register.php';  
}

add_action('wp_ajax_register_me', 'register_phone_me');
add_action('wp_ajax_nopriv_register_me', 'register_phone_me');
function register_phone_me() {
    require_once dirname(__FILE__) . '/register_phone.php';
}

add_action('wp_ajax_new-pass', 'new_pass');
add_action('wp_ajax_nopriv_new-pass', 'new_pass');
function new_pass() {
    require_once dirname(__FILE__) . '/new_pass.php';
}

add_action('wp_ajax_restore_pass', 'restore_pass');
add_action('wp_ajax_nopriv_restore_pass', 'restore_pass');
function restore_pass() {
    require_once dirname(__FILE__) . '/restore_pass.php';
}

function set_html_content_type() {
    return 'text/html';
}