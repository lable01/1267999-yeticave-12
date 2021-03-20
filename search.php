<?php
require_once('init.php');

if (!$con) {
    $content = include_template('404.php');
} else {
    $search = filter_input(INPUT_GET, 'search');
    $page = filter_input(INPUT_GET, 'page');
    $found_lots = search_lot($search, $con);
    foreach ($found_lots as $key => $value) {
        $date_completion = get_date($value['date_completion'])['times'];
        $lot_timer = get_date($value['date_completion'])['is_finishing'];
        $found_lots[$key]['date_completion'] = $date_completion;
        $found_lots[$key]['lot_timer'] = $lot_timer;
    }

    $count_found_lots = count($found_lots);
    $count_page = floor($count_found_lots / LIMIT_SAMPLE_LOT);
    for ($i = 1; $i <= $count_page; $i++) {
        $array_page[] = $i;
    }
    $main_content = include_template('search_template.php', ['found_lots' => $found_lots, 'search' => $search, 'count_found_lots' => $count_found_lots, 'LIMIT_SAMPLE_LOT' => LIMIT_SAMPLE_LOT, 'array_page' => $array_page]);
    $content = include_template('other_layout.php', ['content' => $main_content, 'categories' => $categories, 'title' => 'Вход', 'user' => $_SESSION]);
}

print($content);