<?php

namespace Tests\TimeOff;

use PHPUnit\Framework\TestCase;
use Pvo\TimeOff\Date;
use Pvo\TimeOff\Exceptions\InvalidDate;

class DateTest extends TestCase
{

    public function testDateRangeCanBeCorrectlyCreatedWithStartAndEndDate()
    {
        $start = '2018-12-12';
        $end = '2018-12-18';
        $dateRange = new Date($start, $end);
        $this->assertSame($dateRange->endsAt()->format('Y-m-d'), $end);
        $this->assertSame($dateRange->startsAt()->format('Y-m-d'), $start);
        $this->assertFalse($dateRange->isSingleDay());
        $this->assertFalse($dateRange->isHalfDay());
    }


    public function testDateRangeCanBeCorrectlyCreatedWithoutEndDate()
    {
        $start = '2018-12-12';
        $dateRange = new Date($start);
        $this->assertSame($dateRange->startsAt()->format('Y-m-d'), $start);
        $this->assertNull($dateRange->endsAt());
        $this->assertFalse($dateRange->isHalfDay());
        $this->assertTrue($dateRange->isSingleDay());
    }

    public function testDateRangeCannotBeCreatedWithStartGreaterThanEnd()
    {
        $this->expectException(InvalidDate::class);
        new Date('2018-12-12', '2018-11-11');
    }

    public function testADateCanBeMarkedHalfDayAndIsFirstHalfByDefault()
    {
        $date = new Date('2018-12-12', null, 'first');
        $this->assertTrue($date->isHalfDay());
        $this->assertTrue($date->isFirstHalf());
    }

    public function testADateCanBeMarkedSecondHalf()
    {
        $date = new Date('2018-12-12', null,'second');
        $this->assertTrue($date->isHalfDay());
        $this->assertFalse($date->isFirstHalf());
    }
}
