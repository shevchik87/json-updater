<?php

namespace App\Repository;

use App\Entity\Document;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use PhpParser\Comment\Doc;

/**
 * @method Document|null find($id, $lockMode = null, $lockVersion = null)
 * @method Document|null findOneBy(array $criteria, array $orderBy = null)
 * @method Document[]    findAll()
 * @method Document[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class DocumentRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Document::class);
    }


    public function publish(string $id)
    {
        $qb = $this->createQueryBuilder('d');
        $q = $qb
            ->update('App\Entity\Document', 'd')
            ->set('d.status', '?1')
            ->set('d.modifyAt', '?2')
            ->where('d.id = ?3')
            ->setParameter(1, Document::STATUS_PUBLISHED)
            ->setParameter(2, new \DateTime())
            ->setParameter(3, $id)
            ->getQuery();
        $q->execute();
    }
}
