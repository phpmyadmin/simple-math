<?php
namespace SimpleMath;

class Addition extends Operator {

    protected $precidence = 4;

    public function operate(Stack $stack, $variables=array()) {
        return $stack->pop()->operate($stack, $variables) + $stack->pop()->operate($stack, $variables);
    }

}
