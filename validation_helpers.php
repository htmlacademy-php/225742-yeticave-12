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
       $result['error'] = 'Поле не заполнено';
       return $result;
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
    $result = [
        'value' => $_FILES[$form_image]
    ];

    if ($result['value']['error'] === 4) {
       $result['error'] = 'Добавьте изображение лота';
       return $result;
    }

    $image_name = $result['value']['tmp_name'];

    if ($image_name) {
        $image_mime = mime_content_type($image_name);

        if ($image_mime !== 'image/jpeg' && $image_mime !== 'image/png') {
            $result['error'] = "Файл должен быть в формате jpeg или png";
            return $result;
        }
    }

    return $result;
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

    if (empty($_POST[$field]) && $_POST[$field] !== '0') {
        $result['error'] = 'Поле не заполнено';
        return $result;
    }

    if ($result['value'] === 0) {
        $result['error'] = 'Поле должно содержать значение больше ноля';
        return $result;
    }


    if ($result['value'] === false) {
        $result['error'] = 'Следует использовать только цифры';
        return $result;
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
        $result['error'] = 'Поле не заполнено';
        return $result;
    }

    if (!is_date_valid($result['value'])) {
        $result['error'] = 'Введите дату в формате ДД:ММ:ГГ';
        return $result;
    }

    if (strtotime($result['value']) - time() < 0) {
        $result['error'] = 'Торги должны длиться минимум 24 часа';
        return $result;
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
function validate_sign_up_email($con, $field)
{
    $result = [
        'value' => filter_input(INPUT_POST, $field, FILTER_VALIDATE_EMAIL)
    ];

    if (empty($_POST[$field])) {
        $result['error'] = 'Поле не заполнено';
        return $result;
    }

    if ($result['value'] === false) {
        $result['error'] = 'Пожалуйста, введите корректный e-mail';
        return $result;
    }

    if (check_existing_email($result['value'], $con)) {
        $result['error'] = 'Указанный вами адрес электроннной почты уже занят';
        return $result;
    }

    return $result;
}

function validate_sign_in_email($con, $field)
{
    $result = [
        'value' => filter_input(INPUT_POST, $field, FILTER_VALIDATE_EMAIL)
    ];

    if (empty($_POST[$field])) {
        $result['error'] = 'Поле не заполнено';
        return $result;
    }

    if ($result['value'] === false) {
        $result['error'] = 'Пожалуйста, введите корректный e-mail';
        return $result;
    }

    if (check_existing_email($result['value'], $con) === false) {
        $result['error'] = 'Пользователя с таким адресом электронной почты нет';
        return $result;
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
        $result['error'] =  'Поле не заполнено';
        return $result;
    }

    if (strlen($result['value']) < 8) {
        $result['error'] =  'Поле должно содержать минимум 8 символов';
        return $result;
    }

    return $result;
}

function check_user_password($password, $email, $con)
{
    $password_hash = password_hash($password, PASSWORD_DEFAULT);
    $query = 'SELECT * from users WHERE email = "' . $email .  '" LIMIT 1';
    $user = get_data_item($con, $query);
    $user_password_hash = $user['password'];
    $is_verified = false;
    if (password_verify($password, $user_password_hash)) {
        $is_verified = true;
    }
    return $is_verified;
}


function validate_sign_in_password($con, $field)
{
    $result = [
        'value' => $_POST[$field]
    ];

    if (empty($result['value'])) {
        $result['error'] =  'Поле не заполнено';
        return $result;
    }

    if (strlen($result['value']) < 8) {
        $result['error'] =  'Поле должно содержать минимум 8 символов';
        return $result;
    }

    if (check_user_password($result['value'], $_POST['email'], $con) === false) {
        $result['error'] =  'Неверный пароль';
        return $result;
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
        $result['error'] = 'Поле не заполнено';
        return $result;
    }

    if (!preg_match('/([А-Я]{1}[а-яё]{1,23}|[A-Z]{1}[a-z]{1,23})$/', $result['value'])) {
        $result['error'] =  'Используйте только буквы';
        return $result;
    }

    return $result;
}

