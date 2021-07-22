<?php
/**
 * Форматирует цену лота в карточке
 * @param int Цена лота в числовом значении
 * @return string Итоговый формат цены в виде строки
 */
function get_cost($number) {
    if (ceil($number) > 1000) {
        $cost = number_format($number, 0, '', ' ');
        return (string)$cost . ' ₽';
    } else {
        return ceil($number);
    }
}

/**
 * Вычисляет оставшееся время лота
 * @param string Дата истечения лота
 * @return array Массив, первый ключ которого содержит часы, а второй минуты, оставшиеся до истечения лота
 */
    function get_time_in_hours($date) {
        $timestamp = strtotime($date) / 60;
        $currentTimestamp = floor(time() / 60);
        $lotTime = ['hours' => floor(($timestamp - $currentTimestamp) / 60), 'minutes' => ($timestamp - $currentTimestamp) % 60 ];
        return $lotTime;
    }
?>
