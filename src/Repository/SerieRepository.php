<?php

namespace App\Repository;

use App\Entity\Serie;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\Tools\Pagination\Paginator;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Serie>
 *
 * @method Serie|null find($id, $lockMode = null, $lockVersion = null)
 * @method Serie|null findOneBy(array $criteria, array $orderBy = null)
 * @method Serie[]    findAll()
 * @method Serie[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class SerieRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Serie::class);
    }

    public function save(Serie $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Serie $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }


//    public function findBestSeries(){
//            //recherche des meilleur serie avec commande DQL
//        $entityManager = $this->getEntityManager();
//
//        $dql = "SELECT s FROM App\Entity\Serie s
//                WHERE s.popularity > 100
//                AND s.vote > 8
//                ORDER BY s.popularity DESC ";
//
//        $query = $entityManager->createQuery($dql);
//
//        $query->setMaxResults(30);
//        $result = $query->getResult();
//
//        return $result;
//
//    }

    public function  findBestSeries(){
        //avec queryBuilder
        $queryBuilder = $this->createQueryBuilder('s');
        $queryBuilder->leftJoin('s.seasons', 'seas');//left join pour recuperer série sans saison  (si juste ça = 6 saison)
        $queryBuilder->addSelect('seas'); //o lui indique qu'on veut tout ce qui concerne les saisons
        $queryBuilder->andWhere('s.popularity > 100');
        $queryBuilder->andWhere('s.vote > 8');
        $queryBuilder->addOrderBy('s.popularity','DESC');

        $query = $queryBuilder->getQuery();
        $query->setMaxResults(30);

        $paginator = new Paginator($query);

        return $paginator;
    }





//    /**
//     * @return Serie[] Returns an array of Serie objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('s')
//            ->andWhere('s.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('s.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Serie
//    {
//        return $this->createQueryBuilder('s')
//            ->andWhere('s.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
