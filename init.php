<?php
date_default_timezone_set('Europe/Moscow');
session_start();

require_once 'ACCESSES.php';
require_once 'helpers.php';

$params = array_values($con_params);
$con = mysqli_connect(...$params);

if (!$con) {
    $error = mysqli_connect_error();
    print_r('Ошибка MySQL:' . $error);
    die;
}

mysqli_set_charset($con, 'utf8');

$categories = get_categories($con);
$user = $_SESSION['user'] ?? null;
