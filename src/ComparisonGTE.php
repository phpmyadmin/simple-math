<?php
namespace SimpleMath;

class ComparisonGTE extends Comparison {

    function cmp($left, $right)
    {
        return $left >= $right;
    }
}
