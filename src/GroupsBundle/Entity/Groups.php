<?php

namespace GroupsBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Groups
 *
 * @ORM\Table(name="groups", uniqueConstraints={@ORM\UniqueConstraint(name="nameGroup", columns={"nameGroup"})})
 * @ORM\Entity(repositoryClass="GroupsBundle\Repository\GroupsRepository")
 */
class Groups
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="nameGroup", type="string", length=100, nullable=false)
     */
    private $namegroup;

    /**
     * @var string
     *
     * @ORM\Column(name="typeGroup", type="string", length=20, nullable=false)
     */
    private $typegroup;

    /**
     * @ORM\ManyToMany(targetEntity="UsersBundle\Entity\User", inversedBy="groups", cascade={"persist"})
     */
    protected $users;

    /**
     * @return mixed
     */
    public function getUsers()
    {
        return $this->users;
    }

    /**
     * @param mixed $users
     */
    public function setUsers($users)
    {
        $this->users = $users;
    }

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param int $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }


    /**
     * @return string
     */
    public function getNamegroup()
    {
        return $this->namegroup;
    }

    /**
     * @param string $namegroup
     */
    public function setNamegroup($namegroup)
    {
        $this->namegroup = $namegroup;
    }

    /**
     * @return string
     */
    public function getTypegroup()
    {
        return $this->typegroup;
    }

    /**
     * @param string $typegroup
     */
    public function setTypegroup($typegroup)
    {
        $this->typegroup = $typegroup;
    }


    /**
     * Constructor
     */
    public function __construct()
    {
        $this->users = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add user
     *
     * @param \GroupsBundle\Entity\User $user
     *
     * @return Groups
     */
    public function addUser(\GroupsBundle\Entity\User $user)
    {
        $this->users[] = $user;

        return $this;
    }

    /**
     * Remove user
     *
     * @param \GroupsBundle\Entity\User $user
     */
    public function removeUser(\GroupsBundle\Entity\User $user)
    {
        $this->users->removeElement($user);
    }
}
