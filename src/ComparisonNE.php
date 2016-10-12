<?php
namespace SimpleMath;

class ComparisonNE extends Comparison {

    protected function cmp($left, $right)
    {
        return $left != $right;
    }
}
