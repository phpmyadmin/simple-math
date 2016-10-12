<?php
namespace SimpleMath;

class OperatorAnd extends Comparison {

    protected $precidence = 7;

    function cmp($left, $right)
    {
        return $left && $right;
    }
}

