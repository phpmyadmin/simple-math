<?php
namespace SimpleMath;

class Variable extends TerminalExpression {

    public function operate(Stack $stack, $variables=array()) {
        return isset($variables[$this->value]) ? $variables[$this->value] : 0;
    }

}

