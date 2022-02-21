<?php

namespace App\Repository;

use App\Data\SearchData;
use App\Entity\Stashs;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Knp\Component\Pager\Pagination\PaginationInterface;
use Knp\Component\Pager\PaginatorInterface;

/**
 * @method Stashs|null find($id, $lockMode = null, $lockVersion = null)
 * @method Stashs|null findOneBy(array $criteria, array $orderBy = null)
 * @method Stashs[]    findAll()
 * @method Stashs[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class StashsRepository extends ServiceEntityRepository
{
    private PaginatorInterface $paginator;

    public function __construct(ManagerRegistry $registry, PaginatorInterface $paginator)
    {
        parent::__construct($registry, Stashs::class);
        $this->paginator = $paginator;
    }

    /**
     * @param SearchData $search
     * @return PaginationInterface
     */

    public function findSearch(SearchData $search): PaginationInterface
    {
        $query = $this
            ->createQueryBuilder('s')
            ->select('c', 's')
            ->join('s.country', 'c');

        if (!empty($search->q)){
            $query = $query->andWhere('s.alias LIKE :q')->setParameter('q', "%{$search->q}%");
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
    //  * @return Stashs[] Returns an array of Stashs objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('s.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Stashs
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
