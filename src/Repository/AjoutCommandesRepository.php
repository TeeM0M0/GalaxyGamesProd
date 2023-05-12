<?php

namespace App\Repository;

use App\Entity\AjoutCommandes;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<AjoutCommandes>
 *
 * @method AjoutCommandes|null find($id, $lockMode = null, $lockVersion = null)
 * @method AjoutCommandes|null findOneBy(array $criteria, array $orderBy = null)
 * @method AjoutCommandes[]    findAll()
 * @method AjoutCommandes[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class AjoutCommandesRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, AjoutCommandes::class);
    }

    public function save(AjoutCommandes $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(AjoutCommandes $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

//    /**
//     * @return AjoutCommandes[] Returns an array of AjoutCommandes objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('a')
//            ->andWhere('a.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('a.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?AjoutCommandes
//    {
//        return $this->createQueryBuilder('a')
//            ->andWhere('a.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
