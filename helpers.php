<?php

/**
 * Проверяет переданную дату на соответствие формату 'ГГГГ-ММ-ДД'
 *
 * Примеры использования:
 * is_date_valid('2019-01-01'); // true
 * is_date_valid('2016-02-29'); // true
 * is_date_valid('2019-04-31'); // false
 * is_date_valid('10.10.2010'); // false
 * is_date_valid('10/10/2010'); // false
 *
 * @param string $date Дата в виде строки
 *
 * @return bool true при совпадении с форматом 'ГГГГ-ММ-ДД', иначе false
 */
function is_date_valid(string $date) : bool {
    $format_to_check = 'Y-m-d';
    $dateTimeObj = date_create_from_format($format_to_check, $date);
    return $dateTimeObj !== false && !date_get_last_errors();
}

function get_mime_type(Array $file): string {
    $file_info = finfo_open(FILEINFO_MIME_TYPE);
    $file_name = $file['tmp_name'];

    return finfo_file($file_info, $file_name);
}

/**
 * Создает подготовленное выражение на основе готового SQL запроса и переданных данных
 *
 * @param $link mysqli Ресурс соединения
 * @param $sql string SQL запрос с плейсхолдерами вместо значений
 * @param array $data Данные для вставки на место плейсхолдеров
 *
 * @return mysqli_stmt Подготовленное выражение
 */
function db_get_prepare_stmt($link, $sql, $data = []) {
    $stmt = mysqli_prepare($link, $sql);

    if ($stmt === false) {
        $errorMsg = 'Не удалось инициализировать подготовленное выражение: ' . mysqli_error($link);
        die($errorMsg);
    }

    if ($data) {
        $types = '';
        $stmt_data = [];

        foreach ($data as $value) {
            $type = 's';

            if (is_int($value)) {
                $type = 'i';
            }
            else if (is_string($value)) {
                $type = 's';
            }
            else if (is_double($value)) {
                $type = 'd';
            }

            if ($type) {
                $types .= $type;
                $stmt_data[] = $value;
            }
        }

        $values = array_merge([$stmt, $types], $stmt_data);

        $func = 'mysqli_stmt_bind_param';
        $func(...$values);

        if (mysqli_errno($link) > 0) {
            $errorMsg = 'Не удалось связать подготовленное выражение с параметрами: ' . mysqli_error($link);
            die($errorMsg);
        }
    }

    return $stmt;
}

/**
 * Возвращает корректную форму множественного числа
 * Ограничения: только для целых чисел
 *
 * Пример использования:
 * $remaining_minutes = 5;
 * echo "Я поставил таймер на {$remaining_minutes} " .
 *     get_noun_plural_form(
 *         $remaining_minutes,
 *         'минута',
 *         'минуты',
 *         'минут'
 *     );
 * Результат: "Я поставил таймер на 5 минут"
 *
 * @param int $number Число, по которому вычисляем форму множественного числа
 * @param string $one Форма единственного числа: яблоко, час, минута
 * @param string $two Форма множественного числа для 2, 3, 4: яблока, часа, минуты
 * @param string $many Форма множественного числа для остальных чисел
 *
 * @return string Рассчитанная форма множественнго числа
 */
function get_noun_plural_form (int $number, string $one, string $two, string $many): string
{
    $number = (int) $number;
    $mod10 = $number % 10;
    $mod100 = $number % 100;

    switch (true) {
        case ($mod100 >= 11 && $mod100 <= 20):
            return $many;

        case ($mod10 > 5):
            return $many;

        case ($mod10 === 1):
            return $one;

        case ($mod10 >= 2 && $mod10 <= 4):
            return $two;

        default:
            return $many;
    }
}

/**
 * Подключает шаблон, передает туда данные и возвращает итоговый HTML контент
 * @param string $name Путь к файлу шаблона относительно папки templates
 * @param array $data Ассоциативный массив с данными для шаблона
 * @return string Итоговый HTML
 */
function include_template($name, array $data = []) {
    $name = 'templates/' . $name;
    $result = '';

    if (!is_readable($name)) {
        return $result;
    }

    ob_start();
    extract($data);
    require $name;

    $result = ob_get_clean();

    return $result;
}

/**
 * Форматирует цену
 * @param int|float $cost Цена
 * @return string Отформатированная цена
 */
function format_cost($cost): string {
    $normalized_cost = ceil($cost);
    $formatted_cost = $normalized_cost < 1000 ? $normalized_cost : number_format($normalized_cost, 0, '', ' ');
    return $formatted_cost . ' ₽';
}

function format_time($deadline)  {
    $now = time();
    $deadline_ts = strtotime($deadline);
    $hours_number = floor(($deadline_ts - $now) / 3600);
    $minutes_number = floor((($deadline_ts - $now) % 3600) / 60);
    $formatted_hours = $hours_number < 10 ? str_pad($hours_number, 2, "0", STR_PAD_LEFT) : $hours_number;
    $formatted_minutes = $minutes_number < 10 ? str_pad($minutes_number, 2, "0", STR_PAD_LEFT) : $minutes_number;

    return array($formatted_hours, $formatted_minutes);
}

/**
 * Сохраняет файл на сервере
 * @param array $file Элемент из $_FILES
 * @param string $dir_name Название директории, в которую следует переместить файл
 * @return string $url Путь до файла
 */
function save_file($file, $dir_name = 'uploads') {
    $name = $file['name'];
    $path = __DIR__ . '/' .$dir_name. '/';
    $url = '/' . $dir_name . '/' . $name;

    move_uploaded_file($file['tmp_name'], $path . $name);
    return $url;
}

/**
 * Выполняет sql-запрос, возвращающий данные в виде ассоциативного массива
 *
 * @param $con mysqli Ресурс соединения
 * @param $query string SQL запроc
 *
 * @return Array Массив с данными
 */
function get_data(mysqli $con, string $query):Array {
    $res = mysqli_query($con, $query);
    return mysqli_fetch_all($res, MYSQLI_ASSOC);
};

/**
 * Возвращает данные конкретного лота
 * @param $id int айдишник лота
 * @return array Данные лота
 */
function get_lot(int $id, mysqli $con):Array | null {
    $query = '
        SELECT
            l.id,
            title,
            name AS category,
            description,
            image_url,
            initial_cost,
            completion_date,
            creation_date
        FROM lots l
        JOIN categories c
                ON c.id = l.category_id 
                WHERE l.id = '.$id.'
    ';

    $res = mysqli_query($con, $query);
    return mysqli_fetch_assoc($res);
};

/**
 * Возвращает все активные лоты из БД
 * @return Array Массив с лотами
 */
function get_lots(mysqli $con):Array {
    $now = date('Y-m-d H:m:s');
    $query = "
        SELECT 
            l.id,
            name AS category,
            title,
            description,
            image_url,
            initial_cost,
            completion_date,
            creation_date
        FROM lots l
            JOIN categories c
                ON c.id = l.category_id 
        WHERE completion_date > '$now'
        ORDER BY creation_date DESC";
    return get_data($con, $query);
};

/**
 * Возвращает категории лотов из БД
 * @return Array Массив с категориями
 */
function get_categories(mysqli $con):Array {
    $query = 'SELECT * from categories';
    return get_data($con, $query);
};

