<?php

namespace App\Repository;

use App\Entity\Party;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\Tools\Pagination\Paginator;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Party>
 */
class PartyRepository extends ServiceEntityRepository
{
    public const int MAX_ITEMS_PER_PAGE = 10;

    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Party::class);
    }

    //    /**
    //     * @return Party[] Returns an array of Party objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('p')
    //            ->andWhere('p.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('p.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?Party
    //    {
    //        return $this->createQueryBuilder('p')
    //            ->andWhere('p.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }

    public function findAllOptimized(int $page): Paginator
    {
        $firstResult = ($page - 1) * self::MAX_ITEMS_PER_PAGE;

        $query = $this->createQueryBuilder('p')
            ->select('p', 't', 'a')
            ->leftJoin('p.type', 't')
            ->leftJoin('p.address', 'a')
            ->setFirstResult($firstResult)
            ->setMaxResults(self::MAX_ITEMS_PER_PAGE)
            ->getQuery()
        ;

        return new Paginator($query);
    }

    public function search(
        int $page,
        ?string $city,
        ?string $type,
        ?int $maxParticipants,
        ?bool $isFree,
        ?\DateTimeImmutable $date,
    ): Paginator {
        $firstResult = ($page - 1) * self::MAX_ITEMS_PER_PAGE;

        $qb = $this->createQueryBuilder('p')
            ->select('p', 't', 'a')
            ->leftJoin('p.type', 't')
            ->leftJoin('p.address', 'a')
        ;

        if ($city) {
            $qb->andWhere('LOWER(a.city) = :city')
                ->setParameter('city', strtolower($city))
            ;
        }

        if ($type) {
            $qb->andWhere('LOWER(t.name) = :type')
                ->setParameter('type', strtolower($type))
            ;
        }

        if ($maxParticipants) {
            $qb->andWhere('p.maxParticipants = :maxParticipants')
                ->setParameter('maxParticipants', $maxParticipants)
            ;
        }

        if (null !== $isFree) {
            $qb->andWhere('p.isFree = :isFree')
                ->setParameter('isFree', $isFree)
            ;
        }

        if ($date) {
            $qb->andWhere('p.date = :date')
                ->setParameter('date', $date)
            ;
        }

        $query = $qb
            ->setFirstResult($firstResult)
            ->setMaxResults(self::MAX_ITEMS_PER_PAGE)
            ->getQuery()
        ;

        return new Paginator($query);
    }

    public function findOptimized(?int $id): ?Party
    {
        if (null === $id) {
            return null;
        }

        return $this->createQueryBuilder('p')
            ->select('p', 't', 'a', 'participants', 'createdBy')
            ->leftJoin('p.type', 't')
            ->leftJoin('p.address', 'a')
            ->leftJoin('p.participants', 'participants')
            ->leftJoin('p.createdBy', 'createdBy')
            ->andWhere('p.id = :id')
            ->setParameter('id', $id)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
}
