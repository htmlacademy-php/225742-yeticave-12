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
        category
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
 * Проверяет поле названия лота
 * @param string Поле имени
 * @return string Сообщение об ошибке
 */
function validate_name($field) {
    if (empty($_POST[$field])) {
        return 'Поле не заполнено';
    }
}

/**
 * Проверяет поле описания лота
 * @param string Поле описания
 * @return string Сообщение об ошибке
 */
function validate_message($field) {
    if (empty($_POST[$field])) {
        return 'Поле не заполнено';
    }
}

/**
 * Проверяет поле загрузки файла
 * @param string Поле загрузки файла
 * @return string Сообщение об ошибке
 */
function validate_image($image) {
    if ($_FILES[$image]['error'] == 4) {
       return 'Добавьте изображение лота';
    }

    $image_name = $_FILES[$image]['tmp_name'];

    if ($image_name) {
        $image_mime = mime_content_type($image_name);

        if ($image_mime !== 'image/jpeg' && $image_mime !== 'image/png') {
            return "Файл должен быть в формате jpeg или png";
        }
    }
}

/**
 * Проверяет поле начальной цены
 * @param string Поле начальной цены
 * @return string Сообщение об ошибке
 */
function validate_rate($field) {
    if (strlen($_POST[$field]) == 0) {
        return 'Поле не заполнено';
    }

    if ($_POST[$field] <= 0) {
        return 'Цена должна быть больше ноля';
    }
}

/**
 * Проверяет поле шага ставки
 * @param string Поле шага ставки
 * @return string Сообщение об ошибке
 */
function validate_step($field) {
    if (strlen($_POST[$field]) == 0) {
        return 'Поле не заполнено';
    }

    if ($_POST[$field] <= 0 || is_float($_POST[$field])) {
        return 'Шаг ставки должен быть целым числом больше ноля';
    }
}

/**
 * Проверяет поле даты окончания торгов
 * @param string Поле даты
 * @return string Сообщение об ошибке
 */
function validate_date($field) {
    if (empty($_POST[$field])) {
        return 'Поле не заполнено';
    }

    if (!is_date_valid($_POST[$field])) {
        return 'Введите дату в формате ДД:ММ:ГГ';
    }
    if (strtotime($_POST[$field]) - time() + 3600 * 24 < 0) {
        return 'Торги должны длиться минимум 24 часа';
    }

}

/**
 * Осуществляет валидацию формы
 * @return array Массив с сообщениями об ошибках
 */
function validate_form () {
    $errors = [];
    $rules = [
        'lot-name' => function() {
            return validate_name('lot-name');
        },

        'message' => function() {
            return validate_message('message');
        },

        'lot-image' =>  function() {
            return validate_image('lot-image');
        },

        'lot-rate' =>  function() {
            return validate_rate('lot-rate');
        },

        'lot-step' =>  function() {
            return validate_step('lot-step');
        },

        'lot-date' =>  function() {
            return validate_date('lot-date');
        }
    ];

    foreach ($_POST as $key => $value) {
        if (isset($rules[$key])) {
            $rule = $rules[$key];
            $errors[$key] = $rule();
        }
    }

    foreach ($_FILES as $key => $value) {
        if (isset($rules[$key])) {
            $rule = $rules[$key];
            $errors[$key] = $rule();
        }
    }


    return array_filter($errors);

}

/**
 * Перемещает загруженное изображение в директорию проекта
 * @param string Поле файла
 */
function move_file($file) {
    $file_name = $file['name'];
    $file_path = __DIR__ . '/uploads/';
    $file_url = '/uploads/' . $file_name;
    move_uploaded_file($file['tmp_name'], $file_path . $file_name);
    return $file_url;
}

function add_new_lot($con, $data) {
    $lot_name = $data['lot-name'];
    $description = $data['message'];
    $lot_rate = settype($data['lot-rate'], 'integer');
    $lot_step = settype($data['lot-step'], 'integer');
    $lot_date = $data['lot-date'];
    $lot_image = move_file($_FILES['lot-image']);

    $lot_query = "
    INSERT INTO lots (name, description, start_cost, step, termination_date, img_link) VALUES ('$lot_name', '$description', $lot_rate, $lot_step, '$lot_date', '$lot_image')";

    $result = mysqli_query($con, $lot_query);

    if (!$result) {
        $error = mysqli_error($con);
        print("Ошибка MySQL: " . $error);
    }
}

/**
 * Возвращает значение поля формы после валидации
 * @param string Поле формы
 * @return string Значение поля
 */
function get_post_val($key) {
    return $_POST[$key] ?? '';
}
