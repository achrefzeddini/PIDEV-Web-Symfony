<?php


namespace HuntKingdomBundle\Entity;

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
    /**
     * @ORM\OneToMany(targetEntity="HuntKingdomBundle\Entity\Commande", mappedBy="User")
     * @ORM\JoinColumn(name="commande_id",referencedColumnName="id")
     */
    private $Commande;
    public function __constructCommande()
    {
        $this->Commande = new ArrayCollection();
    }

    /**
     * @return mixed
     */
    public function getCommande()
    {
        return $this->Commande;
    }

    /**
     * @param mixed $Commande
     */
    public function setCommande($Commande)
    {
        $this->Commande = $Commande;
    }


    public function __construct()
    {
        parent::__construct();
        // your own logic
    }

    /**
     * @return string
     */
    public function getUsername()
    {
        return $this->username;
    }

    /**
     * @param string $username
     */
    public function setUsername($username)
    {
        $this->username = $username;
    }

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

}
