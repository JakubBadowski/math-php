<?php

namespace Math\NumericalAnalysis\NumericalIntegration;

class SimpsonsRuleTest extends \PHPUnit_Framework_TestCase
{
    public function testapproximatePolynomial()
    {
        // f(x)                            = x² + 2x + 1
        // Antiderivative F(x)             = (1/3)x³ + x² + x
        // Indefinite integral over [0, 3] = F(3) - F(0) = 21

        $expected = 21;

        // h           denotes the size of subintervals, or equivalently, the
        //                 distance between two points
        // ζ₁, ζ₂, ... denotes the max of the fourth derivative of f(x) on
        //                 interval 1, 2, ...
        // f'(x)    = 2x + 2
        // f''(x)   = 2
        // f'''(x)  = 0
        // f''''(x) = 0
        // ζ        = f''''(x) = 0
        // Error    = O(h^5 * ζ) = 0

        $tol = 0;

        // Approximate with: (0, 1), (1.5, 6.25) and (3, 16)
        $x = SimpsonsRule::approximate([[0, 1], [1.5, 6.25], [3, 16]]);
        $this->assertEquals($expected, $x, '', $tol);

        // Same test as above but with points not sorted to test sorting works
        $x = SimpsonsRule::approximate([[1.5, 6.25], [3, 16], [0, 1]]);
        $this->assertEquals($expected, $x, '', $tol);
    }

    public function testNotCoordinatesException()
    {
        // An array doesn't have precisely two numbers (coordinates)
        $this->setExpectedException('\Exception');
        SimpsonsRule::approximate([[0,0], [1,2,3], [2,2]]);
    }

    public function testNotEnoughArraysException()
    {
        // There are not enough arrays in the input
        $this->setExpectedException('\Exception');
        SimpsonsRule::approximate([[0,0]]);
    }

    public function testNotAFunctionException()
    {
        // Two arrays share the same first number (x-component)
        $this->setExpectedException('\Exception');
        SimpsonsRule::approximate([[0,0], [0,5], [1,1]]);
    }

    public function testSubintervalsNotEvenException()
    {
        // There are not even even number of subintervals, or
        // equivalently, there are not an add number of points
        $this->setExpectedException('\Exception');
        SimpsonsRule::approximate([[0,0], [4,4], [2,2], [6,6]]);
    }

    public function testNonConstantSpacingException()
    {
        // There is not constant spacing between points
        $this->setExpectedException('\Exception');
        SimpsonsRule::approximate([[0,0], [3,3], [2,2]]);
    }
}
