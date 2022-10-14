<?php

namespace App\Repository;

use App\Entity\RecipeParticipation;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<RecipeParticipation>
 *
 * @method RecipeParticipation|null find($id, $lockMode = null, $lockVersion = null)
 * @method RecipeParticipation|null findOneBy(array $criteria, array $orderBy = null)
 * @method RecipeParticipation[]    findAll()
 * @method RecipeParticipation[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class RecipeParticipationRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, RecipeParticipation::class);
    }

    public function add(RecipeParticipation $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(RecipeParticipation $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

//    /**
//     * @return RecipeParticipation[] Returns an array of RecipeParticipation objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('r')
//            ->andWhere('r.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('r.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?RecipeParticipation
//    {
//        return $this->createQueryBuilder('r')
//            ->andWhere('r.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
