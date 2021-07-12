<?php
$is_auth =  rand(0, 1);
$user_name = 'Михаил Данюшин';
$cats = ['boards' => 'Доски и лыжи',
         'attachment' => 'Крепления',
         'boots' => 'Ботинки',
         'clothing' => 'Одежда',
         'tools' => 'Инструменты',
         'other' => 'Разное'];

$title = 'YetiCave || Главная';
$cats = ['boards' => 'Доски и лыжи',
         'attachment' => 'Крепления',
         'boots' => 'Ботинки',
         'clothing' => 'Одежда',
         'tools' => 'Инструменты',
         'other' => 'Разное'];

$items = [
            ['name' => '2014 Rossignol District Snowboard', 'cat' => $cats['boards'], 'cost' => 10999, 'img_url' => 'img/lot-1.jpg'],
            ['name' => 'DC Ply Mens 2016/2017 Snowboard', 'cat' => $cats['boards'], 'cost' => 159999, 'img_url' => 'img/lot-2.jpg'],
            ['name' => 'Крепления Union Contact Pro 2015 года размер L/XL', 'cat' => $cats['attachment'], 'cost' => 8000, 'img_url' => 'img/lot-3.jpg'],
            ['name' => 'Ботинки для сноуборда DC Mutiny Charocal', 'cat' => $cats['boots'], 'cost' => 10999, 'img_url' => 'img/lot-4.jpg'],
            ['name' => 'Куртка для сноуборда DC Mutiny Charocal', 'cat' => $cats['clothing'], 'cost' => 7500, 'img_url' => 'img/lot-5.jpg'],
            ['name' => 'Маска Oakley Canopy', 'cat' => $cats['other'], 'cost' => 5400, 'img_url'=>'img/lot-6.jpg']
        ];

require_once('helpers.php');
require_once('functions.php');

$content = include_template('main.php', ['cats' => $cats, 'items' => $items]);
$layout_content = include_template('layout.php', ['content' => $content, 'title' => $title, 'user_name' => $user_name, 'cats' => $cats]);
print($layout_content);
?>
