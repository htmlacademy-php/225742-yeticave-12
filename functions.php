<?php function getCost($number) {
    if ($number > 1000) {
        $cost = number_format($number, 0, '', ' ');
    }
    return (string)$cost . ' ₽';
}
?>
