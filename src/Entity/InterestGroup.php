<?php
namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Table(name: 'interest_group')]
#[ORM\Entity]
class InterestGroup
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 50)]
    private $name;

    /**
     * This way of doing many-to-many relationships causes a problem because the join table is not captured in an
     * entity class. Also there is no way of adding extra fields to the join table
     */
    #[ORM\ManyToMany(targetEntity:"User", mappedBy:"interestGroups")]
    private $members;

    public function __construct()
    {
        $this->members = new ArrayCollection();
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getMembers(): Collection|array
    {
        return $this->members;
    }

    public function addMember(User $member): self
    {
        $this->members[] = $member;

        return $this;
    }
}