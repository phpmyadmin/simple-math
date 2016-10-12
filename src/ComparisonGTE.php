<?php
namespace SimpleMath;

class ComparisonGTE extends Comparison {

    protected function cmp($left, $right)
    {
        return $left >= $right;
    }
}
