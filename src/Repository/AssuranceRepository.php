<?php

namespace App\Repository;

use App\Entity\Assurance;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Assurance>
 *
 * @method Assurance|null find($id, $lockMode = null, $lockVersion = null)
 * @method Assurance|null findOneBy(array $criteria, array $orderBy = null)
 * @method Assurance[]    findAll()
 * @method Assurance[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class AssuranceRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Assurance::class);
    }

    public function save(Assurance $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Assurance $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function allAssurances()
    {
        return $this->createQueryBuilder('c')
            ->getQuery()
            ->getResult()
            ;
    }

    public function search(string $query): array
{
    $entityManager = $this->getEntityManager();

    $queryBuilder = $entityManager->createQueryBuilder();
    $queryBuilder->select('a')
        ->from(Assurance::class, 'a')
        ->where('a.nom LIKE :query')
        ->setParameter('query', '%'.$query.'%');
    $query = $queryBuilder->getQuery();

    return $query->getResult();
}


public function research(string $query): array
{
    $entityManager = $this->getEntityManager();

    $queryBuilder = $entityManager->createQueryBuilder();
    $queryBuilder->select('a')
        ->from(Assurance::class, 'a')
        ->where('a.region LIKE :query')
        ->setParameter('query', '%'.$query.'%');

    $query = $queryBuilder->getQuery();

    return $query->getResult();
}


    

//    /**
//     * @return Assurance[] Returns an array of Assurance objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('a')
//            ->andWhere('a.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('a.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Assurance
//    {
//        return $this->createQueryBuilder('a')
//            ->andWhere('a.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
