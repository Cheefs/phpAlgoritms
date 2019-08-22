<?php

$connect = mysqli_connect("localhost", "root", "", "alg");

$query = "SELECT * FROM alg.nestet_seeds";

$result = mysqli_query($connect, $query);
$data = [];
while ($seed = mysqli_fetch_assoc($result)) {
    $data[$seed["level"]][$seed['left_element']] = $seed;
}

var_dump($data); die();

function renderTree($tree) {
    $str = '<ul>';
    if (is_array($tree)) {
        foreach ($tree as $k => $level) {
            $str .= '<li> level #'. $k ;
            $str .= renderChild($level, $k);
            $str .= '</li>';
        }
    }
    return $str.'</ul>';
}

function renderChild($level, $depth) {
    $str = '<ul>';

    if (is_array($level) ) {
        foreach ($level as $k => $child) {
            $str .= '<li>'. $child['name'];
            array_splice($level, 0, 1);
            $str .= renderChild($child['left_element'] +1, $depth + 1 );
            $str .= '</li>';
        }

    }
    $str .= "</ul>";
    return $str;
}

echo renderTree($data);