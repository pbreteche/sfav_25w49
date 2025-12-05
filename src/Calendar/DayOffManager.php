<?php

namespace App\Calendar;

use App\Repository\HolidayRepository;

class DayOffManager
{
    public function __construct(
        private Calendar $calendar,
        private HolidayRepository $holidayRepository,
    ) {
    }

    public function isWorkedDay(string $employee, \DateTimeImmutable $date): bool
    {
        if (!$this->calendar->isWorkingDay($date)) {
            return false;
        }

        return !$this->holidayRepository->employeeIsOnHoliday($employee, $date);
    }
}
