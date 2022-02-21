<?php

namespace App\Repository;

use App\Data\SearchData;
use App\Entity\Agents;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Knp\Component\Pager\Pagination\PaginationInterface;
use Knp\Component\Pager\PaginatorInterface;

/**
 * @method Agents|null find($id, $lockMode = null, $lockVersion = null)
 * @method Agents|null findOneBy(array $criteria, array $orderBy = null)
 * @method Agents[]    findAll()
 * @method Agents[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class AgentsRepository extends ServiceEntityRepository
{
    private PaginatorInterface $paginator;

    public function __construct(ManagerRegistry $agents, PaginatorInterface $paginator)
    {
        parent::__construct($agents, Agents::class);
        $this->paginator = $paginator;
    }

    /**
     * @param SearchData $search
     * @return PaginationInterface
     */
    public function findSearch(SearchData $search): PaginationInterface
    {
        $query = $this
            ->createQueryBuilder('a')
            ->select('c', 'a')
            ->select('s', 'a')
            ->join('a.country', 'c')
            ->join('a.skills', 's');

        if (!empty($search->q)){
            $query = $query->andWhere('a.lastname LIKE :q')->setParameter('q', "%{$search->q}%");
        }

        if (!empty($search->country)){
            $query = $query->andWhere('c.id IN (:country)')->setParameter('country', $search->country);
        }

        if (!empty($search->skill)){
            $query = $query->andWhere('s.id IN (:skill)')->setParameter('skill', $search->skill);
        }

        $query = $query->getQuery();
        return $this->paginator->paginate(
            $query,
            $search->page,
            4
        );
    }
}