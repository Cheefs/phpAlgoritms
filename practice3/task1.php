<?php
/**
 * 1. Реализовать вывод меню на основе Clojure table.
*/

$connect = mysqli_connect("localhost", "root", "", "alg");

$query = "select * from alg.categories as c
inner join alg.category_links as cl on c.id_category = cl.child_id";

$result = mysqli_query($connect, $query);
$cats = [];
while ($cat = mysqli_fetch_assoc($result)) {
    $cats[$cat["level"]] [$cat["parent_id"]] = $cat;
}

function renderLevel($arr){
    $str = '<ul>';
    if (is_array($arr)) {
        foreach ($arr as $k => $level) {
            $str .= '<li> level #'. $k ;
            $str .= renderChild($level);
            $str .= '</li>';
        }

    }
    return $str.'</ul>';
}

function renderChild($level) {
    $str = '<ul>';
    if (is_array($level)) {
        foreach ($level as $k => $child) {
            $str .= '<li>'. $child['category_name'];
            array_splice($level, 0, 1);
            $str .= renderChild( $level );
            $str .= '</li>';
        }

    }
    $str .= "</ul>";
    return $str;
}

echo renderLevel($cats);