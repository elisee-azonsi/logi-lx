<?php

namespace App\Repository;

use App\Data\Search;
use App\Entity\Employe;
use App\Entity\Shift;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\NonUniqueResultException;
use Doctrine\Persistence\ManagerRegistry;
use function Doctrine\ORM\QueryBuilder;

/**
 * @extends ServiceEntityRepository<Shift>
 *
 * @method Shift|null find($id, $lockMode = null, $lockVersion = null)
 * @method Shift|null findOneBy(array $criteria, array $orderBy = null)
 * @method Shift[]    findAll()
 * @method Shift[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ShiftRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Shift::class, Employe::class);
    }


   /**
     * @return Shift[] Returns an array of Shift objects
     */
    public function findByExampleField($value): array
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('s.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
       ;}

    /**
     * @throws NonUniqueResultException
     */
    public function findOneBySomeField($value): ?Shift
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }


    /**
     * @param Search $search
     * @return float|int|mixed|string
     */
    public function findSearch(Search $search): mixed
    {

        $query = $this
            ->createQueryBuilder('s');
        if(!empty($search->q)){
            $query = $query
                ->join('s.employe', 'e')
                ->orWhere('s.chantier LIKE :q')
                ->orWhere('s.date LIKE :q')
                ->orWhere('s.autre LIKE :q')
                ->orWhere('e.nom LIKE :q')
                ->orWhere('e.prenom LIKE :q')
                ->setParameter('q', "%{$search ->q}%");
        }

        return $query->getQuery()->getResult();
    }

    public function delete(Shift $article): void
    {
        $article->delete();
    }

}
