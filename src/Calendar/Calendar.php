<?php

namespace App\Calendar;

use App\DataType\DateRange;

class Calendar
{
    public function __construct(
        private array $daysOff,
    ) {
    }

    public function isWorkingDay(\DateTimeInterface $date): bool
    {
        return !in_array((int) $date->format('N'), $this->daysOff);
    }

    public function countWorkingDays(DateRange $range): int
    {
        return array_reduce(
            iterator_to_array($range->each()),
            fn ($wd, \DateTimeImmutable $d) => $this->isWorkingDay($d) ? $wd + 1 : $wd,
            0
        );
    }
}
