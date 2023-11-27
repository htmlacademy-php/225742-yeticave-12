<?php
/**
 * @var $con mysqli - Ресурс соединения
 * @var $categories array - Категории из БД
 */

require_once 'init.php';

$lot_id = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT) ?? '';

$lot = null;
if (!$lot_id) {
    http_response_code(404);
    header('Location: 404.php');
    die;
} else {
    $lot = get_lot(intval($lot_id), $con);
}

if (!$lot) {
    header('Location: 404.php');
    exit();
}

$page_content = include_template('lot.php', Array(
    'lot' => $lot,
    'categories' => $categories,
));

$layout = [
    'title' => 'Главная',
    'categories' => $categories,
    'content' => $page_content
];

$page = include_template('layout.php', $layout);
?>

<?=$page?>
