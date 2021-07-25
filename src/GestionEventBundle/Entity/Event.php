<?php

namespace GestionEventBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Event
 *
 * @ORM\Table(name="event")
 * @ORM\Entity(repositoryClass="GestionEventBundle\Repository\EventRepository")
 */
class Event
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
     * @var string
     *
     * @ORM\Column(name="titre", type="string", length=255)
     */
    private $titre;

    /**
     * @var string
     *
     * @ORM\Column(name="image", type="string", length=255)
     */
    private $image;

    /**
     * @var int
     *
     * @ORM\Column(name="nbrplaces", type="integer")
     */
    private $nbrplaces;

    /**
     * @var string
     *
     * @ORM\Column(name="localisation", type="string", length=255)
     */
    private $localisation;

    /**
     * @var float
     *
     * @ORM\Column(name="hdebut", type="float")
     */
    private $hdebut;

    /**
     * @var float
     *
     * @ORM\Column(name="hfin", type="float")
     */
    private $hfin;

    /**
     * @var float
     *
     * @ORM\Column(name="prix", type="float")
     */
    private $prix;
/**
     * @ORM\ManyToOne(targetEntity="HuntKingdomBundle\Entity\User")
     * @ORM\JoinColumn(name="idUser", referencedColumnName="id")
     */
    private $iduser;

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
     * Set titre
     *
     * @param string $titre
     *
     * @return Event
     */
    public function setTitre($titre)
    {
        $this->titre = $titre;

        return $this;
    }

    /**
     * Get titre
     *
     * @return string
     */
    public function getTitre()
    {
        return $this->titre;
    }

    /**
     * Set image
     *
     * @param string $image
     *
     * @return Event
     */
    public function setImage($image)
    {
        $this->image = $image;

        return $this;
    }

    /**
     * Get image
     *
     * @return string
     */
    public function getImage()
    {
        return $this->image;
    }

    /**
     * Set nbrplaces
     *
     * @param integer $nbrplaces
     *
     * @return Event
     */
    public function setNbrplaces($nbrplaces)
    {
        $this->nbrplaces = $nbrplaces;

        return $this;
    }

    /**
     * Get nbrplaces
     *
     * @return int
     */
    public function getNbrplaces()
    {
        return $this->nbrplaces;
    }

    /**
     * Set localisation
     *
     * @param string $localisation
     *
     * @return Event
     */
    public function setLocalisation($localisation)
    {
        $this->localisation = $localisation;

        return $this;
    }

    /**
     * Get localisation
     *
     * @return string
     */
    public function getLocalisation()
    {
        return $this->localisation;
    }

    /**
     * Set hdebut
     *
     * @param float $hdebut
     *
     * @return Event
     */
    public function setHdebut($hdebut)
    {
        $this->hdebut = $hdebut;

        return $this;
    }

    /**
     * Get hdebut
     *
     * @return float
     */
    public function getHdebut()
    {
        return $this->hdebut;
    }

    /**
     * Set hfin
     *
     * @param float $hfin
     *
     * @return Event
     */
    public function setHfin($hfin)
    {
        $this->hfin = $hfin;

        return $this;
    }

    /**
     * Get hfin
     *
     * @return float
     */
    public function getHfin()
    {
        return $this->hfin;
    }

    /**
     * Set prix
     *
     * @param float $prix
     *
     * @return Event
     */
    public function setPrix($prix)
    {
        $this->prix = $prix;

        return $this;
    }

    /**
     * Get prix
     *
     * @return float
     */
    public function getPrix()
    {
        return $this->prix;
    }


    
}

