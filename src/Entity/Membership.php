<?php

namespace App\Entity;

use App\Entity\Enums\MembershipLevelTypes;
use App\Repository\MembershipRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: MembershipRepository::class)]
class Membership
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'datetime_immutable')]
    private $createdAt;

    #[ORM\Column(type: 'string', length: 255)]
    private $level;

    #[ORM\ManyToOne(targetEntity:"PrimeDiscountGroup", inversedBy:"customerMemberships")]
    #[ORM\JoinColumn(nullable:false)]
    private $primeDiscountGroup;

    #[ORM\ManyToOne(targetEntity:"Customer")]
    #[ORM\JoinColumn(nullable:false)]
    private $member;

    public function __construct()
    {
        $this->createdAt = (new \DateTimeImmutable())->setTimezone(new \DateTimeZone('UTC'));
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeInterface $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getLevel(): ?string
    {
        return $this->level;
    }

    public function setLevel(string $level): self
    {
        $found = MembershipLevelTypes::tryFrom($level)->toString();

        if(null !== $found)
        {
            $this->level = $found;
        }
        else
        {
            throw new \InvalidArgumentException("Membership {$level} not found");
        }

        return $this;
    }

    public function getPrimeDiscountGroup()
    {
        return $this->primeDiscountGroup;
    }

    public function setPrimeDiscountGroup(PrimeDiscountGroup $primeDiscountGroup): self
    {
        $this->primeDiscountGroup = $primeDiscountGroup;

        return $this;
    }

    public function getMember(): Customer
    {
        return $this->member;
    }

    public function setMember(Customer $member): self
    {
        $this->member = $member;

        return $this;
    }
}
