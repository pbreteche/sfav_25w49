<?php

namespace App\Repository;

use App\Entity\Tag;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Tag>
 */
class TagRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Tag::class);
    }

    /** @return string[] */
    public function findNamesStartingBy(string $value): array
    {
        return $this->createQueryBuilder('tag')
            ->select('tag.name')
            ->andWhere('tag.name LIKE :pattern')
            ->setParameter('pattern', $value.'%')
            ->getQuery()
            ->getSingleColumnResult();
    }
}
