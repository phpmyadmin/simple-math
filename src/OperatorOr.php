<?php
namespace SimpleMath;

class OperatorOr extends Comparison {

    protected $precidence = 2;

    function cmp($left, $right)
    {
        return $left || $right;
    }
}
