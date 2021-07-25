<?php

namespace ImenBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * Annonce
 *
 * @ORM\Table(name="annonce")
 * @ORM\Entity(repositoryClass="ImenBundle\Repository\AnnonceRepository")
 */
class Annonce
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;



    /*------------  RELATION MANY TO ONE ------------*/
    /**
     * @ORM\ManyToOne(targetEntity="HuntKingdomBundle\Entity\User",inversedBy="annonce")
     * @ORM\JoinColumn(name="user_id",referencedColumnName="id",onDelete="CASCADE" )
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



    /*------------  FIN RELATION MANY TO ONE------------*/


    /*------------  RELATION ONE TO MANY ------------*/
    /**
     * @ORM\OneToMany(targetEntity="ImenBundle\Entity\Commentaire",mappedBy="annonce")
     * * @ORM\JoinColumn(name="commentaire_id",referencedColumnName="id",onDelete="CASCADE")
     */
    private $commentaires;

    public function __construct(){
        $this->commentaires=new ArrayCollection();
    }

    /**
     * @return mixed
     */
    public function getCommentaires()
    {
        return $this->commentaires;
    }

    /**
     * @param mixed $commentaires
     */
    public function setCommentaires($commentaires)
    {
        $this->commentaires = $commentaires;
    }
    /*------------  FIN RELATION ONE TO MANY ------------*/







    /**
     * @var string
     *
     * @ORM\Column(name="nomAnnonce", type="string", length=20)
     */
    private $nomAnnonce;

    /**
     * @var string
     *
     * @ORM\Column(name="descriptionAnnonce", type="text")
     */
    private $descriptionAnnonce;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="dateAnnonce", type="date")
     */
    private $dateAnnonce;








    /*------------  GET AND SET ------------*/
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
     * Set nomAnnonce
     *
     * @param string $nomAnnonce
     *
     * @return Annonce
     */
    public function setNomAnnonce($nomAnnonce)
    {
        $this->nomAnnonce = $nomAnnonce;

        return $this;
    }

    /**
     * Get nomAnnonce
     *
     * @return string
     */
    public function getNomAnnonce()
    {
        return $this->nomAnnonce;
    }

    /**
     * Set descriptionAnnonce
     *
     * @param string $descriptionAnnonce
     *
     * @return Annonce
     */
    public function setDescriptionAnnonce($descriptionAnnonce)
    {
        $this->descriptionAnnonce = $descriptionAnnonce;

        return $this;
    }

    /**
     * Get descriptionAnnonce
     *
     * @return string
     */
    public function getDescriptionAnnonce()
    {
        return $this->descriptionAnnonce;
    }
    /**
     * Set dateAnnonce
     *
     * @param \DateTime $dateAnnonce
     *
     * @return Annonce
     */
    public function setDateAnnonce($dateAnnonce)
    {
        $this->dateAnnonce = $dateAnnonce;

        return $this;
    }

    /**
     * Get dateAnnonce
     *
     * @return \DateTime
     */
    public function getDateAnnonce()
    {
        return $this->dateAnnonce;
    }

    /**
     * @param int $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }




}




