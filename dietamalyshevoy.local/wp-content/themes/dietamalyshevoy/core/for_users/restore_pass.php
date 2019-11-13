<?php

$error = array();
$redirect_to = isset($_POST['redirect_to']) ? $_POST['redirect_to'] : false;
$email = isset($_POST['email']) ? $_POST['email'] : '';
$nonce = isset($_POST['nonce']) ? $_POST['nonce'] : '';

if (!wp_verify_nonce($nonce, 'restore_pass_nonce')) wp_send_json_error(array('message' => 'Data sent from a third-party page ', 'req' => 'error', 'redirect' => false));

if( empty( $email ) ) {
    $error = 'Введите ваш емейл.';
} else if( ! is_email( $email )) {
    $error = 'Неверный формат емейла.';
} else if( ! email_exists( $email ) ) {
    $error = 'Пользователь с таким емейлом не найден.';
}

if($error) wp_send_json_error(array('message' => $error , 'req' => 'email', 'redirect' => false));

$my_user = get_user_by('email', $email);
$user_id =  $my_user->ID;

$code = sha1($user_id . time());
$activation_link = home_url().'/new-password?key='.$code.'&user='.$user_id;
delete_user_meta( $user_id, 'activated_code');
add_user_meta( $user_id, 'activated_code', $code, true );
$txt = '<h3>Привет</h3><p>Пожалуйста перейдите по ссылку что бы сменить пароль!</p><a href="'.$activation_link.'">'.$activation_link.'</a></p>';
add_filter( 'wp_mail_content_type', 'set_html_content_type' );
wp_mail( $email, 'Смена пароля', $txt );
remove_filter( 'wp_mail_content_type', 'set_html_content_type' );

wp_send_json_success(array('message' => 'Провертье вашу почту!', 'redirect' => false));


