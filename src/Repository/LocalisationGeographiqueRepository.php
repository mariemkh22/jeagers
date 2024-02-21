<?php

namespace App\Repository;

use App\Entity\LocalisationGeographique;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<LocalisationGeographique>
 *
 * @method LocalisationGeographique|null find($id, $lockMode = null, $lockVersion = null)
 * @method LocalisationGeographique|null findOneBy(array $criteria, array $orderBy = null)
 * @method LocalisationGeographique[]    findAll()
 * @method LocalisationGeographique[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class LocalisationGeographiqueRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, LocalisationGeographique::class);
    }

//    /**
//     * @return LocalisationGeographique[] Returns an array of LocalisationGeographique objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('l')
//            ->andWhere('l.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('l.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?LocalisationGeographique
//    {
//        return $this->createQueryBuilder('l')
//            ->andWhere('l.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
