<?php

require_once('helpers.php');
require_once('validation_helpers.php');
require_once('functions.php');

$is_auth = 1; //Временно
$user_name = 'Михаил Данюшин';
$title = 'YetiCave || Добавить лот';
$is_need_flatpickr = true;
$con = get_connection();

$cats = get_cats($con);

$content_data = ['cats' => $cats];


if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $data = validate_add_lot_form($con);
    var_dump(array_filter($data, 'filter_values'));
    if (array_filter($data, 'filter_err')) {
        $content_data['errors'] = array_filter($data, 'filter_err');
    } else if (add_new_lot($con, array_filter($data, 'filter_values'))) {
        header('Location:' . $success_url);
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
