<?php
namespace SimpleMath;

class ComparisonLTE extends Comparison {

    protected function cmp($left, $right)
    {
        return $left <= $right;
    }
}
