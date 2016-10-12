<?php
namespace SimpleMath;

class OperatorAnd extends Comparison {

    protected $precidence = 2;

    protected function cmp($left, $right)
    {
        return $left && $right;
    }
}

