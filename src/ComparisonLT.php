<?php
namespace SimpleMath;

class ComparisonLT extends Comparison {

    protected function cmp($left, $right)
    {
        return $left < $right;
    }
}
