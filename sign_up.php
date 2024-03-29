<?php

require_once('helpers.php');
require_once('functions.php');
require_once('validation_helpers.php');

$is_auth = 0; //Временно
$user_name = 'Михаил Данюшин';
$con = get_connection();
$title = 'Регистрация';

$cats = get_cats($con);
$content_data = ['cats' => $cats];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $data = validate_sign_up_form($con);
    if (array_filter($data, 'filter_err')) {
        $content_data['errors'] = array_filter($data, 'filter_err');
    } else if (save_user_data($con, array_filter($data, 'filter_values'))) {
        header('Location: sign-in.php'); //Временно
    }
}

$content = include_template('sign-up.php', $content_data);
$layout_data = ['content' => $content,
                'title' => $title,
                'cats' => $cats,
];

$layout_content = include_template('layout.php', $layout_data);
print($layout_content);
