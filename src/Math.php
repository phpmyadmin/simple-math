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


/**
 * Core class of the library performing parsing and calculations.
 */
class Math {

    protected $variables = array();
    protected $stack = null;

    /**
     * Parses and executes given formula
     *
     * @param string $string Formula to process
     *
     * @return int
     */
    public function evaluate($string) {
        $this->parse($string);
        return $this->run();
    }

    /**
     * Parses given formula. The parsed formula is stored in
     * the class.
     *
     * @param string $string Formula to process
     *
     * @return void
     */
    public function parse($string) {
        $tokens = $this->tokenize($string);
        $output = new Stack();
        $operators = new Stack();
        foreach ($tokens as $token) {
            $expression = Expression::factory($token);
            if ($expression->isOperator()) {
                $this->parseOperator($expression, $output, $operators);
            } elseif ($expression->isParenthesis()) {
                $this->parseParenthesis($expression, $output, $operators);
            } else {
                $output->push($expression);
            }
        }
        while (($operator = $operators->pop())) {
            if ($operator->isParenthesis()) {
                throw new \RuntimeException('Mismatched Parenthesis');
            }
            $output->push($operator);
        }
        $this->stack = $output;
    }

    /**
     * Registers variable for use withing calculation
     *
     * @param string $name  Name of variable
     * @param int    $value Value of variable
     *
     * @return void
     */
    public function registerVariable($name, $value) {
        $this->variables[$name] = $value;
    }

    /**
     * Executes currently parsed formula with current variables
     *
     * @return int
     */
    public function run() {
        $stack = clone $this->stack;
        while (($operator = $stack->pop()) && $operator->isOperator()) {
            $value = $operator->operate($stack, $this->variables);
            if (!is_null($value)) {
                $stack->push(Expression::factory($value));
            }
        }
        return $operator->render();
    }

    protected function parseParenthesis(Expression $expression, Stack $output, Stack $operators) {
        if ($expression->isOpen()) {
            $operators->push($expression);
        } else {
            $clean = false;
            while (($end = $operators->pop())) {
                if ($end->isParenthesis()) {
                    $clean = true;
                    break;
                } else {
                    $output->push($end);
                }
            }
            if (!$clean) {
                throw new \RuntimeException('Mismatched Parenthesis');
            }
        }
    }

    protected function parseOperator(Expression $expression, Stack $output, Stack $operators) {
        $end = $operators->poke();
        if (!$end) {
            $operators->push($expression);
        } elseif ($end->isOperator()) {
            do {
                if ($expression->isLeftAssoc() && $expression->getPrecidence() <= $end->getPrecidence()) {
                    $output->push($operators->pop());
                } elseif (!$expression->isLeftAssoc() && $expression->getPrecidence() < $end->getPrecidence()) {
                    $output->push($operators->pop());
                } else {
                    break;
                }
            } while (($end = $operators->poke()) && $end->isOperator());
            $operators->push($expression);
        } else {
            $operators->push($expression);
        }
    }

    protected function tokenize($string) {
        $parts = preg_split(
            '(([0-9]*\.?[0-9]+|\+|-|\(|\)|\*|%|\/|:|\?|==|<=|>=|<|>|!=|&&|\|\|)|\s+)',
            $string,
            null,
            PREG_SPLIT_NO_EMPTY | PREG_SPLIT_DELIM_CAPTURE
        );
        $parts = array_map('trim', $parts);
        return $parts;
    }

}
