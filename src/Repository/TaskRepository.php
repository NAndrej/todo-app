<?php

namespace App\Repository;

use App\Entity\Task;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

class TaskRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Task::class);
    }

    /**
     * @return Task[]
     */
    public function findAll()
    {
        $dql = "SELECT t
                FROM App\Entity\Task t 
                    LEFT JOIN App\Entity\User u
                        WITH t.user = u.id";

        $query = $this->getEntityManager()->createQuery($dql);
        
        return $query->execute();
    }

    /**
     * @return Task[]
     */
    public function searchAll(?string $searchParam)
    {
        $qb = $this->createQueryBuilder('t')
            ->where('t.text LIKE :searchParam')
            ->setParameter('searchParam', '%' . $searchParam . '%');
        
        $query = $qb->getQuery();
        return $query->execute();
    }
}