<?php
namespace SimpleMath;

class Subtraction extends Operator {

    protected $precidence = 4;

    public function operate(Stack $stack, $variables=array()) {
        $left = $stack->pop()->operate($stack, $variables);
        $right = $stack->pop();
        $right = ($right ? $right->operate($stack, $variables) : 0);
        return $right - $left;
    }

}

