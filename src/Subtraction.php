<?php
namespace SimpleMath;

class Subtraction extends Operator {

    protected $precidence = 4;

    public function operate(Stack $stack) {
        $left = $stack->pop()->operate($stack);
        $right = $stack->pop();
        $right = ($right ? $right->operate($stack) : 0);
        return $right - $left;
    }

}

