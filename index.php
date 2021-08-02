<?php
require_once('helpers.php');
require_once('functions.php');

$con = mysqli_connect('127.0.0.1', 'root', '', 'yeticave');
mysqli_set_charset($con, 'utf-8');

$cats_query = 'SELECT code, category FROM categories';
$lots_query = 'SELECT name, description, start_cost, img_link, termination_date, category_id FROM lots';

if (!$con) {
    print('Ошибка подключения: ' . mysqli_connect_error());
} else {
    $cats = get_data($con, $cats_query);
    $lots = get_data($con, $lots_query);
}

$is_auth =  rand(0, 1);
$user_name = 'Михаил Данюшин';
$title = 'YetiCave || Главная';

$content = include_template('main.php', ['cats' => $cats, 'lots' => $lots]);
$layout_content = include_template('layout.php', ['content' => $content, 'title' => $title, 'user_name' => $user_name, 'cats' => $cats]);
print($layout_content);
