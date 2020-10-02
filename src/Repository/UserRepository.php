<?php
declare(strict_types = 1);

namespace App\Repository;

use App\Component\User\NewTokenDto;
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

    /**
     * @param NewTokenDto $dto
     * @return \Doctrine\ORM\QueryBuilder
     *
     */
    public function updateToken(NewTokenDto $dto)
    {
        $qb = $this->createQueryBuilder('u');
        $q = $qb
            ->update('App\Entity\User', 'u')
            ->set('u.apiToken', '?1')
            ->set('u.until', '?2')
            ->where('u.login = ?3')
            ->setParameter(1, $dto->getToken())
            ->setParameter(2, $dto->getUntil())
            ->setParameter(3, $dto->getLogin())
            ->getQuery();
        $q->execute();
    }
}
