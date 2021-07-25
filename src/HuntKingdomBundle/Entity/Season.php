<?php

namespace HuntKingdomBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\Common\Annotations\AnnotationRegistry;

/**
 * Season
 *
 * @ORM\Table(name="season")
 * @ORM\Entity(repositoryClass="HuntKingdomBundle\Repository\SeasonRepository")
 */
class Season
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
     * @ORM\Column(name="nom", type="string", length=255)
     */
    private $nom;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="string", length=255)
     */
    private $description;

    /**
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @param string $description
     */
    public function setDescription($description)
    {
        $this->description = $description;
    }

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="Start", type="date")
     */
    private $start;

    /**
     * @var \DateTime
     * @Assert\GreaterThan(propertyPath="start", message="Finish date must be after start date")
     * @ORM\Column(name="finish", type="date")
     */
    private $finish;


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
     * Set nom
     *
     * @param string $nom
     *
     * @return Season
     */
    public function setNom($nom)
    {
        $this->nom = $nom;

        return $this;
    }

    /**
     * Get nom
     *
     * @return string
     */
    public function getNom()
    {
        return $this->nom;
    }

    /**
     * Set start
     *
     * @param \DateTime $start
     *
     * @return Season
     */
    public function setStart($start)
    {
        $this->start = $start;

        return $this;
    }

    /**
     * Get start
     *
     * @return \DateTime
     */
    public function getStart()
    {
        return $this->start;
    }

    /**
     * Set finish
     *
     * @param \DateTime $finish
     *
     * @return Season
     */
    public function setFinish($finish)
    {
        $this->finish = $finish;

        return $this;
    }

    /**
     * @ORM\OneToMany(targetEntity="HuntKingdomBundle\Entity\Animal", mappedBy="Season")
     * @ORM\JoinColumn(name="animal_id",referencedColumnName="id")
     */
    private $Animal;
    public function __construct()
    {
        $this->Animal = new ArrayCollection();
    }

    /**
     * @return mixed
     */
    public function getAnimal()
    {
        return $this->Animal;
    }

    /**
     * @param mixed $Animal
     */
    public function setAnimal($Animal)
    {
        $this->Animal = $Animal;
    }


    /**
     * Get finish
     *
     * @return \DateTime
     */
    public function getFinish()
    {
        return $this->finish;
    }
    public function __toString() {
        return (String) $this->nom;
    }

}

