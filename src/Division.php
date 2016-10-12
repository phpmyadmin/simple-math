<?php
namespace SimpleMath;

class Division extends Operator {

    protected $precidence = 5;

    public function operate(Stack $stack) {
        $left = $stack->pop()->operate($stack);
        $right = $stack->pop()->operate($stack);
        return $right / $left;
    }

}
