<?php
namespace SimpleMath;

class Multiplication extends Operator {

    protected $precidence = 5;

    public function operate(Stack $stack, $variables=array()) {
        return $stack->pop()->operate($stack, $variables) * $stack->pop()->operate($stack, $variables);
    }

}

