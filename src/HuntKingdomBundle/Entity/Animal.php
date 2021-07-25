<?php

namespace HuntKingdomBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\Common\Annotations\AnnotationRegistry;


/**
 * Animal
 *
 * @ORM\Table(name="animal")
 * @ORM\Entity(repositoryClass="HuntKingdomBundle\Repository\AnimalRepository")
 */
class Animal
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
     * @var int
     *
     * @ORM\Column(name="idA", type="integer", unique=true)
     *
     */
    private $idA;

    /**
     * @var string
     *
     * @ORM\Column(name="race", type="string", length=255)
     */
    private $race;

    /**
     * @var string
     *
     * @ORM\Column(name="saison", type="string", length=255)
     */
    private $saison;

    /**
     * @ORM\ManyToOne(targetEntity="HuntKingdomBundle\Entity\Season", inversedBy="Animal" , cascade= {"persist"})
     * @ORM\JoinColumn(name="season_id",referencedColumnName="id")
     */
    private $Season;

    /**
     * @return mixed
     */
    public function getSeason()
    {
        return $this->Season;
    }

    /**
     * @param mixed $Season
     */
    public function setSeason($Season)
    {
        $this->Season = $Season;
    }

    /**
     * @var string
     *
     * @ORM\Column(name="place", type="string", length=255)
     */
    private $place;

    /**
     * @var string
     *
     * @ORM\Column(name="image", type="text")
     */
    private $image;

    /**
     * @var int
     *
     * @ORM\Column(name="hunted", type="integer")
     */
    private $hunted;

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
     * Set idA
     *
     * @param integer $idA
     *
     * @return Animal
     */
    public function setIdA($idA)
    {
        $this->idA = $idA;

        return $this;
    }

    /**
     * Get idA
     *
     * @return int
     */
    public function getIdA()
    {
        return $this->idA;
    }

    /**
     * Set race
     *
     * @param string $race
     *
     * @return Animal
     */
    public function setRace($race)
    {
        $this->race = $race;

        return $this;
    }

    /**
     * Get race
     *
     * @return string
     */
    public function getRace()
    {
        return $this->race;
    }

    /**
     * Set saison
     *
     * @param string $saison
     *
     * @return Animal
     */
    public function setSaison($saison)
    {
        $this->saison = $saison;

        return $this;
    }

    /**
     * Get saison
     *
     * @return string
     */
    public function getSaison()
    {
        return $this->saison;
    }

    /**
     * Set place
     *
     * @param string $place
     *
     * @return Animal
     */
    public function setPlace($place)
    {
        $this->place = $place;

        return $this;
    }

    /**
     * Get place
     *
     * @return string
     */
    public function getPlace()
    {
        return $this->place;
    }

    /**
     * Set image
     *
     * @param string $image
     *
     * @return Animal
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
     * Set hunted
     *
     * @param integer $hunted
     *
     * @return Animal
     */
    public function setHunted($hunted)
    {
        $this->hunted = $hunted;

        return $this;
    }

    /**
     * Get hunted
     *
     * @return int
     */
    public function getHunted()
    {
        return $this->hunted;
    }
    public function __toString() {
        return (String) $this->race;
    }
}

