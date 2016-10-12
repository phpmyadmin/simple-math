<?php
namespace SimpleMath;

abstract class Comparison extends Operator {

    protected $precidence = 7;

    public function operate(Stack $stack, $variables=array())
    {
        $right = $stack->pop()->operate($stack, $variables);
        $left = $stack->pop()->operate($stack, $variables);
        return $this->cmp($left, $right) ? 1 : 0;
    }

    abstract function cmp($left, $right);
}
