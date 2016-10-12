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
            array('(2 + 3) * 4', 20),
            array('1 + 2 * ((3 + 4) * 5 + 6)', 83),
            array('(1 + 2) * (3 + 4) * (5 + 6)', 231),
        );
    }

    /**
     * @dataProvider getVariableEquations
     */
    public function testEvaluateVariable($equation, $variable, $result)
    {
        $math = new SimpleMath\Math();
        $math->registerVariable('a', $variable);
        $this->assertEquals(
            $result,
            $math->evaluate($equation)
        );
    }

    public function getVariableEquations()
    {
        return array(
            array('($a + 3) * 4', 4, 28),
            array('($a + $a) * 4', 5, 40),
        );
    }
}
