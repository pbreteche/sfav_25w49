<?php

namespace App\DataType;

readonly class DateRange
{
    public function __construct(
      private \DateTimeImmutable $from,
      private \DateTimeImmutable $to,
    ) {
        if ($from > $to) {
            throw new \LogicException('"from" needs to be before "to"');
        }
    }

    public function getFrom(): \DateTimeImmutable
    {
        return $this->from;
    }

    public function getTo(): \DateTimeImmutable
    {
        return $this->to;
    }

    public function intersect(DateRange $dateRange): ?DateRange
    {
        try {
            return new DateRange(
                max($this->from, $dateRange->getFrom()),
                min ($this->to, $dateRange->getTo()),
            );
        } catch (\LogicException) {
            return null;
        }
    }
}
