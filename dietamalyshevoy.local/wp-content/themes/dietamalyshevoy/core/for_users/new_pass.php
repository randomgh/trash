<?php

$nonce = isset($_POST['nonce']) ? $_POST['nonce'] : '';
if (!wp_verify_nonce($nonce, 'new_pass_nonce')) wp_send_json_error(array('message' => 'Data sent from a third-party page ', 'redirect' => false));

$redirect_to = isset($_POST['redirect_to']) ? $_POST['redirect_to'] : false;
$new_password = isset($_POST['password']) ? $_POST['password'] : '';
$activate_code = isset($_POST['key']) ? $_POST['key'] : '';
$user_id  = isset($_POST['user']) ? $_POST['user'] : '';
$errors = array();

if(!$activate_code) wp_send_json_error(array('message' => 'Активационный код не найден' , 'req' => 'error' , 'redirect' => false));
if(!$user_id) wp_send_json_error(array('message' => 'Пользователь не найден' , 'req' => 'error' , 'redirect' => false));

if (!preg_match_all('/[A-Z]/', $new_password)) $errors['password'] = 'В пароле должна быть как минимум одна заглавная буква';
if (!preg_match_all('/\d/', $new_password)) $errors['password'] = 'В пароле должна быть как минимум одна цифра';
if (strlen($new_password) < 6 and strlen($new_password) != 0) $errors['password'] = 'Введите как минимум 6 символов!';
if (false !== strpos(wp_unslash($new_password), "\\" ) ) $errors['password'] = 'Пароль не может иметь обратные слеши!';
if (!$new_password) $errors['password'] = 'Пожжалуйста, введите ваш пароль';

$user = get_user_by( 'id', $user_id );
$key = get_user_meta( $user_id, 'activate_code', true );

if($errors) wp_send_json_error(array('errors' => $errors, 'redirect' => false));

if( $key == $activate_code) {
    wp_update_user( array (
        'ID' => $user->ID,
        'user_pass' => $new_password
        )
    );

     wp_send_json_success(array('message' => 'Пароль быд изменен' , 'redirect' => $redirect_to));
}else{
    wp_send_json_error(array('message' => 'Активационный код не найден' , 'req' => 'error' , 'redirect' => false));
}