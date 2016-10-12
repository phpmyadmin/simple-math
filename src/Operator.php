<?php
namespace SimpleMath;

abstract class Operator extends TerminalExpression {

    public function isOperator() {
        return true;
    }

}

