<?php
/**
 * Проверяет поле на наличие значения
 * @param string Поле
 * @return string Сообщение об ошибке
 */
function check_required_field($field)
{
    $result = [
        'value' => $_POST[$field]
    ];

    if (empty($result['value'])) {
       return 'Поле не заполнено';
    }

    return $result;

}

/**
 * Проверяет поле загрузки файла
 * @param string Поле загрузки файла
 * @return string Сообщение об ошибке
 */
function validate_image($form_image)
{
    $image = $_FILES[$form_image];
    if ($image['error'] === 4) {
       return 'Добавьте изображение лота';
    }

    $image_name = $image['tmp_name'];

    if ($image_name) {
        $image_mime = mime_content_type($image_name);

        if ($image_mime !== 'image/jpeg' && $image_mime !== 'image/png') {
            return "Файл должен быть в формате jpeg или png";
        }
    }

    return $image;
}

/**
 * Проверяет поле начальной цены
 * @param string Поле начальной цены
 * @return string Сообщение об ошибке
 */
function validate_num($field)
{
    $result = [
        'value' => filter_input(INPUT_POST, $field, FILTER_VALIDATE_INT)
    ];

    if (is_null($result['value'])) {
        return 'Поле не заполнено';
    }

    if ($result['value'] === 0) {
        return 'Поле должно содержать значение больше ноля';
    }

    if ($result['value'] === false) {
        return 'Следует использовать только цифры';
    }

    return $result;

}

/**
 * Проверяет поле даты окончания торгов
 * @param string Поле даты
 * @return string Сообщение об ошибке
 */
function validate_date($field)
{
    $result = [
        'value' => $_POST[$field]
    ];

    if (empty($result['value'])) {
        return 'Поле не заполнено';
    }

    if (!is_date_valid($result['value'])) {
        return 'Введите дату в формате ДД:ММ:ГГ';
    }

    if (strtotime($result['value']) - time() < 0) {
        return 'Торги должны длиться минимум 24 часа';
    }

    return $result;

}

/**
 * Проверяет на существование введенный при регистрации адрес электронной почты пользователя
 * @param string Адрес
 * @param boolean Ресурс соединения
 * @return boolean Флаг существования адреса в БД
 */
function check_existing_email($email, $con)
{
    $query = 'SELECT * from users WHERE email = "' . $email .  '" LIMIT 1';
    $is_exist = false;
    if (get_data_item($con, $query)) {
        $is_exist = true;
    }
    return $is_exist;
}

/**
 * Проверяет введенное значение адреса электронной почты
 * @param boolean Ресурс соединения
 * @param string Адрес
 * @return string Сообщение об ошибке
 */
function validate_email($con, $field)
{
    $result = [
        'value' => filter_input(INPUT_POST, $field, FILTER_VALIDATE_EMAIL)
    ];

    if (empty($_POST[$field])) {
        return 'Поле не заполнено';
    }

    if ($result['value'] === false) {
        return 'Пожалуйста, введите корректный e-mail';
    }

    if (check_existing_email($result['value'], $con)) {
        return 'Указанный вами адрес электроннной почты уже занят';
    }

    return $result;
}

/**
 * Проверяет введенное значение пароля при регистрации
 * @param string Введенный пароль
 * @return string Сообщение об ошибке
 */
function validate_password($field)
{
    $result = [
        'value' => $_POST[$field]
    ];

    if (empty($result['value'])) {
        return 'Поле не заполнено';
    }

    if (strlen($result['value']) < 8) {
        return 'Поле должно содержать минимум 8 символов';
    }

    return $result;
}

/**
 * Проверяет введенное значение имени пользователя
 * @param string Введенное имя
 * @return string Сообщение об ошибке
 */
function validate_name($field)
{
    $result = [
        'value' => $_POST[$field]
    ];
    if (empty($result['value'])) {
        return 'Поле не заполнено';
    }

    if (!preg_match('/([А-Я]{1}[а-яё]{1,23}|[A-Z]{1}[a-z]{1,23})$/', $result['value'])) {
        return 'Используйте только буквы';
    }

    return $result;
}

/**
 * Осуществляет валидацию формы
 * @return array Массив с сообщениями об ошибках
 */
function validate_form($con)
{
    $data = [];
    $rules = [
        'email' => function($con) {
            return validate_email($con, 'email');
        },

        'password' => function() {
            return validate_password('password');
        },

        'name' => function() {
            return validate_name('name');
        },

        'lot-name' => function() {
            return check_required_field('lot-name');
        },

        'message' => function() {
            return check_required_field('message');
        },

        'lot-image' =>  function() {
            return validate_image('lot-image');
        },

        'lot-rate' =>  function() {
            return validate_num('lot-rate');
        },

        'lot-step' =>  function() {
            return validate_num('lot-step');
        },

        'lot-date' =>  function() {
            return validate_date('lot-date');
        }
    ];

    foreach ($_POST as $key => $value) {
        if (isset($rules[$key])) {
            $rule = $rules[$key];
            $check = $rule($con);
            if (is_array($check)) {
                $data[$key]['value'] = $check['value'];
            } else {
                $data[$key]['error'] = $check;
            }
        }
    }

    foreach ($_FILES as $key => $value) {
        if (isset($rules[$key])) {
            $rule = $rules[$key];
            $check = $rule();
            if (is_array($check)) {
                $data[$key]['value'] = $check;
            } else {
                $data[$key]['error'] = $check;
            }
        }
    }


    return array_filter($data);
}
