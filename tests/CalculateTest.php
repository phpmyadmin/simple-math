<?php
/* vim: set expandtab sw=4 ts=4 sts=4: */
/**
 * Test for functions.
 *
 * @package PhpMyAdmin-test
 */


class EvaluateTest extends PHPUnit_Framework_TestCase
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
        );
    }

    /**
     * @dataProvider getVariableEquations
     */
    public function testEvaluateVariable($equation, $name, $variable, $result)
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
}
