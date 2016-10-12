<?php
namespace SimpleMath;

class ComparisonNE extends Comparison {

    function cmp($left, $right)
    {
        return $left != $right;
    }
}
