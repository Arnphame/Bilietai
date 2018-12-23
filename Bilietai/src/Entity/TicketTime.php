<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
/**
 * @ORM\Entity
 * @ORM\Table(name="times")
 */
class TicketTime
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @return mixed
     */
    public function getAvailable()
    {
        return $this->available;
    }

    /**
     * @param mixed $available
     */
    public function setAvailable($available): void
    {
        $this->available = $available;
    }

    /**
     * @return mixed
     */
    public function getTaken()
    {
        return $this->taken;
    }

    /**
     * @param mixed $taken
     */
    public function setTaken($taken): void
    {
        $this->taken = $taken;
    }

    /**
     * @return User[]|\Doctrine\Common\Collections\Collection
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * @param User[]|\Doctrine\Common\Collections\Collection $user
     */
    public function setUser($user): void
    {
        $this->user = $user;
    }
    /**
     * @ORM\Column(type="integer", length=4, nullable=false)
     * @Assert\NotBlank()
     * @Assert\Range(min = 0, minMessage = "Tickets must be higher than {{ limit }}")
     */
    public $available;
    /**
     * @ORM\Column(type="integer", length=4, nullable=true)
     */
    public $taken;

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }
    /**
     * @ORM\ManyToOne(targetEntity="Ticket", inversedBy="time")
     * @ORM\JoinColumn(nullable=false)
     */
    private $ticket;

    /**
     * @return mixed
     */
    public function getTicket()
    {
        return $this->ticket;
    }

    /**
     * @param mixed $ticket
     */
    public function setTicket($ticket): void
    {
        $this->ticket = $ticket;
    }
    public function add(Ticket $ticket)
    {
        $this->ticket[] = $ticket;
        $ticket->setTicketTimes($this);//added this line
        return $this;
    }
    /**
     * @ORM\Column(type="datetime")
     * @Assert\DateTime
     * @Assert\NotBlank()
     */
    private $name;
    /**
     * @var \Doctrine\Common\Collections\Collection|User[]
     *
     * @ORM\ManyToMany(targetEntity="User", inversedBy="times")
     */
    private $user;

    public function __construct()
    {
        $this->user = new ArrayCollection();
    }

    public function addUser(User $user)
    {
        if ($this->user->contains($user)) {
            return;
        }
        $this->user->add($user);
        $user->addTicketTime($this);
    }
    /**
     * @param User $user
     */
    public function removeUser(User $user)
    {
        if (!$this->user->contains($user)) {
            return;
        }
        $this->user->removeElement($user);
        $user->removeTicketTime($this);
    }

    public function getName()
    {
        return $this->name;
    }

    public function setName($time)
    {
        $this->name = $time;
    }
    public function isAvailable()
    {
        if($this->taken == $this->available){
            return false;
        }
        else return true;
    }

}
