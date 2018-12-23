<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use App\Entity\Ticket;
use App\Entity\TicketTime;

/**
 * @ORM\Table(name="`user`")
 * @ORM\Entity
 * @UniqueEntity(fields="username", message="Username already taken")
 */
class User implements UserInterface
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=191, unique=true)
     * @Assert\NotBlank()
     */
    private $username;
    /**
     * @Assert\NotBlank()
     * @ORM\Column(type="string", length=64)
     */
    private $password;
    /**
     * User = 1; Director = 2, Admin = 3;
     * @ORM\Column(type="integer", nullable=false)
     */
    private $role;

    /**
     * @var \Doctrine\Common\Collections\Collection|Ticket[]
     *
     * @ORM\ManyToMany(targetEntity="Ticket", inversedBy="users")
     */
    private $tickets;

    /**
     * @var \Doctrine\Common\Collections\Collection|TicketTime[]
     * @ORM\ManyToMany(targetEntity="TicketTime", mappedBy="user")
     */
    private $times;

    public function __construct()
    {
        $this->tickets = new ArrayCollection();
        $this->times = new ArrayCollection();
    }

    public function addUserTicket(Ticket $ticket)
    {
        if($this->tickets->contains($ticket)){
            return;
        }
        $this->tickets->add($ticket);
        $ticket->addUser($this);
    }

    public function removeUserTicket(Ticket $ticket)
    {
        if(!$this->tickets->contains($ticket)){
            return;
        }
        $this->tickets->removeElement($ticket);
        $ticket->removeUser($this);
    }

    public function addTicketTime(TicketTime $time)
    {
        if($this->times->contains($time)){
            return;
        }
        $this->times->add($time);
        $time->addUser($this);
    }

    public function removeTicketTime(TicketTime $time)
    {
        if(!$this->times->contains($time)){
            return;
        }
        $this->times->removeElement($time);
        $time->removeUser($this);
    }

    public function getTickets()
    {
        return $this->tickets;
    }

    public function getTimes()
    {
        return $this->times;
    }

    public function getId(): ?int
    {
        return $this->id;
    }
    public function getUsername()
    {
        return $this->username;
    }

    /**
     * @param mixed $username
     */
    public function setUsername($username): void
    {
        $this->username = $username;
    }

    /**
     * @return mixed
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * @param mixed $password
     */
    public function setPassword($password): void
    {
        $this->password = $password;
    }

    /**
     * @return mixed
     */
    public function getRole()
    {
        return $this->role;
    }

    /**
     * @param mixed $role
     */
    public function setRole($role): void
    {
        $this->role = $role;
    }

    public function getSalt()
    {
        return null;
    }
    public function getRoles()
    {
        return array('ROLE_USER');
    }
    public function eraseCredentials()
    {
        return null;
    }
}