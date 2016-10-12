<?php
namespace SimpleMath;

class ComparisonEQ extends Comparison {

    function cmp($left, $right)
    {
        return $left == $right;
    }
}
