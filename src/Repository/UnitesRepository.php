<?php

namespace App\Repository;

use App\Entity\Unites;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Unites>
 *
 * @method Unites|null find($id, $lockMode = null, $lockVersion = null)
 * @method Unites|null findOneBy(array $criteria, array $orderBy = null)
 * @method Unites[]    findAll()
 * @method Unites[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class UnitesRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Unites::class);
    }

    public function isInitesUsed($id) {
        $query = $this->getEntityManager()
            ->createQuery(
                'SELECT COUNT(e)
                FROM App\Entity\Quantites e
                WHERE e.unites = :id'
            )->setParameter('id', $id);
    
        return $query->getSingleScalarResult() > 0;
    }

    public function findBySearch($value)
    {
        return $this->createQueryBuilder('p')
            ->where('p.title LIKE :val')
            ->setParameter('val', '%' . $value . '%')
            ->orderBy('p.title', 'ASC')
            ->getQuery()
            ->getResult()
            ;
    }

    public function findAllSortedByName()
    {
        return $this->createQueryBuilder('c') 
            ->orderBy('c.un_libelle', 'ASC') 
            ->getQuery()
            ->getResult();
    }


//    /**
//     * @return Unites[] Returns an array of Unites objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('u')
//            ->andWhere('u.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('u.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Unites
//    {
//        return $this->createQueryBuilder('u')
//            ->andWhere('u.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
