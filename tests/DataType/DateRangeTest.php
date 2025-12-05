<?php

namespace App\Tests\DataType;

use App\DataType\DateRange;
use PHPUnit\Framework\TestCase;

class DateRangeTest extends TestCase
{
    public function testIntersect()
    {
        $dateRange1 = new DateRange(
            new \DateTimeImmutable('2025-12-01'),
            new \DateTimeImmutable('2025-12-05'),
        );
        $dateRange2 = new DateRange(
            new \DateTimeImmutable('2025-12-03'),
            new \DateTimeImmutable('2025-12-07'),
        );

        $intersection = $dateRange1->intersect($dateRange2);

        $this->assertInstanceOf(DateRange::class, $intersection);
        $this->assertEquals($dateRange2->getFrom(), $intersection->getFrom(), 'From date should be the later');
        $this->assertEquals($dateRange1->getTo(), $intersection->getTo(), 'To date should be the earlier');
    }
}
