<?php

$nonce = isset($_POST['nonce']) ? $_POST['nonce'] : '';

if (!wp_verify_nonce($nonce, 'register_me_nonce')) wp_send_json_error(array('message' => 'Data sent from a third-party page ', 'redirect' => false));

if (is_user_logged_in()) wp_send_json_error(array('message' => 'Вы уже авторизованы!' , 'req' => 'error_response' , 'redirect' => false));

if (!get_option('users_can_register')) wp_send_json_error(array('message' => 'Регистрация временно недоступна', 'req' => 'error_response' , 'redirect' => false));

$login = isset($_POST['email']) ? $_POST['email'] : '';
$email = isset($_POST['email']) ? $_POST['email'] : '';
$password = isset($_POST['password']) ? $_POST['password'] : '';
$redirect_to = isset($_POST['redirect_to']) ? $_POST['redirect_to'] : false;

$errors = array();

if (!$email) $errors['email'] = 'Введите ваш емейл!';
if (!preg_match('/^(([^<>()\[\]\.,;:\s@\"]+(\.[^<>()\[\]\.,;:\s@\"]+)*)|(\".+\"))@(([^<>()[\]\.,;:\s@\"]+\.)+[^<>()[\]\.,;:\s@\"]{2,})$/i', $email)) $errors['email'] = 'Пожалуйста введите верный формат почты (пример: name@email.com)';
if (!$login) $errors['email'] = 'Введите ваш емейл!';
if (!preg_match_all('/[A-Z]/', $password)) $errors['password'] = 'В пароле должна быть как минимум одна заглавная буква';
if (!preg_match_all('/\d/', $password)) $errors['password'] = 'В пароле должна быть как минимум одна цифра';
if (strlen($password) < 6 and strlen($password) != 0) $errors['password'] = 'Введите как минимум 6 символов!';
if (false !== strpos(wp_unslash($password), "\\" ) ) $errors['password'] = 'Пароль не может иметь обратные слеши!';
if (!$password) $errors['password'] = 'Пожжалуйста, введите ваш пароль';

if($errors) wp_send_json_error(array('errors' => $errors, 'redirect' => false));

$user_id = wp_create_user($login,$password,$email);

if (is_wp_error($user_id) && $user_id->get_error_code() == 'existing_user_email') wp_send_json_error(array('message' => 'Пользователь с такой почтой уже разегистиррован.', 'req' => 'email' , 'redirect' => false));
elseif (is_wp_error($user_id) && $user_id->get_error_code() == 'existing_user_login') wp_send_json_error(array('message' => 'Пользователь с такой почтой уже разегистиррован.', 'req' => 'email' , 'redirect' => false));
elseif (is_wp_error($user_id) && $user_id->get_error_code() == 'empty_user_login') wp_send_json_error(array('message' => 'Почта должна быть только с латинскими буквами', 'req' => 'email' , 'redirect' => false));
elseif (is_wp_error($user_id)) wp_send_json_error(array('message' => $user_id->get_error_code(), 'req' => 'error_response' , 'redirect' => false));

wp_send_json_success(array('message' => 'Поздравляем, Вы зарегистрированы!', 'redirect' => $redirect_to . '/' ));