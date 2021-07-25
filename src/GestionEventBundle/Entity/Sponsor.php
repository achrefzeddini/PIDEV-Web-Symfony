<?php

namespace GestionEventBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Sponsor
 *
 * @ORM\Table(name="sponsor")
 * @ORM\Entity(repositoryClass="GestionEventBundle\Repository\SponsorRepository")
 */
class Sponsor
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
     * @var bool
     *
     * @ORM\Column(name="confirmation", type="boolean")
     */
    private $confirmation;

    /**
     * @var string
     *
     * @ORM\Column(name="mailsponsor", type="string", length=255)
     */
    private $mailsponsor;

    /**
     * @var \GestionEventBundle\Entity\Event
     *
     * @ORM\ManyToOne(targetEntity="GestionEventBundle\Entity\Event")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="idEvent", referencedColumnName="id")
     * })
     */
    private $idevent;


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
     * @return Sponsor
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
     * Set confirmation
     *
     * @param boolean $confirmation
     *
     * @return Sponsor
     */
    public function setConfirmation($confirmation)
    {
        $this->confirmation = $confirmation;

        return $this;
    }

    /**
     * Get confirmation
     *
     * @return bool
     */
    public function getConfirmation()
    {
        return $this->confirmation;
    }

    /**
     * Set mailsponsor
     *
     * @param string $mailsponsor
     *
     * @return Sponsor
     */
    public function setMailsponsor($mailsponsor)
    {
        $this->mailsponsor = $mailsponsor;

        return $this;
    }

    /**
     * Get mailsponsor
     *
     * @return string
     */
    public function getMailsponsor()
    {
        return $this->mailsponsor;
    }

     /**
     * Set idevent
     *
     * @param int $idevent
     *
     * @return Sponsor
     */
    public function setIdevent($idevent)
    {
        $this->idevent = $idevent;

        return $this;
    }

    /**
     * Get idevent
     *
     * @return int
     */
    public function getIdevent()
    {
        return $this->idevent;
    }
}

