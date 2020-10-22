<?php

namespace AppBundle\Repository;

/**
 * MeetingRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class MeetingRepository extends \Doctrine\ORM\EntityRepository
{


    public function findDateOrderDesc()
    {$query = $this->getEntityManager()
        ->createQuery("SELECT m FROM AppBundle:Meeting m 
         ORDER BY m.date DESC");
        return $result = $query->getResult();}

    public function findDateOrderASC()
    {$query = $this->getEntityManager()
        ->createQuery("SELECT m FROM AppBundle:Meeting m 
         ORDER BY m.date ASC");
        return $result = $query->getResult();}


    public function countMeeting()
    {
        {
            $query =$this->getEntityManager()
                ->createQuery('SELECT COUNT(m.id) FROM AppBundle:Meeting m');
            return  $result = $query->getSingleScalarResult();
        }
    }


    public function findEntitiesByString($str){
        return $this->getEntityManager()
            ->createQuery(
                'SELECT p
                FROM AppBundle:Meeting p
                WHERE p.titleMeeting LIKE :str'
            )
            ->setParameter('str', '%'.$str.'%')
            ->getResult();
    }

    public function myfindddMeeting($search)

    {
        $qb = $this->getEntityManager()
            ->createQuery("select c from AppBundle:Meeting c Where c.titleMeeting=:search")
            ->setParameter('search', $search);

        return $query = $qb->getResult();
    }
    public function FindAjax($search)
    {

        return $this->getEntityManager()
            ->createQuery('SELECT e FROM AppBundle:Meeting e 
        WHERE e.title LIKE :title')
            ->setParameter('title','%' .$search . '%')
            ->getResult();
    }
    public function FindByTitle($motcle){
        $query=$this->getEntityManager()
            ->createQuery("
            select e from AppBundle:Meeting e
            where e.title like :motcle")
            ->setParameter('motcle',$motcle.'%');
        return $query->getResult();
    }

    public function findDailyMeeting(){


        $query=$this->createQueryBuilder('m');
        $query->where("m.type=:type")->setParameter('type','Daily');
        return $query->getQuery()->getResult();
    }

    public function findReviewMeeting(){


        $query=$this->createQueryBuilder('m');
        $query->where("m.type=:type")->setParameter('type','Review');
        return $query->getQuery()->getResult();
    }
    public function findSprintMeeting(){


        $query=$this->createQueryBuilder('m');
        $query->where("m.type=:type")->setParameter('type','Sprint');
        return $query->getQuery()->getResult();
    }
    public function findRetrospectiveMeeting(){


        $query=$this->createQueryBuilder('m');
        $query->where("m.type=:type")->setParameter('type','Retrospective');
        return $query->getQuery()->getResult();
    }



    public function FindByType($type){
        $query=$this->getEntityManager()
            ->createQuery("
            select m from AppBundle:Meeting m
            where m.type like :type")
            ->setParameter('type',$type.'%');
        return $query->getResult();
    }

    public function Search($title){
        $query=$this->getEntityManager()
            ->createQuery("
            select m from AppBundle:Meeting m
            where m.title like :title")
            ->setParameter('title',$title.'%');
        return $query->getResult();
    }
}
