<?php
namespace SimpleMath;

abstract class TerminalExpression {

    protected $value = '';

    public function __construct($value) {
        $this->value = $value;
    }

    public static function factory($value) {
        if (is_object($value) && $value instanceof TerminalExpression) {
            return $value;
        } elseif (is_numeric($value)) {
            return new Number($value);
        } elseif (preg_match('/^\$?[a-z]+$/', $value)) {
            return new Variable($value);
        } elseif ($value == '+') {
            return new Addition($value);
        } elseif ($value == '-') {
            return new Subtraction($value);
        } elseif ($value == '*') {
            return new Multiplication($value);
        } elseif ($value == '/') {
            return new Division($value);
        } elseif ($value == '%') {
            return new Modulo($value);
        } elseif (in_array($value, array('?', ':'))) {
            return new Ternary($value);
        } elseif (in_array($value, array('(', ')'))) {
            return new Parenthesis($value);
        } elseif ($value == '==') {
            return new ComparisonEQ($value);
        } elseif ($value == '<') {
            return new ComparisonLT($value);
        } elseif ($value == '>') {
            return new ComparisonGT($value);
        } elseif ($value == '<=') {
            return new ComparisonLTE($value);
        } elseif ($value == '>=') {
            return new ComparisonGTE($value);
        } elseif ($value == '!=') {
            return new ComparisonNE($value);
        } elseif ($value == '||') {
            return new OperatorOr($value);
        } elseif ($value == '&&') {
            return new OperatorAnd($value);
        }
        throw new \Exception('Undefined Value ' . $value);
    }

    abstract public function operate(Stack $stack, $variables=array());

    public function isOperator() {
        return false;
    }

    public function isParenthesis() {
        return false;
    }

    public function isTernary() {
        return false;
    }

    public function render() {
        return $this->value;
    }
}
