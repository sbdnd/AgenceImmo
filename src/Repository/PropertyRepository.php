<?php

namespace App\Repository;

use App\Entity\Property;
use Doctrine\ORM\QueryBuilder;
use PhpParser\Node\Expr\Cast\Array_;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\ORM\QueryBuilder as ORMQueryBuilder;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;

/**
 * @method Property|null find($id, $lockMode = null, $lockVersion = null)
 * @method Property|null findOneBy(array $criteria, array $orderBy = null)
 * @method Property[]    findAll()
 * @method Property[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PropertyRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Property::class);
    }

    /**
     * Undocumented function
     *
     * @return Property[]
     */
    public function findAllVisible() : array
    {
        return $this->findSoldQuery()
            ->getQuery()
            ->getResult()
        ;
    }
    /**
     * @return Property[]
     */
    public function findFourLatest() : array
    {
        return $this->findSoldQuery()
            ->setMaxResults(4)
            ->getQuery()
            ->getResult()
        ;
    }

    private function findSoldQuery(): QueryBuilder
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.sold = false');
    }

    // /**
    //  * @return Property[] Returns an array of Property objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('p.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Property
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
