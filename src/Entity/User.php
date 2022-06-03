<?php

namespace App\Entity;

use App\Repository\UserRepository;
use DateTimeImmutable;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use phpDocumentor\Reflection\Types\This;
use Doctrine\Common\Collections\Collection;

#[ORM\Table(name: 'users')]
#[ORM\Entity(repositoryClass: UserRepository::class)]
class User
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 50)]
    private $username;

    #[ORM\Column(type: 'string', length: 255)]
    private $password;

    /**
     * @var \DatetimeInterface
     */
    #[ORM\Column(type: 'datetime', name: 'created_at')]
    private $createdAt;

    #[ORM\ManyToOne(targetEntity:"Address")]
    //#[ORM\JoinColumn(name:"address_id", referencedColumnName:"id")] //can leave this out..can be done automatically
    private $address;

    /**
     * This is the owning side of the many-to-many relationship.
     * The owning side is defined on the Users table because it needs to exist first
     * Many users can be members of many interest groups
     * 
     * This way of doing many-to-many relationships causes a problem because the join table is not captured in an
     * entity class. Also there is no way of adding extra fields to the join table
     */
    #[ORM\ManyToMany(targetEntity:"InterestGroup", inversedBy:"members")]
    #[ORM\JoinTable(name:"users_interest_groups")]
    private $interestGroups;

    public function __construct()
    {
        $this->createdAt = new \DateTimeImmutable(); //to use current time on instantiation
        $this->interestGroups = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUsername(): ?string
    {
        return $this->username;
    }

    public function setUsername(string $username): self
    {
        $this->username = $username;

        return $this;
    }

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->createdAt;
    }

    public function getAddress(): ?Address
    {
        return $this->address;
    }

    public function setAddress(?Address $address): self
    {
        $this->address = $address;

        return $this;
    }

    public function getInterestGroups(): Collection|array
    {
        return $this->interestGroups;
    }

    public function joinInterestGroup(InterestGroup $interestGroup): self
    {
        //add the user to the group
        $interestGroup->addMember($this);

        //add the group to the users list of interest groups
        $this->interestGroups[] = $interestGroup;

        return $this;
    }
}
