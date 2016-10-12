<?php
namespace SimpleMath;

class ComparisonEQ extends Comparison {

    protected function cmp($left, $right)
    {
        return $left == $right;
    }
}
