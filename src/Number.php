<?php
namespace SimpleMath;

class Number extends TerminalExpression {

    public function operate(Stack $stack, $variables=array()) {
        return $this->value;
    }

}
