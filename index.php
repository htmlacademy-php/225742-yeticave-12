<?php
require_once('helpers.php');
require_once('functions.php');

$con = mysqli_connect('127.0.0.1', 'root', '', 'yeticave');
mysqli_set_charset($con, 'utf-8');

if (!$con) {
    print('Ошибка подключения: ' . mysqli_connect_error());
} else {
    $cats = get_cats($con);
    $lots = get_lots($con);
}

$is_auth =  rand(0, 1);
$user_name = 'Михаил Данюшин';
$title = 'YetiCave || Главная';

$content = include_template('main.php', ['cats' => $cats, 'lots' => $lots]);
$layout_content = include_template('layout.php', ['content' => $content, 'title' => $title, 'user_name' => $user_name, 'cats' => $cats]);
print($layout_content);
