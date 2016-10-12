<?php
namespace SimpleMath;

class Parenthesis extends TerminalExpression {

    protected $precidence = 6;

    public function operate(Stack $stack, $variables=array()) {
    }

    public function isParenthesis() {
        return true;
    }

    public function isOpen() {
        return $this->value == '(';
    }

}

