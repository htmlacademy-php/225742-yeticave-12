<?php

require_once('helpers.php');
require_once('functions.php');
require_once('validation_helpers.php');

$is_auth = 0; //Временно
$user_name = 'Михаил Данюшин';
$con = get_connection();
$title = 'Вход';

$cats = get_cats($con);
$content_data = ['cats' => $cats];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $data = validate_sign_in_form($con);
    if (array_filter($data, 'filter_err')) {
        $content_data['errors'] = array_filter($data, 'filter_err');
    }
}

$content = include_template('sign-in.php', $content_data);
$layout_data = ['content' => $content,
                'title' => $title,
                'cats' => $cats,
];

$layout_content = include_template('layout.php', $layout_data);
print($layout_content);
