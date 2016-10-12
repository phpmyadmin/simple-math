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
        }

        switch ($value) {
            case '+':
                return new Addition($value);
            case '-':
                return new Subtraction($value);
            case '*':
                return new Multiplication($value);
            case '/':
                return new Division($value);
            case '%':
                return new Modulo($value);
            case '?':
            case ':':
                return new Ternary($value);
            case '(':
            case ')':
                return new Parenthesis($value);
            case '==':
                return new ComparisonEQ($value);
            case '<':
                return new ComparisonLT($value);
            case '>':
                return new ComparisonGT($value);
            case '<=':
                return new ComparisonLTE($value);
            case '>=':
                return new ComparisonGTE($value);
            case '!=':
                return new ComparisonNE($value);
            case '||':
                return new OperatorOr($value);
            case '&&':
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
