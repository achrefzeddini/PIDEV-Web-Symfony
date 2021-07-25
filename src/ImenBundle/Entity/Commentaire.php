<?php

namespace ImenBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Commentaire
 *
 * @ORM\Table(name="commentaire")
 * @ORM\Entity(repositoryClass="ImenBundle\Repository\CommentaireRepository")
 */
class Commentaire
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;


    /*------------  RELATION ------------*/
    /**
     * @ORM\ManyToOne(targetEntity="ImenBundle\Entity\Annonce",inversedBy="commentaires")
     * @ORM\JoinColumn(name="annonce_id",referencedColumnName="id",onDelete="CASCADE")
     */
    private $annonce;

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



    /*------------  RELATION ONE TO ONE ------------*/

    /**
     * @ORM\ManyToOne(targetEntity="HuntKingdomBundle\Entity\User",inversedBy="commentaire")
     * * @ORM\JoinColumn(name="user_id",referencedColumnName="id",onDelete="CASCADE")
     */
    private $user;

    /**
     * @return mixed
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * @param mixed $user
     */
    public function setUser($user)
    {
        $this->user = $user;
    }

    /*
    public function __construct(){
        $this->user=new ArrayCollection();
    }
    */



    /*------------  FIN RELATION ONE TO ONE ------------*/



    /**
     * @var string
     *
     * @ORM\Column(name="champCommentaire", type="text")
     */
    private $champCommentaire;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="dateCommentaire", type="date")
     */
    private $dateCommentaire;


    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set champCommentaire
     *
     * @param string $champCommentaire
     *
     * @return Commentaire
     */
    public function setChampCommentaire($champCommentaire)
    {
        $this->champCommentaire = $champCommentaire;

        return $this;
    }

    /**
     * Get champCommentaire
     *
     * @return string
     */
    public function getChampCommentaire()
    {
        return $this->champCommentaire;
    }

    /**
     * Set dateCommentaire
     *
     * @param \DateTime $dateCommentaire
     *
     * @return Commentaire
     */
    public function setDateCommentaire($dateCommentaire)
    {
        $this->dateCommentaire = $dateCommentaire;

        return $this;
    }

    /**
     * Get dateCommentaire
     *
     * @return \DateTime
     */
    public function getDateCommentaire()
    {
        return $this->dateCommentaire;
    }


}

