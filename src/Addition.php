<?php
namespace SimpleMath;

class Addition extends Operator {

    protected $precidence = 4;

    public function operate(Stack $stack) {
        return $stack->pop()->operate($stack) + $stack->pop()->operate($stack);
    }

}
