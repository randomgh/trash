<?php

$nonce = isset($_POST['nonce']) ? $_POST['nonce'] : '';

if (!wp_verify_nonce($nonce, 'register_phone_me_nonce')) wp_send_json_error(array('message' => 'Data sent from a third-party page ', 'redirect' => false));

if (is_user_logged_in()) wp_send_json_error(array('message' => 'Вы уже авторизованы!' , 'req' => 'error_response' , 'redirect' => false));

if (!get_option('users_can_register')) wp_send_json_error(array('message' => 'Регистрация временно недоступна', 'req' => 'error_response' , 'redirect' => false));

//TODO: create logic for registration via phone