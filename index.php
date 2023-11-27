<?php
/**
 * @var $categories array Категории лотов
 * @var $com mysqli Ресурс соединения
 */

require_once 'init.php';
$is_auth = rand(0, 1);
$user_name = ''; // укажите здесь ваше имя

$lots = get_lots($con);

$page_content = include_template('main.php', Array(
    'categories' => $categories,
    'lots' => $lots
));

$layout = [
    'title' => 'Главная',
    'categories' => $categories,
    'content' => $page_content,
    'user' => $user
];

$page = include_template('layout.php', $layout);
?>

<?=$page?>
