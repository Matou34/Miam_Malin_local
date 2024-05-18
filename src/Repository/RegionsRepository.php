<?php

namespace App\Repository;

use App\Entity\Regions;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Regions>
 *
 * @method Regions|null find($id, $lockMode = null, $lockVersion = null)
 * @method Regions|null findOneBy(array $criteria, array $orderBy = null)
 * @method Regions[]    findAll()
 * @method Regions[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class RegionsRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Regions::class);
    }

    public function isRegionUsed($id) {
        $query = $this->getEntityManager()
            ->createQuery(
                'SELECT COUNT(e)
                FROM App\Entity\Recettes e
                WHERE e.regions = :id'
            )->setParameter('id', $id);
    
        return $query->getSingleScalarResult() > 0;
    }

    public function findAllSortedByName()
    {
        return $this->createQueryBuilder('c') 
            ->orderBy('c.reg_libelle', 'ASC') 
            ->getQuery()
            ->getResult();
    }


//    /**
//     * @return Regions[] Returns an array of Regions objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('r')
//            ->andWhere('r.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('r.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Regions
//    {
//        return $this->createQueryBuilder('r')
//            ->andWhere('r.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
