<?php
/**
 * Форматирует цену лота в карточке
 * @param int Цена лота в числовом значении
 * @return string Итоговый формат цены в виде строки
 */
function get_cost($number)
{
    $cost = number_format($number, 0, '', ' ');
    return (string)$cost . ' ₽';
}

/**
 * Вычисляет оставшееся время лота
 * @param string Дата истечения лота
 * @return array Массив, первый ключ которого содержит часы, а второй минуты, оставшиеся до истечения лота
 */
function get_time_in_hours($date)
{
    $timestamp = strtotime($date) / 60;
    $currentTimestamp = floor(time() / 60);
    $lotTime = ['hours' => floor(($timestamp - $currentTimestamp) / 60), 'minutes' => ($timestamp - $currentTimestamp) % 60];
    return $lotTime;
}


function get_connection()
{
    $params = require('connection_params.php');
    $con = mysqli_connect($params['host'], $params['user'], $params['password'], $params['db_name']);
    mysqli_set_charset($con, 'utf-8');

    if (!$con) {
        print('Ошибка подключения: ' . mysqli_connect_error());
    }

    return $con;
}

/**
 * Проверяет результат выполнения запроса
 * @param boolean Ресурс соединения
 * @param string Строка-запрос в БД
 * @return boolean Флаг удачного/неудачного выполнения запроса
 */

function check_con_result($con, $query) {
    $result = mysqli_query($con, $query);
    if (!$result) {
        $error = mysqli_error($con);
        print('Ошибка SQL: ' . $error);
        return false;
    }
    return $result;
}

// function check_lot_exists($con, $item) {
//     $query = 'SELECT '
//     $result = check_con_result($con, $query);
// }

/**
 * Запрашивает данные из БД и возвращает их в виде двумерного массива
 * @param boolean Ресурс соединения
 * @param string Строка-запрос в БД
 * @return array Массив с полученными данными
 */
function get_data($con, $query)
{
    $data = null;
    $result = check_con_result($con, $query);
    if ($result) {
        $data = mysqli_fetch_all($result, MYSQLI_ASSOC);
    }
    return $data;
};
/**
 * Запрашивает данные одной строки из БД и возвращает ассоциативный массив
 * @param boolean Ресурс соединения
 * @param string Строка-апрос в БД
 * @return array Массив с полученными данными
 */
function get_data_item($con, $query) {
    $data = null;
    $result = check_con_result($con, $query);
    if ($result) {
        $data = mysqli_fetch_assoc($result);
    }
    return $data;
}

/**
 * Запрашивает массив с категориями и возвращает его
 * @param boolean Ресурс соединения
 * @return array Массив с полученными данными
 */
function get_cats($con)
{
    $cats_query = '
    SELECT
        code,
        category,
        id
    FROM categories';
    return get_data($con, $cats_query);
}

/**
 * Запрашивает массив с лотами и возвращает его
 * @return array Массив с полученными данными
 */
function get_lots($con)
{
    $lots_query = '
    SELECT
        l.id,
        name,
        description,
        start_cost,
        img_link,
        termination_date,
        category
    FROM lots l
        JOIN categories ON category_id = categories.id
    WHERE termination_date > STR_TO_DATE(now(), "%Y-%m-%d")';

    return get_data($con, $lots_query);
}

/**
 * Запрашивает данные лота по его id
 * @param int ID лота
 * @return array Массив с полученными данными
 */
function get_lot($con, $id)
{
    $lot_query = '
    SELECT
        name,
        description,
        start_cost,
        img_link,
        termination_date,
        category,
        step
    FROM lots l
        JOIN categories ON category_id = categories.id
    WHERE l.id = ' . intval($id);
    return get_data_item($con, $lot_query);
}

/**
 * Перемещает загруженное изображение в директорию проекта
 * @param string Поле файла
 */
function move_file($file) {
    $file_ext = pathinfo($file['name'], PATHINFO_EXTENSION);
    $file_name = md5(microtime()) . '.' . $file_ext;
    $file_path = __DIR__ . '/uploads/';
    $file_url = '/uploads/' . $file_name;
    move_uploaded_file($file['tmp_name'], $file_path . $file_name);
    return $file_url;
}

function add_new_lot($con, $data) {
    $lot_name = $data['lot-name'];
    $category = (int)$data['category'];
    $description = $data['message'];
    $lot_rate = (int)$data['lot-rate'];
    $lot_step = (int)$data['lot-step'];
    $lot_date = $data['lot-date'];
    $lot_image = move_file($_FILES['lot-image']);
    $sql = 'INSERT INTO lots (name, category_id, description, start_cost, step, termination_date, img_link) VALUES (?, ?, ?, ?, ?, ?, ?)';
    $stmt = mysqli_prepare($con, $sql);
    mysqli_stmt_bind_param($stmt, 'sisiiss', $lot_name, $category, $description, $lot_rate, $lot_step, $lot_date, $lot_image);
    $result = mysqli_stmt_execute($stmt);

    if (!$result) {
        $error = mysqli_error($con);
        print("Ошибка MySQL: " . $error);
        return false;
    }

    return $result;
}

/**
 * Возвращает значение поля формы после валидации
 * @param string Поле формы
 * @return string Значение поля
 */
function get_post_val($key) {
    return $_POST[$key] ?? '';
}

function save_user_data($con) {
    $date = date('Y-m-d H:i:s');
    $email = $_POST['email'];
    $name = $_POST['name'];
    $password  = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $contact = $_POST['message'];

    $query = 'INSERT INTO users (registration_date, email, name, password, contact) VALUES (?, ?, ?, ?, ?)';
    $stmt = mysqli_prepare($con, $query);
    mysqli_stmt_bind_param($stmt, 'sssss', $date, $email, $name, $password, $contact);
    $result = mysqli_stmt_execute($stmt);

    if (!$result) {
        $error = mysqli_error($con);
        print("Ошибка MySQL: " . $error);
        return false;
    }

    return $result;
}
