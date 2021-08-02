<?php
$con = mysqli_connect('127.0.0.1', 'root', '', 'yeticave');
mysqli_set_charset($con, 'utf-8');

if (!$con) {
    print('Ошибка подключения: ' . mysqli_connect_error());
} else {
    $sql_cats = 'SELECT code, category FROM categories';
    $sql_lots = 'SELECT name, description, start_cost, img_link, termination_date, category_id FROM lots';
    $result_cats = mysqli_query($con, $sql_cats);
    $result_lots = mysqli_query($con, $sql_lots);

    if (!$result_cats || !$result_lots) {
        $error = mysqli_error($con);
        print('Ошибка SQL: ' . $error);
    } else {
        $cats = mysqli_fetch_all($result_cats, MYSQLI_ASSOC);
        $lots = mysqli_fetch_all($result_lots, MYSQLI_ASSOC);
    }
}

$is_auth =  rand(0, 1);
$user_name = 'Михаил Данюшин';
$title = 'YetiCave || Главная';
// $items = [
//     ['name' => '2014 Rossignol District Snowboard', 'cat' => $cats['boards'], 'cost' => 10999, 'img_url' => 'img/lot-1.jpg', 'date' => '2021-08-01'],
//     ['name' => 'DC Ply Mens 2016/2017 Snowboard', 'cat' => $cats['boards'], 'cost' => 159999, 'img_url' => 'img/lot-2.jpg', 'date' => '2021-07-25'],
//     ['name' => 'Крепления Union Contact Pro 2015 года размер L/XL', 'cat' => $cats['attachment'], 'cost' => 8000, 'img_url' => 'img/lot-3.jpg', 'date' => '2021-08-02'],
//     ['name' => 'Ботинки для сноуборда DC Mutiny Charocal', 'cat' => $cats['boots'], 'cost' => 10999, 'img_url' => 'img/lot-4.jpg', 'date' => '2021-08-10'],
//     ['name' => 'Куртка для сноуборда DC Mutiny Charocal', 'cat' => $cats['clothing'], 'cost' => 7500, 'img_url' => 'img/lot-5.jpg', 'date' => '2021-07-19'],
//     ['name' => 'Маска Oakley Canopy', 'cat' => $cats['other'], 'cost' => 5400, 'img_url' => 'img/lot-6.jpg', 'date' => '2021-08-01']
// ];

require_once('helpers.php');
require_once('functions.php');

$content = include_template('main.php', ['cats' => $cats, 'lots' => $lots]);
$layout_content = include_template('layout.php', ['content' => $content, 'title' => $title, 'user_name' => $user_name, 'cats' => $cats]);
print($layout_content);
