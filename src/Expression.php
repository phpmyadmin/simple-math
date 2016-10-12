<?php
/*
    Copyright (c) 2016 Michal Čihař <michal@cihar.com>

    This file is part of SimpleMath.

    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License as published by
    the Free Software Foundation; either version 2 of the License, or
    (at your option) any later version.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License along
    with this program; if not, write to the Free Software Foundation, Inc.,
    51 Franklin Street, Fifth Floor, Boston, MA 02110-1301 USA.
*/
namespace SimpleMath;

abstract class Expression {

    protected $value = '';
    protected $precidence = 0;
    protected $leftAssoc = true;

    public function __construct($value) {
        $this->value = $value;
    }

    public function getPrecidence() {
        return $this->precidence;
    }

    public function isLeftAssoc() {
        return $this->leftAssoc;
    }

    public function isOpen() {
        return false;
    }

    public static function factory($value) {
        if (is_numeric($value)) {
            return new Expressions\Number($value);
        } elseif (preg_match('/^\$?[a-z]+$/', $value)) {
            return new Expressions\Variable($value);
        }

        switch ($value) {
            case '+':
                return new Expressions\Addition($value);
            case '-':
                return new Expressions\Subtraction($value);
            case '*':
                return new Expressions\Multiplication($value);
            case '/':
                return new Expressions\Division($value);
            case '%':
                return new Expressions\Modulo($value);
            case '?':
            case ':':
                return new Expressions\Ternary($value);
            case '(':
            case ')':
                return new Expressions\Parenthesis($value);
            case '==':
                return new Expressions\ComparisonEQ($value);
            case '<':
                return new Expressions\ComparisonLT($value);
            case '>':
                return new Expressions\ComparisonGT($value);
            case '<=':
                return new Expressions\ComparisonLTE($value);
            case '>=':
                return new Expressions\ComparisonGTE($value);
            case '!=':
                return new Expressions\ComparisonNE($value);
            case '||':
                return new Expressions\OperatorOr($value);
            case '&&':
                return new Expressions\OperatorAnd($value);
        }

        throw new \RuntimeException('Undefined Value ' . $value);
    }

    abstract public function operate(Stack $stack, $variables=array());

    public function isOperator() {
        return false;
    }

    public function isParenthesis() {
        return false;
    }

    public function render() {
        return $this->value;
    }
}
