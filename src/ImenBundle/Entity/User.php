<?php


namespace ImenBundle\Entity;


use Doctrine\Common\Collections\ArrayCollection;
use FOS\UserBundle\Model\User as BaseUser;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="fos_user")
 */
class User extends BaseUser
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /*
    public function __construct()
    {
        parent::__construct();
        // your own logic
    }

    */


    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     */
    public function setId($id)
    {
        $this->id = $id;
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