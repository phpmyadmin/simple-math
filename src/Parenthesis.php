<?php
namespace SimpleMath;

class Parenthesis extends TerminalExpression {

    protected $precidence = 7;

    public function operate(Stack $stack, $variables=array()) {
    }

    public function getPrecidence() {
        return $this->precidence;
    }

    public function isParenthesis() {
        return true;
    }

    public function isOpen() {
        return $this->value == '(';
    }

}

