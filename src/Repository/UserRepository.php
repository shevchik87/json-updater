<?php

namespace App\Repository;

use App\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method User|null find($id, $lockMode = null, $lockVersion = null)
 * @method User|null findOneBy(array $criteria, array $orderBy = null)
 * @method User[]    findAll()
 * @method User[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class UserRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, User::class);
    }

    /**
     * @param string $value
     * @return User|null
     * @throws \Doctrine\ORM\NonUniqueResultException
     */
    public function findByToken(string $value): ?User
    {
        return $this->createQueryBuilder('u')
            ->andWhere('u.apiToken = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
            ;
    }

    /**
     * @param string $value
     * @return User|null
     * @throws \Doctrine\ORM\NonUniqueResultException
     */
    public function findByUserName(string $value): ?User
    {
        return $this->createQueryBuilder('u')
            ->andWhere('u.login = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
            ;
    }
}
