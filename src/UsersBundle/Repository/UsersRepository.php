<?php


namespace UsersBundle\Repository;

use Doctrine\ORM\EntityManager;
use UsersBundle\Entity\User;

class UsersRepository extends \Doctrine\ORM\EntityRepository
{
    function CountUsersDQL()
    {
        $query = $this->getEntityManager()->createQuery('select count(c.id) as totalUser from UsersBundle:User c');
        return $query->getResult();
    }

    function CountBannedDQL()
    {
        $query = $this->getEntityManager()->createQuery('select count(c.id) as totalBanned from UsersBundle:User c where c.enabled=0');
        return $query->getResult();
    }

}