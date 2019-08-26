<?php
/**
 * Дано слово, состоящее только из строчных латинских букв. Проверить, является ли оно палиндромом.
 * При решении этой задачи нельзя пользоваться циклами.
 */

$palindromeWords = [ 'шалаш','поп', 'кук', 'топот', 'Deed', 'Nun', 'Noon', 'Level', 'Solos', 'Peep', 'Shahs', 'Sagas', 'Malayalam' ];
$noPalindrome = ['тест', 'свист', 'кот', 'компьютер', 'PC', 'phone', 'mouse', 'pen'];
foreach ($palindromeWords as $k => $word) {
    echo $k.'&nbsp;'.compare($word).'</br>';
}

echo '<hr>';

foreach ($noPalindrome as $k => $word) {
    echo $k.'&nbsp;'.compare($word).'</br>';
}

function compare( $word ) {
    $resultString = '';
    $rmpArrayOfWords =  preg_split('//u', $word, -1,PREG_SPLIT_NO_EMPTY);
    revert( array_reverse($rmpArrayOfWords), $resultString);

    return ( mb_strtolower($word) === mb_strtolower($resultString))? 'Полиндром' : 'НЕ полидром!' ;
}

function revert($words, &$string){
    if (!count($words)) return $words;
    $string .= array_shift( $words );
    return revert($words, $string );
}