<?php

namespace App\Repository;

use App\Entity\CategirieService;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<CategirieService>
 *
 * @method CategirieService|null find($id, $lockMode = null, $lockVersion = null)
 * @method CategirieService|null findOneBy(array $criteria, array $orderBy = null)
 * @method CategirieService[]    findAll()
 * @method CategirieService[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CategirieServiceRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, CategirieService::class);
    }

//    /**
//     * @return CategirieService[] Returns an array of CategirieService objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('c')
//            ->andWhere('c.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('c.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?CategirieService
//    {
//        return $this->createQueryBuilder('c')
//            ->andWhere('c.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
