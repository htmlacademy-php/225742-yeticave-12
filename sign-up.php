<?php

require_once 'init.php';
require_once 'validation.php';

if(isset($user)) {
    http_response_code(403);
    exit();
}

$page_data = Array();

$args = Array(
    'email' => FILTER_DEFAULT,
    'password' => FILTER_DEFAULT,
    'name' => FILTER_SANITIZE_SPECIAL_CHARS,
    'message' => FILTER_SANITIZE_SPECIAL_CHARS
);

$errors = Array();

$input = filter_input_array(INPUT_POST, $args);
if ($input) {
    $errors = validate_fields($input, $validation_rules);
    if (!isset($errors['email'])) {
        $errors['email'] = check_existing_email($input['email']);
    }

    $errors = array_filter($errors);

    if (!empty($errors)) {
        $page_data['errors'] = $errors;
    } else {
        $data = Array(
            date('Y-m-d H:m:s'),
            $input['email'],
            $input['name'],
            password_hash($input['password'], PASSWORD_DEFAULT),
            $input['message']
        );
        $sql = 'INSERT INTO users (
                   registration_date,
                   email,
                   name,
                   password,
                   contact_info)
                VALUES (?, ?, ?, ?, ?)';


        $stmt = db_get_prepare_stmt($GLOBALS['con'], $sql, $data);
        mysqli_stmt_execute($stmt);
        $error = mysqli_error($GLOBALS['con']);
        if ($error) {
            echo 'Ошибка MYSQL:' . $error;
        } else {
            header('Location: login.php');
            exit();
        }
    }
}

$page_content = include_template('sign-up.php', $page_data);

$layout = Array(
    'title' => 'Регистрация',
    'content' => $page_content,
    'categories' => $categories,
);

$page = include_template('layout.php', $layout);

echo $page;
