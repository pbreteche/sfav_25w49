<?php

declare(strict_types=1);

namespace App\Tests\Calendar;

use App\Calendar\DayOffManager;
use App\Repository\HolidayRepository;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class DayOffManagerTest extends WebTestCase
{
    public function testSomething(): void
    {
        $holidayRepositoryMock = $this->createMock(HolidayRepository::class);
        $holidayRepositoryMock->expects($this->once())
            ->method('employeeIsOnHoliday')
            ->with('John Doe', $this->equalTo(new \DateTimeImmutable('2025-12-01')))
            ->willReturn(true)
        ;

        $container = static::getContainer();
        $container->set(HolidayRepository::class, $holidayRepositoryMock);

        $dayOffManager = $container->get(DayOffManager::class);

        $isWorking = $dayOffManager->isWorkedDay('John Doe', new \DateTimeImmutable('2025-12-01'));

        $this->assertFalse($isWorking);
    }
}
