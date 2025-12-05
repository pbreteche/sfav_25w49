<?php

namespace App\Tests\Calendar;

use App\Calendar\Calendar;
use App\DataType\DateRange;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class CalendarTest extends KernelTestCase
{
    private static ?Calendar $calendar;

    public static function setUpBeforeClass(): void
    {
        self::bootKernel();
        $container = static::getContainer();
        self::$calendar = $container->get(Calendar::class);
    }

    public function testIsWorkingDay(): void
    {
        $this->assertTrue(
            self::$calendar->isWorkingDay(new \DateTimeImmutable('2025-12-05')),
            'Friday is a working day',
        );
        $this->assertFalse(
            self::$calendar->isWorkingDay(new \DateTimeImmutable('2025-12-06')),
            'Saturday is a non working day',
        );
    }

    public function testCountWorkingDays(): void
    {
        $this->assertEquals(10, self::$calendar->countWorkingDays(
            new DateRange(new \DateTimeImmutable('2025-12-01'), new \DateTimeImmutable('2025-12-14')),
        ));
    }
}
