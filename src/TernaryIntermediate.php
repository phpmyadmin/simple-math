<?php
namespace SimpleMath;

class TernaryIntermediate extends TerminalExpression {

    public function operate(Stack $stack, $variables=array()) {
        throw new \RuntimeException('Mismatched ternary operator!');
    }

    public function getValues()
    {
        return $this->value;
    }

}
