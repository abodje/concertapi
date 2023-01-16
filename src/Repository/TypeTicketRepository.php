<?php

namespace App\Repository;

use App\Entity\TypeTicket;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<TypeTicket>
 *
 * @method TypeTicket|null find($id, $lockMode = null, $lockVersion = null)
 * @method TypeTicket|null findOneBy(array $criteria, array $orderBy = null)
 * @method TypeTicket[]    findAll()
 * @method TypeTicket[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TypeTicketRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, TypeTicket::class);
    }

    public function save(TypeTicket $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(TypeTicket $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }


    public function apiFindAll(): array
    {
        return $this->createQueryBuilder('t')
            ->select('t.id as idtypeticket', 't.designation as designationtypeticket', 't.description as descriptiontypeticket', 't.price as pricetypeticket', 't.statutticket as statuttypeticket ','t.nombretotal as nombretotaltypeticket','w.id as idevent','w.designation as designationevent','w.description as descriptionevent','w.statutevent as statutevent','w.image as imageevent','w.codeevent as codeevent','w.dateCreation as dateCreationevent')
            ->innerJoin('t.typeticketperconcert','w')
            ->getQuery()
            ->getResult()
        ;
    }
//    /**
//     * @return TypeTicket[] Returns an array of TypeTicket objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('t')
//            ->andWhere('t.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('t.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?TypeTicket
//    {
//        return $this->createQueryBuilder('t')
//            ->andWhere('t.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
