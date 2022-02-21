<?php

namespace App\Repository;

use App\Data\SearchData;
use App\Entity\Targets;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Knp\Component\Pager\Pagination\PaginationInterface;
use Knp\Component\Pager\PaginatorInterface;

/**
 * @method Targets|null find($id, $lockMode = null, $lockVersion = null)
 * @method Targets|null findOneBy(array $criteria, array $orderBy = null)
 * @method Targets[]    findAll()
 * @method Targets[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TargetsRepository extends ServiceEntityRepository
{
    private PaginatorInterface $paginator;

    public function __construct(ManagerRegistry $registry, PaginatorInterface $paginator)
    {
        parent::__construct($registry, Targets::class);
        $this->paginator = $paginator;

    }

    /**
     * @param SearchData $search
     * @return PaginationInterface
     */
    public function findSearch(SearchData $search): PaginationInterface
    {
        $query = $this
            ->createQueryBuilder('t')
            ->select('c', 't')
            ->join('t.country', 'c');

        if (!empty($search->q)){
            $query = $query->andWhere('t.lastname LIKE :q')->setParameter('q', "%{$search->q}%");
        }

        if (!empty($search->country)){
            $query = $query->andWhere('c.id IN (:country)')->setParameter('country', $search->country);
        }

        $query = $query->getQuery();
        return $this->paginator->paginate(
            $query,
            $search->page,
            4,
        );
    }
    // /**
    //  * @return Targets[] Returns an array of Targets objects
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
    public function findOneBySomeField($value): ?Targets
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
