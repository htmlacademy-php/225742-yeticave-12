<?php

require_once 'init.php';

$args = array(
    'search' => FILTER_SANITIZE_SPECIAL_CHARS,
);


$page_data = array(
    'categories' => $categories
);

function search_lots($search, $con) {
    $now = date('Y-m-d H:m:s');

    $sql = "SELECT * FROM lots l
            JOIN categories c on l.category_id = c.id
            WHERE MATCH(title,description) AGAINST('{$search}*' IN BOOLEAN MODE) AND completion_date > '$now'";
    $res = mysqli_query($con, $sql);
    return mysqli_fetch_all($res, MYSQLI_ASSOC);
}

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $input = filter_input_array(INPUT_GET, $args);

    if ($input) {
        $page_data['search_value'] = $input['search'];
        $lots = search_lots($input['search'], $con);
//        echo var_dump($lots);
        if (!empty($lots)) {
            $page_data['lots'] = $lots;
        }
    } else {

    }
}

$page_content = include_template('search.php', $page_data);

$layout = [
    'title' => 'Вход',
    'categories' => $categories,
    'content' => $page_content
];

$page = include_template('layout.php', $layout);
echo $page;
