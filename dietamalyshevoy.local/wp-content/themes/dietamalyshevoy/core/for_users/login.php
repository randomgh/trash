<?php

$nonce = isset($_POST['nonce']) ? $_POST['nonce'] : '';
if (!wp_verify_nonce($nonce, 'login_me_nonce')) wp_send_json_error(array('message' => 'Data sent from a third-party page ', 'redirect' => false));

if (is_user_logged_in()) wp_send_json_error(array('message' => 'Вы уже авторизованы!', 'redirect' => false));

$email = isset($_POST['email']) ? $_POST['email'] : false;
$password = isset($_POST['password']) ? $_POST['password'] : false;
$redirect_to = isset($_POST['redirect_to']) ? $_POST['redirect_to'] : false;

$errors = array();

if (!$email) $errors['email'] = 'Введите ваш емейлю' ;
if (!$password) $errors['pass'] = 'Введите ваш пароль.';

if($errors) wp_send_json_error(array('errors' => $errors, 'redirect' => false));

$user = get_user_by( 'login', $email );
if (!$user) $user = get_user_by( 'email', $email );

if (!$user) wp_send_json_error(array('message' => "Логин или пароль не верен.", 'req' => 'email' , 'redirect' => false));

$log = $user->user_login;

$credentials = array(
	'user_login' => $email,
	'user_password' => $password
);

$user = wp_signon( $credentials, false );

if (is_wp_error($user)) wp_send_json_error(array('message' => "Логин или пароль не верен." , 'req' => 'password' , 'redirect' => false));
else wp_send_json_success(array('message' => 'Привет '.$user->display_name.'. загрузка ...', 'redirect' => $redirect_to));