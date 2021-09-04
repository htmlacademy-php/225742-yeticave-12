<?php
/**
 * Проверяет поле на наличие значения
 * @param string Поле
 * @return string Сообщение об ошибке
 */
function check_required_field($field) {
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
    $image = $_FILES[$image];
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
}

/**
 * Проверяет поле начальной цены
 * @param string Поле начальной цены
 * @return string Сообщение об ошибке
 */
function validate_num($field) {
    $validated_field = filter_input(INPUT_POST, $field, FILTER_VALIDATE_INT);

    if (empty($validated_field)) {
        return 'Поле не заполнено';
    }

    if ($validated_field === 0) {
        return 'Поле должно содержать значение больше ноля';
    }

    if ($validated_field === false) {
        return 'Следует использовать только цифры';
    }
}

/**
 * Проверяет поле даты окончания торгов
 * @param string Поле даты
 * @return string Сообщение об ошибке
 */
function validate_date($field) {
    $date = $_POST[$field];
    if (empty($date)) {
        return 'Поле не заполнено';
    }

    if (!is_date_valid($date)) {
        return 'Введите дату в формате ДД:ММ:ГГ';
    }

    if (strtotime($date) - time() < 0) {
        return 'Торги должны длиться минимум 24 часа';
    }
}

/**
 * Проверяет на существование введенный при регистрации адрес электронной почты пользователя
 * @param string Адрес
 * @param boolean Ресурс соединения
 * @return boolean Флаг существования адреса в БД
 */
function check_existing_email($email, $con) {
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
function validate_email($con, $field) {
    $validated_email = filter_input(INPUT_POST, $field, FILTER_VALIDATE_EMAIL);

    if (empty($validated_email)) {
        return 'Поле не заполнено';
    }

    if ($validated_email === false) {
        return 'Пожалуйста, введите корректный e-mail';
    }

    if (check_existing_email($validated_email, $con)) {
        return 'Указанный вами адрес электроннной почты уже занят';
    }
}

/**
 * Проверяет введенное значение пароля при регистрации
 * @param string Введенный пароль
 * @return string Сообщение об ошибке
 */
function validate_password($field) {
    $password = $_POST[$field];
    if (empty($password)) {
        return 'Поле не заполнено';
    }

    if (strlen($password) < 8) {
        return 'Поле должно содержать минимум 8 символов';
    }
}

/**
 * Проверяет введенное значение имени пользователя
 * @param string Введенное имя
 * @return string Сообщение об ошибке
 */
function validate_name($field) {
    $name = $_POST[$field];
    if (empty($name)) {
        return 'Поле не заполнено';
    }

    if (!preg_match('/[A-zА-яё-]/', $name)) {
        return 'Используйте только буквы';
    }
}

/**
 * Осуществляет валидацию формы
 * @return array Массив с сообщениями об ошибках
 */
function validate_form($con) {
    $errors = [];
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
            $errors[$key] = $rule($con);
        }
    }

    return array_filter($errors);
}
