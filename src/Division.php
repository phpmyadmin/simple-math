<?php
namespace SimpleMath;

class Division extends Operator {

    protected $precidence = 5;

    public function operate(Stack $stack, $variables=array()) {
        $left = $stack->pop()->operate($stack, $variables);
        $right = $stack->pop()->operate($stack, $variables);
        return $right / $left;
    }

}
