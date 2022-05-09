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

    public function testIsBetween18and65Empty() 
    {
        $date = NULL;
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

    public function testDateFormattingYmd()
    {
        $date = '1989-03-21T01:11:13+00:00';
        $this->assertEquals('1989-03-21', DateUtilities::formattingDate($date));
    }

    public function testDateFormattingdmY()
    {
        $date = '15/09/1978';
        $this->assertEquals('1978-09-15', DateUtilities::formattingDate($date));
    }
}
