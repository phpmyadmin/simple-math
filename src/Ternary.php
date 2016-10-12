<?php
namespace SimpleMath;

class Ternary extends Operator {

    protected $precidence = 6;
    protected $leftAssoc = false;

    public function operate(Stack $stack, $variables=array()) {
        if (! $this->isOpen()) {
            $right = $stack->pop()->operate($stack, $variables);
            $left = $stack->pop()->operate($stack, $variables);
            return new TernaryIntermediate(array($left, $right));
        } else {
            $right = $stack->pop()->operate($stack, $variables);
            $left = $stack->pop()->operate($stack, $variables);
            if ($right instanceof TernaryIntermediate) {
                $right = $right->getValues();
            } else {
                throw new \RuntimeException('Mismatched ternary operator!');
            }
            if ($left) {
                return $right[0];
            } else {
                return $right[1];
            }
        }
    }

    public function isOpen() {
        return $this->value == '?';
    }

}


