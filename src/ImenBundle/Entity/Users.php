<?php

namespace ImenBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * Users
 *
 * @ORM\Table(name="users")
 * @ORM\Entity(repositoryClass="ImenBundle\Repository\UsersRepository")
 */
class Users
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;


    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }


    /*------------  RELATION ONE TO MANY ------------*/
    /**
     * @ORM\OneToMany(targetEntity="ImenBundle\Entity\Annonce",mappedBy="user")
     * * @ORM\JoinColumn(name="annonce_id",referencedColumnName="id")
     */
    private $annonce;

    public function __construct(){
        $this->annonce=new ArrayCollection();
    }

    /**
     * @return mixed
     */
    public function getAnnonce()
    {
        return $this->annonce;
    }

    /**
     * @param mixed $annonce
     */
    public function setAnnonce($annonce)
    {
        $this->annonce = $annonce;
    }
    /*------------  RELATION ------------*/




}

