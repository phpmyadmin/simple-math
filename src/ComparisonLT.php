<?php
namespace SimpleMath;

class ComparisonLT extends Comparison {

    function cmp($left, $right)
    {
        return $left < $right;
    }
}
