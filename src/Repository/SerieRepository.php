<?php

namespace App\Repository;

use App\Entity\Serie;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\Tools\Pagination\Paginator;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Serie>
 */
class SerieRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Serie::class);
    }

    //    /**
    //     * @return Serie[] Returns an array of Serie objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('s')
    //            ->andWhere('s.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('s.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?Serie
    //    {
    //        return $this->createQueryBuilder('s')
    //            ->andWhere('s.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }

    public function getOnlyBestSeries(): array {
        // DQL Request
        $query = "
            SELECT s FROM App\Entity\Serie s
            WHERE s.popularity < 50
            AND s.vote < 5
            ORDER BY s.popularity DESC
        ";
        $q = $this->getEntityManager()->createQuery($query);
        $q->setMaxResults(3);
        return $q->getResult();
    }

    public function getOnlyBestSeriesDQL(): array {
        // QueryBuilder Request
        $q = $this->createQueryBuilder('s');
        $q->andWhere('s.popularity < 50');
        $q->andWhere('s.vote < 5');
        $q->orderBy('s.popularity', 'DESC');

        $q->setMaxResults(3);

        return $q->getQuery()->getResult();
    }

    public function getSerieWithSeasons(int $id) {
        return $this->createQueryBuilder('s')
            ->addSelect('seasons')
            ->leftJoin('s.seasons', 'seasons')
            ->where('s.id = :id')
            ->setParameter('id', $id)
            ->getQuery()
            ->getOneOrNullResult();
    }

    public function getSeriesWithSeasons(int $offset) {
        $q = $this->createQueryBuilder('s')
            ->addSelect('seasons')
            ->leftJoin('s.seasons', 'seasons')
            ->setMaxResults(12)
            ->setFirstResult($offset)
            ->getQuery();

        return new Paginator($q);




    }
    
}
