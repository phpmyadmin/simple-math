<?php

namespace SimpleMath;

class Math {

    protected $variables = array();
    protected $stack = null;

    public function evaluate($string) {
        $this->parse($string);
        return $this->run();
    }

    public function parse($string) {
        $tokens = $this->tokenize($string);
        $output = new Stack();
        $operators = new Stack();
        foreach ($tokens as $token) {
            $expression = TerminalExpression::factory($token);
            if ($expression->isOperator()) {
                $this->parseOperator($expression, $output, $operators);
            } elseif ($expression->isParenthesis()) {
                $this->parseParenthesis($expression, $output, $operators);
            } else {
                $output->push($expression);
            }
        }
        while (($op = $operators->pop())) {
            if ($op->isParenthesis()) {
                throw new \RuntimeException('Mismatched Parenthesis');
            }
            $output->push($op);
        }
        $this->stack = $output;
    }

    public function registerVariable($name, $value) {
        $this->variables[$name] = $value;
    }

    public function run() {
        $stack = clone $this->stack;
        while (($operator = $stack->pop()) && $operator->isOperator()) {
            $value = $operator->operate($stack, $this->variables);
            if (!is_null($value)) {
                $stack->push(TerminalExpression::factory($value));
            }
        }
        return $operator->render();
    }

    protected function parseParenthesis(TerminalExpression $expression, Stack $output, Stack $operators) {
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

    protected function parseOperator(TerminalExpression $expression, Stack $output, Stack $operators) {
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
        $parts = preg_split('(([0-9]*\.?[0-9]+|\+|-|\(|\)|\*|\/|:|\?)|\s+)', $string, null, PREG_SPLIT_NO_EMPTY | PREG_SPLIT_DELIM_CAPTURE);
        $parts = array_map('trim', $parts);
        return $parts;
    }

}
