<?php

namespace App\Repository;

use App\Entity\Post;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Post|null find($id, $lockMode = null, $lockVersion = null)
 * @method Post|null findOneBy(array $criteria, array $orderBy = null)
 * @method Post[]    findAll()
 * @method Post[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PostRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Post::class);
    }

    // /**
    //  * @return Post[] Returns an array of Post objects
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
    public function findOneBySomeField($value): ?Post
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */

    public function findByProjet($rows){
        return $this->createQueryBuilder('p')
            ->join('p.category', 'c')
            ->andWhere('c.name = :val')
            ->setParameter('val', "projet")
            ->setMaxResults($rows)
            ->getQuery()
            ->getResult()
        ;
    }
    
    public function findByDeveloppement($rows){
        return $this->createQueryBuilder('p')
            ->join('p.category', 'c')
            ->andWhere('c.name = :val')
            ->setParameter('val', "developpement")
            ->setMaxResults($rows)
            ->getQuery()
            ->getResult()
        ;
    }

    public function findByActualite($rows){
        return $this->createQueryBuilder('p')
            ->join('p.category', 'c')
            ->andWhere('c.name = :val')
            ->setParameter('val', "actualite")
            ->orderBy('p.createdAT', 'DESC')
            ->setMaxResults($rows)
            ->getQuery()
            ->getResult()
        ;
    }

    public function findByCategory($category){
        return $this->createQueryBuilder('p')
            ->join('p.category', 'c')
            ->andWhere('c.name = :val')
            ->setParameter('val', $category)
            ->getQuery()
            ->getResult()
        ;
    }

    public function findByPostCategory($rows,$category){
        return $this->createQueryBuilder('p')
            ->join('p.category', 'c')
            ->andWhere('c.name = :val')
            ->setParameter('val', $category)
            ->orderBy('p.createdAT', 'DESC')
            ->setMaxResults($rows)
            ->getQuery()
            ->getResult()
        ;
    }

    // public function findByCatRow($rows,$category){
    //     return $this->createQueryBuilder('p')
    //         ->join('p.category', 'c')
    //         ->andWhere('c.name = :val')
    //         ->setParameter('val', $category)
    //         ->orderBy('p.createdAT', 'DESC')
    //         ->setMaxResults($rows)
    //         ->getQuery()
    //         ->getResult()
    //     ;
    // }

    // public function findByMaxDate(){
    //     return $this->createQueryBuilder('p')
    //         ->join('p.category', 'c')
    //         ->select(expr()->maxmax('p.createdAT'))
    //         ->andWhere('c.name = :val')
    //         ->setParameter('val', 'actualite')
    //         ->getQuery()
    //         ->getResult()
    //     ;
    // }
}
