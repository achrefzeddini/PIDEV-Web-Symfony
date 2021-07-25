<?php

namespace ProductBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * User
 *
 * @ORM\Table(name="user")
 * @ORM\Entity(repositoryClass="ProductBundle\Repository\UserRepository")
 */
class User
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
     * @ORM\Column(name="fnameUser", type="string", length=255)
     */
    private $fnameUser;

    /**
     * @var string
     *
     * @ORM\Column(name="lnameUser", type="string", length=255)
     */
    private $lnameUser;

    /**
     * @var int
     *
     * @ORM\Column(name="phoneUser", type="integer")
     */
    private $phoneUser;

    /**
     * @var int
     *
     * @ORM\Column(name="idRole", type="integer")
     */
    private $idRole;

    /**
     * @var int
     *
     * @ORM\Column(name="statusUser", type="integer")
     */
    private $statusUser;

    /**
     * @var string
     *
     * @ORM\Column(name="emailUser", type="string", length=255)
     */
    private $emailUser;

    /**
     * @var string
     *
     * @ORM\Column(name="passwordUser", type="string", length=255)
     */
    private $passwordUser;

    /**
     * @ORM\OneToMany(targetEntity="Product", mappedBy="user")
     */

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
     * Set fnameUser
     *
     * @param string $fnameUser
     *
     * @return User
     */
    public function setFnameUser($fnameUser)
    {
        $this->fnameUser = $fnameUser;

        return $this;
    }

    /**
     * Get fnameUser
     *
     * @return string
     */
    public function getFnameUser()
    {
        return $this->fnameUser;
    }

    /**
     * Set lnameUser
     *
     * @param string $lnameUser
     *
     * @return User
     */
    public function setLnameUser($lnameUser)
    {
        $this->lnameUser = $lnameUser;

        return $this;
    }

    /**
     * Get lnameUser
     *
     * @return string
     */
    public function getLnameUser()
    {
        return $this->lnameUser;
    }

    /**
     * Set phoneUser
     *
     * @param integer $phoneUser
     *
     * @return User
     */
    public function setPhoneUser($phoneUser)
    {
        $this->phoneUser = $phoneUser;

        return $this;
    }

    /**
     * Get phoneUser
     *
     * @return int
     */
    public function getPhoneUser()
    {
        return $this->phoneUser;
    }

    /**
     * Set idRole
     *
     * @param integer $idRole
     *
     * @return User
     */
    public function setIdRole($idRole)
    {
        $this->idRole = $idRole;

        return $this;
    }

    /**
     * Get idRole
     *
     * @return int
     */
    public function getIdRole()
    {
        return $this->idRole;
    }

    /**
     * Set statusUser
     *
     * @param integer $statusUser
     *
     * @return User
     */
    public function setStatusUser($statusUser)
    {
        $this->statusUser = $statusUser;

        return $this;
    }

    /**
     * Get statusUser
     *
     * @return int
     */
    public function getStatusUser()
    {
        return $this->statusUser;
    }

    /**
     * Set emailUser
     *
     * @param string $emailUser
     *
     * @return User
     */
    public function setEmailUser($emailUser)
    {
        $this->emailUser = $emailUser;

        return $this;
    }

    /**
     * Get emailUser
     *
     * @return string
     */
    public function getEmailUser()
    {
        return $this->emailUser;
    }

    /**
     * Set passwordUser
     *
     * @param string $passwordUser
     *
     * @return User
     */
    public function setPasswordUser($passwordUser)
    {
        $this->passwordUser = $passwordUser;

        return $this;
    }

    /**
     * Get passwordUser
     *
     * @return string
     */
    public function getPasswordUser()
    {
        return $this->passwordUser;
    }
}

