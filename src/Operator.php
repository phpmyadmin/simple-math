<?php
namespace SimpleMath;

abstract class Operator extends TerminalExpression {

    protected $precidence = 0;
    protected $leftAssoc = true;

    public function getPrecidence() {
        return $this->precidence;
    }

    public function isLeftAssoc() {
        return $this->leftAssoc;
    }

    public function isOperator() {
        return true;
    }

}

