<?php

namespace App\Entity;

//ManyToOne Unidirectional i,e many users belong to the same address
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
#[ORM\Table(name: '`address`')]
class Address
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 50)]
    private $address_line1;

    #[ORM\Column(type: 'string', nullable: true, length: 50)]
    private $address_line2;

    #[ORM\Column(type: 'string', nullable: true, length: 50)]
    private $address_line3;

    #[ORM\Column(type: 'string', length: 10)]
    private $post_code;

    #[ORM\Column(type: 'string', length: 2)]
    private $country_code;

    public function getId(): int
    {
        return $this->id;
    }

    public function getAddressLine1(): string
    {
        return $this->address_line1;
    }

    public function setAddressLine1(string $address_line1): self
    {
        $this->address_line1 = $address_line1;

        return $this;
    }

    public function getAddressLine2(): ?string
    {
        return $this->address_line2;
    }

    public function setAddressLine2(?string $address_line_2): self
    {
        $this->address_line2 = $address_line_2;

        return $this;
    }

    public function getAddressLine3(): ?string
    {
        return $this->address_line3;
    }

    public function setAddressLine3(?string $address_line_3): self
    {
        $this->address_line3 = $address_line_3;

        return $this;
    }

    public function getPostcode(): string
    {
        return $this->postcode;
    }

    public function setPostcode(string $postcode): self
    {
        $this->post_code = $postcode;

        return $this;
    }

    public function getCountryCode(): string
    {
        return $this->country_code;
    }

    public function setCountryCode(string $country_code): self
    {
        $this->country_code = $country_code;

        return $this;
    }
}
