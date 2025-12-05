<?php

namespace App\Repository;

use App\Entity\Holiday;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Holiday>
 */
class HolidayRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Holiday::class);
    }

    public function employeeIsOnHoliday(string $employee, \DateTimeImmutable $date): bool
    {
        return !empty($this->createQueryBuilder('h')
            ->select('h.id')
            ->andWhere('h.startAt <= :date')
            ->andWhere('h.endAt >= :date')
            ->setParameter('date', $date)
            ->getQuery()
            ->getResult());
    }
}
