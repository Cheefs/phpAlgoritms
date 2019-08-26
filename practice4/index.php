<?php

$str = '(x+42)^2+7*y-z';

/**
 *                                              (+)
 *                                        (pow)      (-)
 *                                      (+)   2   (*)   z
 *                                    x   42     7  4
 *
*/

/**
* @property string $right
* @property string $left
* @property string $value
 * @property string $weight
*/
class Node {
    public $left = null;
    public $value;
    public $right = null;
}

/**
 * @property Node $tree
 * @property array $operators
 * @property array $priority
*/
class MathTree {
    private $tree = null;
    private $operators = ['+', '-', '*', '/', '^'];
    private $value = 0;

    private $priority = [
        '^' => 5,
        '*' => 4,
        '/' => 3,
        '-' => 2,
        '+' => 0,
    ];

    public function __construct($str) {
        $this->buildTree($str);
    }

    private function isOperator($item) {
        return in_array($item, $this->operators);
    }


    private function isBrackets($item){
        return ($item === '(' || $item === ')');
    }

    private function buildTree($str) {
        $root = null;
        if (strlen($str)) {
            $root = new Node();
            $min = $this->getMinPriority($str);

            $root->value = $min;

            if (is_array($str)) {
                $root->left = $str[0]? $this->buildTree($str[0]) : null;
                $root->right = $str[1]? $this->buildTree($str[1]) : null;
            }

            $this->tree = $root;
        }
        return $this->tree;
    }

    private function isValue($value) {
       return preg_match('/\d/', $value);
    }

    private function getMinPriority(&$str) {
        $bc = 0; // счетчик скобок
        $min = null; /// минимальный приоритет
        $idx = null; /// позиция в строке
        $minSymbol = $str;
        if (strlen($str)) {
            for ($i = 0; $i < strlen($str); $i++ ) {
                $bc += $this->isBrackets($str[$i])? 1 : 0;
                if ( $bc % 2 === 0 && $this->isOperator($str[$i]) && (is_null($min) || $min > $this->priority[ $str[$i] ]) ) {
                    $min = $this->priority[ $str[$i] ];
                    $idx = $i;
                }
            }

            if ( is_null($idx) && is_null($min) ) {
                if (preg_match('/\(|\)/', $str)) {
                    $str = preg_replace('/\(|\)/', '', $str);
                    return $this->getMinPriority($str);
                }
            } else {
                $minSymbol = $str[$idx];
                $str[$idx] = ';';
                $str = explode(';', $str);
            }
        }
        return $minSymbol;
    }

    public function printTree() {
         $this->render($str, $this->tree);
        return '<ul>'. $str . '</ul>';
    }

    /**
     * не закончен вывод, а ветках запинается изза рекурсии, буду еще править
     * @param $tree
     * @param $str
     * @return string
     */
    private function render(&$str, $tree) {
        if ( $tree ) {
            $str .= '<li>'. $tree->value;
            $this->getFullBranch( $str, $tree->left);
            $this->getFullBranch($str, $tree->right);

            $str .='</li>';
        }
        return $str;
    }

    private function getFullBranch(&$str, $branch) {
        $str .= '<ul>';

        echo '<hr>';
        if ($branch) {
            $str .= '<li>'. $branch->value;
            if (!is_null($branch->left)) {
                $this->getFullBranch($str, $branch->left);
            }

            if (!is_null($branch->rigth)) {
                $this->getFullBranch($str, $branch->rigth);
            }

            $str .='</li>';
        }

        $str .= '</ul>';
        return $str;
    }

    /**
     *  ФУНКЦИЯ НЕ ДОРАБОТАННА, ЕЩЕ НЕ РЕАЛИЗОВАН ПОДСЧЕТ
     */
    public function calcTree() {
        return $this->calculate($this->tree);
    }

    /**
     * Рекурсивный подсчет, еще не доделан
     * @param $tree
     * @return float|int
     */
    private function calculate($tree) {
        if (!is_null($tree)) {
            $operator = $tree->value;
            if ($this->isOperator($operator)) {
                $left = $this->calculate($tree->left);
                $right = $this->calculate($tree->rigth);

                $this->value = $this->mathOperations($operator, $left, $right);
            } else {
                return $tree->value;
            }
        }
        return $this->value;
    }


    /**
     * Разбор по операциям
     * @param string $operator
     * @param $left
     * @param $right
     * @return float|int
     */
    private function mathOperations(string $operator, $left, $right) {
        $safe = function ($value) {
            return $value?? 0;
        };
        switch ($operator){
            case "+":
                return $safe($left) + $safe($right);
            case "-":
                return $safe($left) - $safe($right);
            case "*":
                $left = $left? $left : 1;
                $right = $right? $right : 1;
                return $left * $right;
            case "/":
                if ($right !== 0) {
                    return $left / $right;
                }
                return $left;
            case "^":
                if ($right === 0) {
                    return 1;
                } else if ($right < 0) {
                    return 1 / $left ** $right;
                }
                return $left ** $right;
            default:
                return 0;
        }
    }
}

$myTree = new MathTree($str);

echo $myTree->printTree();