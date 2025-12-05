<?php

namespace App\Tests\DataType;

use App\DataType\DateRange;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

class DateRangeTest extends TestCase
{
    public function testIntersect(): void
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

        $intersection = $dateRange2->intersect($dateRange1);

        $this->assertInstanceOf(DateRange::class, $intersection);
        $this->assertEquals($dateRange2->getFrom(), $intersection->getFrom(), 'From date should be the later');
        $this->assertEquals($dateRange1->getTo(), $intersection->getTo(), 'To date should be the earlier');

        $dateRange1 = new DateRange(
            new \DateTimeImmutable('2025-12-01'),
            new \DateTimeImmutable('2025-12-03'),
        );
        $dateRange2 = new DateRange(
            new \DateTimeImmutable('2025-12-05'),
            new \DateTimeImmutable('2025-12-07'),
        );

        $intersection = $dateRange1->intersect($dateRange2);

        $this->assertNull($intersection);
    }

    #[DataProvider('provideGetDays')]
    public function testGetDays($from, $to, $expected): void
    {
        $dateRange = new DateRange(
            new \DateTimeImmutable($from),
            new \DateTimeImmutable($to),
        );

        $days = $dateRange->getDays();

        $this->assertIsInt($days);
        $this->assertSame($expected, $days);
    }

    public static function provideGetDays(): array
    {
        return [
            ['2025-12-01', '2025-12-05', 5],
            ['2025-11-01', '2025-11-30', 30],
        ];
    }
}
