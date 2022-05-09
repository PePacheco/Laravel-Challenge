<?php

namespace Tests\Unit;

use App\Utilities\DateUtilities;
use PHPUnit\Framework\TestCase;

class DateUtilitiesTest extends TestCase
{
    public function testIsBetween18and65Correct() 
    {
        $date = '2000-01-01';
        $this->assertEquals(true, DateUtilities::isBetween18and65($date));
    }

    public function testIsBetween18and65LessThan18() 
    {
        $date = '2020-01-01';
        $this->assertEquals(false, DateUtilities::isBetween18and65($date));
    }

    public function testIsBetween18and65MoreThan65() 
    {
        $date = '1950-01-01';
        $this->assertEquals(false, DateUtilities::isBetween18and65($date));
    }
}
