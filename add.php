<?php

require_once('helpers.php');
require_once('functions.php');

$is_auth = 1; //Временно
$user_name = 'Михаил Данюшин';
$title = 'YetiCave || Добавить лот';
$is_need_flatpickr = true;
$con = get_connection();

$cats = get_cats($con);

$content_data = ['cats' => $cats];


if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $errors = validate_form($_POST, $_FILES);
    if (!empty($errors)) {
        $content_data['errors'] = $errors;
    } else {
        add_new_lot($con, $_POST);
    }
};

$content = include_template('add-lot.php', $content_data);
$layout_data = ['is_auth' => $is_auth,
                'content' => $content,
                'title' => $title,
                'user_name' => $user_name,
                'cats' => $cats,
                'is_need_flatpickr' => $is_need_flatpickr
];
$layout_content = include_template('layout.php', $layout_data);
print($layout_content);
