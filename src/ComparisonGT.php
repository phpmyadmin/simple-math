<?php
namespace SimpleMath;

class ComparisonGT extends Comparison {

    function cmp($left, $right)
    {
        return $left > $right;
    }
}
