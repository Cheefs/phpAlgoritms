<?php

$prices = [
    [
        'price' => 21999,
        'shop_name' => 'Shop 1',
        'shop_link' => 'http://'
    ],
    [
        'price' => 21550,
        'shop_name' => 'Shop 2',
        'shop_link' => 'http://'
    ],
    [
        'price' => 21950,
        'shop_name' => 'Shop 2',
        'shop_link' => 'http://'
    ],
    [
        'price' => 21350,
        'shop_name' => 'Shop 2',
        'shop_link' => 'http://'
    ],
    [
        'price' => 21050,
        'shop_name' => 'Shop 2',
        'shop_link' => 'http://'
    ]
];

for($i = 0; $i < 1000; $i++) {
    $prices[] = [
        'price' =>  rand(0, 10000),
        'shop_name' => 'Shop '.rand(1, 10),
        'shop_link' => 'http://'
    ];
}


/**
 * 1. Получить число шагов для заданного алгоритма.
 *
 * Сложность алгоритма O(n^3) так как сложность складывается из вложенных циклов "for", и еще цикла "wile"
 * первым циклом пренебрежом, так как он незначительно влияет на конечный результат, и всегда имеел сложность 0(n)
 *
 * 2. Вычислить сложность алгоритма.
 *
 * Число шагов алгоритма 4, сперва мы получаем значение за сколько итераций мы отсортируем массив
 * далее мы прорабатываем каждую итерацию,
 * и в ней мы перебираем элементы массива,
 * далее мы в сравниваем по значению "цена" тепуший элмент с предидушими
 *
 * @param $elements
 * @return mixed
 */
function ShellSort($elements) {
    $k=0;
    $length = count($elements); // получаем размер нашего массива = 1005
    $gap[0] = (int) ($length / 2); // Берем и разбиваем его пополам  = 502

    // далее разбивется по половинам данное число, и складывается в массив шагов
    // т.е как я понял, сортировка массива произайдет за колличество шагов которые мы получим тут

    // 1  получение колличества шагов для сортировки
    while($gap[$k] > 1) { // O(n)
        $k++;
        $gap[$k] = (int)($gap[$k-1] / 2);
    }

    //  2 проходим по кажлому шагу
    for($i = 0; $i <= $k; $i++){  //  O(n)  Суммарная сложность алгоритма со всеми вложенными циклами получается O(n^3)
        $step = $gap[$i];

        //  3 начинаем перебор массива, с индекса равного текушему шагу
        for($j = $step; $j < $length; $j++) { //  O(n)
            $temp = $elements[$j]; // текущий элемент
            $p = $j - $step;
            // 4 сравниваем значение цены товаров,
            while($p >= 0 && $temp['price'] < $elements[$p]['price']) { //  O(n)
                $elements[$p + $step] = $elements[$p];
                $p = $p - $step;
            }
            $elements[$p + $step] = $temp;
        }
    }
    return $elements;
}
var_dump(ShellSort($prices));

/**
 * 3. *Реализовать функционал сортировки слиянием.
 * Изучал много реализаций алгоритма, и попытался воспроизвести наиболее коротко, надеюсь не потерял смысл
 * данного алгоритма
 *
 * @param array $arr
 * @return array
 */
function mergeSort(array $arr) {
    $count = count($arr);
    if ($count <= 1) {
        return $arr;
    }
    // Пока колличество элементов массива больше одного, мы постоянно
    // рекурсивно делим его на 2 части, чтоб потом делать сортировку слиянием
    $left  = array_slice($arr, 0, (int)($count/2));
    $right = array_slice($arr, (int)($count/2));

    $left = mergeSort($left);
    $right = mergeSort($right);

    return merge($left, $right);
}

/**
 * Делаем сортировку слиянием для разбитых ранее частей исходного массива
 * @param array $left
 * @param array $right
 * @return array
 */
function merge(array $left, array $right) {
    $result = [];

    while ( count($left) > 0 && count($right) > 0) {
        if ($left[0] < $right[0]) {
            $result [] = array_shift($left);
        } else {
            $result [] = array_shift($right);
        }
    }
    splice($result, $left);
    splice($result, $right);
    return $result;
}

function splice(&$arr, $replacement) {
    array_splice($arr, count($arr), 0, $replacement);
}

$testArr = [];
for($i = 0; $i < 1000; $i++) {
    $testArr[] = rand(0, 10000);
}

var_dump(mergeSort($prices));