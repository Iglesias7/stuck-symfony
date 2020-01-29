<?php

namespace App\Repository;

use App\Entity\Posts;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method Posts|null find($id, $lockMode = null, $lockVersion = null)
 * @method Posts|null findOneBy(array $criteria, array $orderBy = null)
 * @method Posts[]    findAll()
 * @method Posts[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PostsRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Posts::class);
    }

    // /**
    //  * @return Posts[] Returns an array of Posts objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('p.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Posts
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */

    /**
     * @return Posts[] 
     */
    public function newest(): array
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.Title is not null')
            ->orderBy('p.Timestamp', 'DESC')
            ->getQuery()
            ->getResult()
        ;
    }


    /**
     * @return Posts[] 
     */
    public function getAll(): array
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.Title is not null')
            ->getQuery()
            ->getResult()
        ;
    }

    /**
     * @return Posts[] 
     */
    public function unanswered(): array
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.Title is not null and p.Accepted is null')
            ->orderBy('p.Timestamp', 'DESC')
            ->getQuery()
            ->getResult()
        ;
    }

    /**
     * @return Posts[] 
     */
    public function tag(): array
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.Title is not null and p.Tags.Count() > 0')
            ->orderBy('p.Timestamp', 'DESC')
            ->getQuery()
            ->getResult()
        ;
    }

     /**
     * @return Post[]
     */
    // public function getVote(): array
    // {
    //     $entityManager = $this->getEntityManager();

    //     $query = $entityManager->createQuery(
    //         'SELECT post.*, max_score
    //         FROM post, (
    //             SELECT parentid, max(score) max_score
    //             FROM (
    //                 SELECT post.postid, ifnull(post.parentid, post.postid) parentid, ifnull(sum(vote.updown), 0) score
    //                 FROM post LEFT JOIN vote ON vote.postid = post.postid
    //                 GROUP BY post.postid
    //             ) AS tbl1
    //             GROUP by parentid
    //         ) AS q1
    //         WHERE post.postid = q1.parentid
    //         ORDER BY q1.max_score DESC, timestamp DESC'
    //     )->setParameter('price', 5);

    //     return $query->getResult();
    // }

    public function getVote(): array
    {
        $conn = $this->getEntityManager()->getConnection();

        $sql = '
        SELECT post.*, max_score
        FROM post, (
            SELECT parentid, max(score) max_score
            FROM (
                SELECT post.postid, ifnull(post.parentid, post.postid) parentid, ifnull(sum(vote.updown), 0) score
                FROM post LEFT JOIN vote ON vote.postid = post.postid
                GROUP BY post.postid
            ) AS tbl1
            GROUP by parentid
        ) AS q1
        WHERE post.postid = q1.parentid
        ORDER BY q1.max_score DESC, timestamp DESC
            ';
        $stmt = $conn->prepare($sql);

        return $stmt->fetchAll();
    }
    
}
