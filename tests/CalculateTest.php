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

use PHPUnit\Framework\TestCase;

/**
 * Test for functions.
 *
 * @package PhpMyAdmin-test
 */
class EvaluateTest extends TestCase
{
    /**
     * @dataProvider getEquations
     */
    public function testEvaluate($equation, $result)
    {
        $math = new SimpleMath\Math();
        $this->assertEquals(
            $result,
            $math->evaluate($equation)
        );
    }

    public function getEquations()
    {
        return array(
            array('1 + 2', 3),
            array('1 - 1', 0),
            array('-1', -1),
            array('2 * 3', 6),
            array('6 / 2', 3),
            array('2*2', 4),
            array('2 * (1 + 1)', 4),
            array('(1 + 1) * (2 + 2)', 8),
            array('(2 + 3) * 4', 20),
            array('1 + 2 * ((3 + 4) * 5 + 6)', 83),
            array('(1 + 2) * (3 + 4) * (5 + 6)', 231),
            array(
                '(1+69) * (5-1) * (6 * (5+2-3+(75 * (2+6)+75 * ' .
                ' (1+5+2+6+3-15)+5)) - (515-(35 * (51-2))))',
                1611120
            ),
            array('1 ? 10 : 20', 10),
            array('0 ? 10 : 20', 20),
            array('1 ? 0 : (0 ? 1 : 2)', 0),
            array('0 ? 0 : (1 ? 1 : 2)', 1),
            array('0 ? 0 : (0 ? 1 : 2)', 2),
            array('1 ? 0 : 0 ? 1 : 2', 0),
            array('0 ? 0 : 1 ? 1 : 2', 1),
            array('0 ? 0 : 0 ? 1 : 2', 2),
            array('10 == 20', 0),
            array('10 == 10', 1),
            array('10 != 20', 1),
            array('10 != 10', 0),
            array('10 < 20', 1),
            array('10 < 10', 0),
            array('10 <= 20', 1),
            array('10 <= 10', 1),
            array('20 > 20', 0),
            array('20 > 10', 1),
            array('20 >= 20', 1),
            array('20 >= 10', 1),
            array('1 == 1 ? 10 : 20', 10),
            array('1 || 2', 1),
            array('1 || 0', 1),
            array('0 || 0', 0),
            array('1 && 2', 1),
            array('1 && 0', 0),
            array('0 && 0', 0),
            array('2 % 2', 0),
            array('4 % 2', 0),
            array('4 % 3', 1),
        );
    }

    /**
     * @dataProvider getVariableEquations
     */
    public function testVariable($equation, $name, $variable, $result)
    {
        $math = new SimpleMath\Math();
        $math->registerVariable($name, $variable);
        $this->assertEquals(
            $result,
            $math->evaluate($equation)
        );
    }

    public function getVariableEquations()
    {
        return array(
            array('($a + 3) * 4', '$a', 4, 28),
            array('($a + 3) * 4', '$a', 1, 16),
            array('($a + $a) * 4', '$a', 5, 40),
            array('n + 1', 'n', 100, 101),
        );
    }

    public function testDifferentVariable()
    {
        $math = new SimpleMath\Math();

        $math->parse('n + 1');

        $math->registerVariable('n', 10);
        $this->assertEquals(11, $math->run());

        $math->registerVariable('n', 100);
        $this->assertEquals(101, $math->run());

        $math->registerVariable('n', -2);
        $this->assertEquals(-1, $math->run());

        $math->registerVariable('n', 0);
        $this->assertEquals(1, $math->run());
    }

    /**
     * @dataProvider gettextData
     */
    public function testGettext($equation, $expected)
    {
        $math = new SimpleMath\Math();
        $math->parse($equation);
        $values = array(0, 1, 2, 3, 4, 5, 10, 11, 100);
        foreach ($values as $key => $value) {
            $math->registerVariable('n', $value);
            $this->assertEquals($expected[$key], $math->run(), 'n=' . $value);
        }
    }

    public function gettextData()
    {
        return array(
            array(
                '(n != 1)',
                array(1, 0, 1, 1, 1, 1, 1, 1, 1),
            ),
            array(
                '(n==1) ? 0 : (n>=2 && n<=4) ? 1 : 2',
                array(2, 0, 1, 1, 1, 2, 2, 2, 2),
            ),
            array(
                '(n==0 ? 0 : n==1 ? 1 : n==2 ? 2 : n%100>=3 && n%100<=10 ? 3 : n%100>=11 ? 4 : 5)',
                array(0, 1, 2, 3, 3, 3, 3, 4, 5),
            ),
        );
    }

    /**
     * @dataProvider errorEquations
     */
    public function testErrors($equation)
    {
        $this->setExpectedException('RuntimeException');
        $math = new SimpleMath\Math();
        $math->evaluate($equation);
    }

    public function errorEquations()
    {
        return array(
            array('1 ? 2'),
            array('1 + (1 : 2)'),
            array('(1 + 2'),
            array('1 + 2)'),
            array('#'),
        );
    }
}
