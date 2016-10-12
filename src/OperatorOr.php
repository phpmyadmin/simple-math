<?php
namespace SimpleMath;

class OperatorOr extends Comparison {

    protected $precidence = 7;

    function cmp($left, $right)
    {
        return $left || $right;
    }
}
