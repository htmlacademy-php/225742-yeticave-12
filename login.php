<?php

require_once 'init.php';
require_once 'validation.php';
$args = Array(
    'email' => FILTER_SANITIZE_SPECIAL_CHARS,
    'password' => FILTER_DEFAULT
);

$page_data = Array();

function check_password($user_input, $db_password) {
    return password_verify($user_input, $db_password);
}

function auth($user_data) {
    $sql = "SELECT * FROM users WHERE email = '".$user_data['email']."'";
    $db_res = mysqli_query($GLOBALS['con'], $sql);
    $user = $db_res ? mysqli_fetch_array($db_res, MYSQLI_ASSOC) : null;

    if ($user == null || !password_verify($user_data['password'], $user['password'])) {
        return false;
    }

    $_SESSION['user'] = $user;
    header('Location: index.php');
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $input = filter_input_array(INPUT_POST, $args);

    if ($input) {
        $errors = array_filter(validate_fields($input, $validation_rules));
        if (!empty($errors)) {
            $page_data['errors'] = $errors;
        } else {
            $page_data['auth_success'] = auth($input);
        }
    }
} else {
    if (isset($_SESSION['user'])) {
        header('Location: index.php');
        exit();
    }
}


$page_content = include_template('login.php', $page_data);

$layout = [
    'title' => 'Вход',
    'categories' => $categories,
    'content' => $page_content
];

$page = include_template('layout.php', $layout);
echo $page;
