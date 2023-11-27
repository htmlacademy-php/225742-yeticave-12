<?php
/**
 * @var $con mysqli - Ресурс соединения
 * @var $categories array - Категории из БД
 */

require_once 'init.php';
require_once 'validation.php';

if(!isset($user)) {
    http_response_code(403);
    exit();
}


$args = Array(
    'lot-name' => FILTER_SANITIZE_SPECIAL_CHARS,
    'category' => FILTER_SANITIZE_NUMBER_INT,
    'message' => FILTER_SANITIZE_SPECIAL_CHARS,
    'lot-rate' => FILTER_SANITIZE_NUMBER_INT,
    'lot-step' => FILTER_SANITIZE_NUMBER_INT,
    'lot-date' => FILTER_SANITIZE_SPECIAL_CHARS
);

$page_data = Array(
    'categories' => $categories
);

$input = filter_input_array(INPUT_POST, $args);

if ($input) {
    $lot_image = $_FILES['lot-img'];
    $input['img'] = $lot_image;
    $errors = validate_fields($input, $validation_rules);
    $errors = array_filter($errors);
    if (!empty($errors)) {
        $page_data['errors'] = $errors;
    } else {
        $file_url = save_file($input['img']);

        $data = Array(
            $input['lot-name'],
            $_SESSION['user']['id'],
            date('Y-m-d H:m:s'),
            $input['category'],
            $input['message'],
            $file_url,
            $input['lot-rate'],
            $input['lot-step'],
            $input['lot-date']
        );
        $sql = 'INSERT INTO lots (
                  title,
                  user_id,
                  creation_date,
                  category_id,
                  description,
                  image_url,
                  initial_cost,
                  bid_step,
                  completion_date) 
                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)';

        $stmt = db_get_prepare_stmt($GLOBALS['con'], $sql, $data);
        mysqli_stmt_execute($stmt);
        $id = mysqli_insert_id($GLOBALS['con']);
        header('Location: lot.php?id='.$id);
        exit();
    }
}

$page_content = include_template('add-lot.php', $page_data);

$layout = Array(
    'title' => 'Добавление лота',
    'categories'=> $categories,
    'content'=>$page_content,
);

$page = include_template('layout.php', $layout);

echo $page;
