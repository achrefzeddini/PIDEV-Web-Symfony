<?php


namespace GroupsBundle\Repository;

use Doctrine\ORM\EntityManager;
use GroupsBundle\Entity\Groups;

class GroupsRepository extends \Doctrine\ORM\EntityRepository
{
    function CountDQL(){
        $query=$this->getEntityManager()->createQuery('select count(c.id) as total from GroupsBundle:Groups c');
        return   $query->getResult()  ;
    }

}