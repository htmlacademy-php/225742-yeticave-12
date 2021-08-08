<?php

require_once('helpers.php');
require_once('functions.php');

$is_auth =  rand(0, 1);
$user_name = 'Михаил Данюшин';
$con = get_connection();

$cats = get_cats($con);

if (isset($_GET['id']) && !empty($_GET['id'])) {
    $lot = get_lot($con, $_GET['id']);
    if ($lot) {
        $content = include_template('lot-info.php', ['cats' => $cats, 'lot' => $lot]);
        $title = 'YetiCave || ' . $lot['name'] . '';
    } else {
        $content = include_template('404.php');
        $title = 'YetiCave || Страницы не существует';
    }
} else {
    $content = include_template('404.php');
    $title = 'YetiCave || Страницы не существует';
}
$layout_content = include_template('layout.php', ['is_auth' => $is_auth, 'content' => $content, 'title' => $title, 'user_name' => $user_name, 'cats' => $cats]);
print($layout_content);
