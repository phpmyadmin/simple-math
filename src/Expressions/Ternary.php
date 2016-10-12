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
namespace SimpleMath\Expressions;

class Ternary extends \SimpleMath\Expression {

    protected $precidence = 1;
    protected $leftAssoc = false;

    public function isOperator() {
        return true;
    }

    public function operate(\SimpleMath\Stack $stack, $variables=array()) {
        if (! $this->isOpen()) {
            $right = $stack->pop()->operate($stack, $variables);
            $left = $stack->pop()->operate($stack, $variables);
            return new TernaryIntermediate(array($left, $right));
        } else {
            $right = $stack->pop()->operate($stack, $variables);
            $left = $stack->pop()->operate($stack, $variables);
            if ($right instanceof TernaryIntermediate) {
                $right = $right->getValues();
            } else {
                throw new \RuntimeException('Mismatched ternary operator!');
            }
            if ($left) {
                return $right[0];
            } else {
                return $right[1];
            }
        }
    }

    public function isOpen() {
        return $this->value == '?';
    }
}
