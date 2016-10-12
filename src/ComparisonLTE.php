<?php
namespace SimpleMath;

class ComparisonLTE extends Comparison {

    function cmp($left, $right)
    {
        return $left <= $right;
    }
}
