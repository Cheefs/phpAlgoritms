<?php
/**
 * сравнение итераторов
 * Сравнивал по разному и подключал файл с массивом большим, и как ниже видно использовал массив обектов,
 * и постоянно forEach лучше оказывался не значительно но лучше.
 *
 * Итераторы очень облегчают жизнь своими функциями, напримере тогоже DirectoryIterator
 * либо в случае с многомерными массивами, деют возможность за один цикл рекурсивно пройти его элементы
*/
#region Заполнение данных
$arr = array();

for($i = 0; $i < 100000; $i ++) {
    $obj = new StdClass();
    $obj->age = rand(0,10000);
    $obj->ts = rand(0,10000);
    $obj->df = rand(0,10000);
    $obj->gh = rand(0,10000);
    $obj->cc = rand(0,10000);
    $obj->jj = rand(0,10000);
    $obj->zz = rand(0,10000);
    $obj->xx = rand(0,10000);
    $obj->vvv = rand(0,10000);
    $arr [] = $obj;
}
#endregion



$start = microtime(true);

$iterator = new ArrayIterator($arr);


$count = 0;
foreach ($arr as $item) {
    $count += $item->age;
}

echo microtime(true) - $start.'<br>';

/// ========== php 7.4 ==================
// ForEach
//0.019301176071167
// ArrayIterator
//0.026386022567749

/// ========== php 5.6 ==================
// ForEach
//0.038810014724731
// ArrayIterator
//0.038145065307617
/// ========== php 5.2 ==================
// ForEach
//0.02365899086
// ArrayIterator
//0.0262498855591