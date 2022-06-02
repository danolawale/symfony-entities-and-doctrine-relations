<?php

namespace App\Entity;

use App\Repository\ProductRepository;
use Doctrine\ORM\Mapping as ORM;
use App\Entity\Manufacturer;

#[ORM\Table(name: 'products')]
#[ORM\Entity(repositoryClass: ProductRepository::class)]
class Product
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 255)]
    private $name;

    /**
     * This is the owning side. This must exist in the manufacturer-product relationship
     * The product entity is on the 'many' side of this relationship
     */
    #[ORM\ManyToOne(targetEntity:"Manufacturer", inversedBy:"products")]
    #[ORM\JoinColumn(name:"manufacturer_id", nullable:false, referencedColumnName:"id")]
    private $manufacturer;

    #[ORM\Column(type: 'text')]
    private $description;

    #[ORM\Column(type: 'integer')]
    private $price;

    /**
     * @var \DatetimeInterface
     */
    #[ORM\Column(type: 'datetime', name: 'created_at')]
    private $createdAt;

    public function __construct()
    {
        $this->createdAt = new \DateTimeImmutable(); //to use current time on instantiation
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getManufacturer(): Manufacturer
    {
        return $this->manufacturer;
    }

    public function setManufacturer(Manufacturer $manufacturer): void
    {
        $manufacturer->addProduct($this);

        $this->manufacturer = $manufacturer;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getPrice(): ?int
    {
        return $this->price;
    }

    public function setPrice(int $price): self
    {
        $this->price = $price;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->createdAt;
    }
}
