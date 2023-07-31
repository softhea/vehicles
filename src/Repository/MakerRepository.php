<?php
declare(strict_types=1);

namespace App\Repository;

use App\Entity\Maker;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Maker>
 *
 * @method Maker|null find($id, $lockMode = null, $lockVersion = null)
 * @method Maker|null findOneBy(array $criteria, array $orderBy = null)
 * @method Maker[]    findAll()
 * @method Maker[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class MakerRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Maker::class);
    }

    /**
    * @return Maker[]
    */
    public function findByTypeId(int $typeId): array
    {
        return $this->createQueryBuilder('m')
            ->select('m', 'v')
            ->leftJoin('m.vehicles', 'v')
            ->andWhere('v.type = :type_id')
            ->setParameter('type_id', $typeId)
            ->orderBy('m.id', 'ASC')
            ->getQuery()
            ->getResult();
    }

//    public function findOneBySomeField($value): ?Maker
//    {
//        return $this->createQueryBuilder('m')
//            ->andWhere('m.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
