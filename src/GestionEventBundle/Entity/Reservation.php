<?php

namespace GestionEventBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Reservation
 *
 * @ORM\Table(name="reservation")
 * @ORM\Entity(repositoryClass="GestionEventBundle\Repository\ReservationRepository")
 */
class Reservation
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
     * @ORM\Column(name="datereservation", type="string", length=255)
     */
    private $datereservation;

    /**
     * @var int
     *
     * @ORM\Column(name="quantite", type="integer")
     */
    private $quantite;

    /**
     * @var float
     *
     * @ORM\Column(name="total", type="float")
     */
    private $total;

    /**
     * @var string
     *
     * @ORM\Column(name="type", type="string", length=255)
     */
    private $type;

    /**
     * @var string
     *
     * @ORM\Column(name="seat", type="string", length=255)
     */
    private $seat;

    /**
     * @var int
     *
     * @ORM\Column(name="payer", type="integer")
     */
    private $payer;

    /**
     * @var string
     *
     * @ORM\Column(name="nomreservation", type="string", length=255)
     */
    private $nomreservation;

    /**
     * @var int
     *
     * @ORM\Column(name="iduser", type="integer")
     */
    private $iduser;

    /**
     * @var int
     *
     * @ORM\Column(name="idevent", type="integer")
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
     * Set datereservation
     *
     * @param string $datereservation
     *
     * @return Reservation
     */
    public function setDatereservation($datereservation)
    {
        $this->datereservation = $datereservation;

        return $this;
    }

    /**
     * Get datereservation
     *
     * @return string
     */
    public function getDatereservation()
    {
        return $this->datereservation;
    }

    /**
     * Set quantite
     *
     * @param integer $quantite
     *
     * @return Reservation
     */
    public function setQuantite($quantite)
    {
        $this->quantite = $quantite;

        return $this;
    }

    /**
     * Get quantite
     *
     * @return int
     */
    public function getQuantite()
    {
        return $this->quantite;
    }

    /**
     * Set total
     *
     * @param float $total
     *
     * @return Reservation
     */
    public function setTotal($total)
    {
        $this->total = $total;

        return $this;
    }

    /**
     * Get total
     *
     * @return float
     */
    public function getTotal()
    {
        return $this->total;
    }

    /**
     * Set type
     *
     * @param string $type
     *
     * @return Reservation
     */
    public function setType($type)
    {
        $this->type = $type;

        return $this;
    }

    /**
     * Get type
     *
     * @return string
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * Set seat
     *
     * @param string $seat
     *
     * @return Reservation
     */
    public function setSeat($seat)
    {
        $this->seat = $seat;

        return $this;
    }

    /**
     * Get seat
     *
     * @return string
     */
    public function getSeat()
    {
        return $this->seat;
    }

    /**
     * Set payer
     *
     * @param integer $payer
     *
     * @return Reservation
     */
    public function setPayer($payer)
    {
        $this->payer = $payer;

        return $this;
    }

    /**
     * Get payer
     *
     * @return int
     */
    public function getPayer()
    {
        return $this->payer;
    }

    /**
     * Set nomreservation
     *
     * @param string $nomreservation
     *
     * @return Reservation
     */
    public function setNomreservation($nomreservation)
    {
        $this->nomreservation = $nomreservation;

        return $this;
    }

    /**
     * Get nomreservation
     *
     * @return string
     */
    public function getNomreservation()
    {
        return $this->nomreservation;
    }

    /**
     * Set iduser
     *
     * @param integer $iduser
     *
     * @return Reservation
     */
    public function setIduser($iduser)
    {
        $this->iduser = $iduser;

        return $this;
    }

    /**
     * Get iduser
     *
     * @return integer
     */
    public function getIduser()
    {
        return $this->iduser;
    }


    public function setIdevent($idevent)
    {
        $this->idevent = $idevent;

        return $this;
    }


    public function getIdevent()
    {
        return $this->idevent;
    }

    
}


