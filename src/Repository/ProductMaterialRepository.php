<?php

namespace App\Repository;

use App\Entity\ProductMaterial;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<ProductMaterial>
 *
 * @method ProductMaterial|null find($id, $lockMode = null, $lockVersion = null)
 * @method ProductMaterial|null findOneBy(array $criteria, array $orderBy = null)
 * @method ProductMaterial[]    findAll()
 * @method ProductMaterial[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ProductMaterialRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ProductMaterial::class);
    }

//    /**
//     * @return ProductMaterial[] Returns an array of ProductMaterial objects
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

//    public function findOneBySomeField($value): ?ProductMaterial
//    {
//        return $this->createQueryBuilder('p')
//            ->andWhere('p.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
