<?php

require_once('helpers.php');
require_once('functions.php');

$cats = get_cats();
$lots = get_lots();

$is_auth =  rand(0, 1);
$user_name = 'Михаил Данюшин';
$title = 'YetiCave || Главная';

$content = include_template('main.php', ['cats' => $cats, 'lots' => $lots]);
$layout_content = include_template('layout.php', ['content' => $content, 'title' => $title, 'user_name' => $user_name, 'cats' => $cats]);
print($layout_content);
