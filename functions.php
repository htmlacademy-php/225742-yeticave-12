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


function set_connection()
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
    } else {
        return $result;
    }
}

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
    $cats_query = 'SELECT code, category FROM categories';
    return get_data($con, $cats_query);
}

/**
 * Запрашивает массив с лотами и возвращает его
 * @return array Массив с полученными данными
 */
function get_lots($con)
{
    $lots_query = 'SELECT l.id, name, description, start_cost, img_link, termination_date, category FROM lots l JOIN categories ON category_id = categories.id WHERE termination_date > STR_TO_DATE(now(), "%Y-%m-%d")';

    return get_data($con, $lots_query);
}

/**
 * Запрашивает данные лота по его id
 * @param int ID лота
 * @return array Массив с полученными данными
 */
function get_lot($con, $id)
{
    $lot_query = 'SELECT name, description, start_cost, img_link, termination_date, category, step FROM lots l JOIN categories ON category_id = categories.id WHERE l.id = ' . intval($id);
    return get_data_item($con, $lot_query);
}
?>
