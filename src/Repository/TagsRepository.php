<?php

namespace App\Repository;

use App\Entity\Tags;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Tags>
 *
 * @method Tags|null find($id, $lockMode = null, $lockVersion = null)
 * @method Tags|null findOneBy(array $criteria, array $orderBy = null)
 * @method Tags[]    findAll()
 * @method Tags[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TagsRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Tags::class);
    }

    public function isTagUsed($id) {
        $query = $this->getEntityManager()
            ->createQuery(
                'SELECT COUNT(r)
                FROM App\Entity\Recettes r
                JOIN r.recette_tags t
                WHERE t.id = :id'
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
            ->orderBy('c.ta_libelle', 'ASC') 
            ->getQuery()
            ->getResult();
    }


//    /**
//     * @return Tags[] Returns an array of Tags objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('t')
//            ->andWhere('t.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('t.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Tags
//    {
//        return $this->createQueryBuilder('t')
//            ->andWhere('t.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
