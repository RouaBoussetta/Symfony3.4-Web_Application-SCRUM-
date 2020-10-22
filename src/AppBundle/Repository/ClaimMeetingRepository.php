<?php

namespace AppBundle\Repository;

/**
 * ClaimMeetingRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class ClaimMeetingRepository extends \Doctrine\ORM\EntityRepository
{

    public function myfindClaim($id)

    {
        $qb = $this->getEntityManager()
            ->createQuery("select c from AppBundle:ClaimMeeting c Where c.user=:id")
            ->setParameter('id', $id);

        return $query = $qb->getResult();
    }



    public function count()
    {
        {
            $query =$this->getEntityManager()
                ->createQuery('SELECT COUNT(c.id) FROM AppBundle:ClaimMeeting c');
            return  $result = $query->getSingleScalarResult();
        }
    }


    public function countBySession($id)
    {
        {
            $query =$this->getEntityManager()
                ->createQuery('SELECT COUNT(c.id) FROM AppBundle:ClaimMeeting c Where c.user=:id')
                ->setParameter('id', $id);

            return  $result = $query->getSingleScalarResult();
        }
    }
}
