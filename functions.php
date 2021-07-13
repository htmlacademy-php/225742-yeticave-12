<?php function getCost($number) {
    if ($number > 1000) {
        $cost = number_format($number, 0, '', ' ');
    }
    return (string)$cost . ' ₽';
}

    function getTimeInHours($date) {
        $timestamp = strtotime($date) / 60;
        $currentTimestamp = floor(time() / 60);
        $lotTime = ['hours' => floor(($timestamp - $currentTimestamp) / 60), 'minutes' => ($timestamp - $currentTimestamp) % 60 ];
        return $lotTime;
    }
?>
