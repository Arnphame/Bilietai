<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use App\Entity\User;

/**
 * @ORM\Entity(repositoryClass="App\Repository\TicketRepository")
 */
class Ticket
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;
    /**
     * @ORM\Column(type="string", length=191)
     * @Assert\NotBlank()
     */
    private $name;
    /**
     * @ORM\Column(type="float", length=6)
     * @Assert\NotBlank()
     * @Assert\Range(min = 0, minMessage = "Price must be higher than {{ limit }}")
     */
    private $price;

    /**
     * @Assert\NotBlank()
     * @ORM\OneToMany(targetEntity="TicketTime", mappedBy="ticket", fetch="EXTRA_LAZY", orphanRemoval=true, cascade={"persist"})
     */
    private $ticketTimes;

    /**
     * @var \Doctrine\Common\Collections\Collection|User[]
     *
     * @ORM\ManyToMany(targetEntity="User", mappedBy="tickets")
     */
    private $users;

    /**
     * @return User[]|\Doctrine\Common\Collections\Collection
     */
    public function getUsers()
    {
        return $this->users;
    }

    /**
     * @param User[]|\Doctrine\Common\Collections\Collection $users
     */
    public function setUsers($users): void
    {
        $this->users = $users;
    }

    public function __construct()
    {
        $this->ticketTimes = new ArrayCollection();
        $this->users = new ArrayCollection();
    }

    public function UserContains(User $user)
    {
        if($this->users->contains($user)){
            return true;
        }
        else return false;
    }
    public function addUser(User $user)
    {
        if ($this->users->contains($user)) {
            return;
        }
        $this->users->add($user);
        $user->addUserTicket($this);
    }
    /**
     * @param User $user
     */
    public function removeUser(User $user)
    {
        if (!$this->users->contains($user)) {
            return;
        }
        $this->users->removeElement($user);
        $user->removeUserTicket($this);
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param mixed $name
     */
    public function setName($name): void
    {
        $this->name = $name;
    }

    /**
     * @return mixed
     */
    public function getPrice()
    {
        return $this->price;
    }

    /**
     * @param mixed $price
     */
    public function setPrice($price): void
    {
        $this->price = $price;
    }

    /**
     * @param mixed $time
     */
    public function setTicketTimes($time): void
    {
        $this->ticketTimes = $time;
    }
    /**
     * @return ArrayCollection|TicketTime[]
     */
    public function getTicketTimes()
    {
        return $this->ticketTimes;
    }
    public function addTicketTime(TicketTime $time)
    {
        $this->ticketTimes[] = $time;
        $time->setTicket($this);
        $time->setTaken(0);
        return $this;
    }
}
