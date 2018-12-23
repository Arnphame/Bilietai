<?php

namespace App\Repository;

use App\Entity\TicketTime;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method TicketTime|null find($id, $lockMode = null, $lockVersion = null)
 * @method TicketTime|null findOneBy(array $criteria, array $orderBy = null)
 * @method TicketTime[]    findAll()
 * @method TicketTime[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TimeRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, TicketTime::class);
    }

    // /**
    //  * @return TicketTime[] Returns an array of TicketTime objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('t')
            ->andWhere('t.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('t.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?TicketTime
    {
        return $this->createQueryBuilder('t')
            ->andWhere('t.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
