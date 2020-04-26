<?php

namespace App\Repository;

use Doctrine\ORM\Query;
use App\Entity\Property;
use App\Entity\PropertyFilter;
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
     * Méthode qui récupère tous les biens non vendus
     * Elle utilise la fonction findSoldQuery
     * @return PRoperty[]
     */
    public function findAllVisible(PropertyFilter $filter) : array
    {
        $query = $this->findSoldQuery();

        if($filter->getMaxPrice())
        {
            $query = $query
                        ->andWhere('p.price <= :maxprice')
                        ->setParameter('maxprice', $filter->getMaxPrice());
        }

        if($filter->getMinSurface())
        {
            $query = $query
                        ->andWhere('p.surface >= :minsurface')
                        ->setParameter('minsurface', $filter->getMinSurface());
        }

        return $query
                    ->getQuery()
                    ->getResult();
    }

    /**
     * Méthode qui récupère les 4 derniers biens non vendus
     * Elle utilise la fonction findSoldQuery
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

    /**
     * Méthode qui créer une requête récupérant tous les biens non vendus (champ sold à false) 
     * Cette fonction est utilisé par les autres fonctions (permet de factoriser le code). Elle retourne un Querybuilder. 
     * @return QueryBuilder
     */
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
