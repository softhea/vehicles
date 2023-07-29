<?php

namespace App\Repository;

use App\Entity\VehicleProperty;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<VehicleProperty>
 *
 * @method VehicleProperty|null find($id, $lockMode = null, $lockVersion = null)
 * @method VehicleProperty|null findOneBy(array $criteria, array $orderBy = null)
 * @method VehicleProperty[]    findAll()
 * @method VehicleProperty[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class VehiclePropertyRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, VehicleProperty::class);
    }

//    /**
//     * @return VehicleProperty[] Returns an array of VehicleProperty objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('vp')
//            ->andWhere('vp.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('vp.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?VehicleProperty
//    {
//        return $this->createQueryBuilder('vp')
//            ->andWhere('vp.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
