<?php

namespace App\Repository;

use App\Entity\Product;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

class ProductRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Product::class);
    }

    public function findByStatusAndCreatedAtLessThan(string $status, \DateTimeInterface $createdAt)
    {
        $qb = $this->createQueryBuilder('p');

        return $qb->Where(
                $qb->expr()->andX()
                    ->add($qb->expr()->eq('p.status', ':status'))
                    ->add($qb->expr()->lt('p.createdAt', ':createdAt'))
            )
            ->setParameters(['status'=> $status, 'createdAt' => $createdAt])
            ->orderBy('p.createdAt', 'asc')
            ->getQuery()
            ->getResult();
    }
}
