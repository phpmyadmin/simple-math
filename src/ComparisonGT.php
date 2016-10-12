<?php
namespace SimpleMath;

class ComparisonGT extends Comparison {

    protected function cmp($left, $right)
    {
        return $left > $right;
    }
}
