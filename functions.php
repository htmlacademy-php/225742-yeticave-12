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
 * Запрашивает данные из БД и возвращает их в виде массива
 * @param boolean Ресурс соединения
 * @param string Строка-запрос в БД
 * @return array Массив с полученными данными
 */
function get_data($query)
{
    $con = set_connection();
    $data = null;
    $result = mysqli_query($con, $query);

    if (!$result) {
        $error = mysqli_error($con);
        print('Ошибка SQL: ' . $error);
        $data = null;
    } else {
        $data = mysqli_fetch_all($result, MYSQLI_ASSOC);
    }
    return $data;
};

/**
 * Запрашивает массив с категориями и возвращает его
 * @param boolean Ресурс соединения
 * @return array Массив с полученными данными
 */
function get_cats()
{
    $cats_query = 'SELECT code, category FROM categories';
    return get_data($cats_query);
}

/**
 * Запрашивает массив с лотами и возвращает его
 * @param boolean Ресурс соединения
 * @return array Массив с полученными данными
 */
function get_lots()
{
    $lots_query = 'SELECT name, description, start_cost, img_link, termination_date,  category FROM lots JOIN categories ON category_id = categories.id';
    return get_data($lots_query);
}
