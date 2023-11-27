<?php
function check_existing_email(string $email):string | null {

    $sql = "SELECT * FROM users WHERE email = '".$email."'";
    $db_res = mysqli_query($GLOBALS['con'], $sql);
    if (!$db_res) {
        $error = mysqli_error($GLOBALS['con']);
        print("Ошибка MySQL: " . $error);
    }
    $res = mysqli_fetch_assoc($db_res);
    if ($res) {
        return 'Пользователь с таким e-mail уже зарегистрирован';
    }
    return null;
}

$validation_rules = Array(
    'lot-rate' => function($value) {
        if (is_float($value) || $value < 1) {
            return 'Значение должно быть целым числом больше 0';
        }
    },
    'lot-date' => function($value) {
        if (!is_date_valid($value)) {
            return 'Дата должна быть в формате "ГГГГ-ММ-ДД".';
        } else if (strtotime($value) - strtotime(date('Y-m-d')) < (60 * 60 * 24)) {
            return 'Дата завершения должна быть больше текущей даты, хотя бы на один день.';
        }
    },
    'lot-step' => function($value) {
        if (is_float($value) || $value < 1) {
            return 'Значение должно быть целым числом больше 0';
        }
    },
    'img' => function($file) {
        if (empty($file['name'])) {
            return 'Пожалуйста, прикрепите изображение лота.';
        } else if (!in_array(get_mime_type($file), Array('image/png', 'image/jpeg'))) {
            return 'Изображение должно быть в формате jpeg/jpg/png.';
        }
    },
    'email' => function($value) {
        if (strlen($value) == 0) {
            return 'Пожалуйста, введите e-mail';
        } else if (!filter_var($value, FILTER_VALIDATE_EMAIL)) {
            return 'Неверный формат e-mail.';
        } else {
            return true;
        }
    },
    'password' => function($value) {
        if (strlen($value) == 0) {
            return 'Пожалуйста, введите пароль';
        } elseif (strlen($value) < 8) {
            return 'Пароль должен быть больше 8 символов';
        };

        return true;
    },

    'name' => function($value) {
        if (strlen($value) == 0) {
            return 'Пожалуйста, введите ваше имя.';
        };

        return true;
    },
    'message' => function($value) {
        if (strlen($value) === 0) {
            return 'Пожалуйста, введите ваше имя.';
        };

        return true;
    },
    'lot-name' => function($value) {
        if (strlen($value) === 0) {
            return 'Пожалуйста, введите название лота.';
        }
    },
    'category' => function($value) {
        if (strlen($value) === 0) {
            return 'Пожалуйста, укажите категорию.';
        }
    }
);

function validate_fields(array $fields, array $rules): array {
    $errors = Array();

    foreach ($fields as $name => $value) {
        if (isset($rules[$name])) {
            $fn = $rules[$name];
            $result = $fn($value);

            if (gettype($result) == 'string') {
                $errors[$name] = $result;
            }
        }
    }

    return $errors;
}
