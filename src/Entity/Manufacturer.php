<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
#[ORM\Table(name: 'manufacturer')]
class Manufacturer
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string')]
    private $name;

    /**
     * This is the inverse side of the manufacturer product relationship.
     * This key is optional. Only declare it if necessary eg you need $manufacturer->getProducts();
     * When this is declared, it is called a bi-directional relationship.
     * When not declared, it is a Unidirectional relationship
     */
    #[ORM\OneToMany(targetEntity:"Product",mappedBy:"manufacturer")]
    private $products;

    public function __construct()
    {
        $this->products = new ArrayCollection();
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): void
    {
        $this->name = $name;
    }

    /**
     * @return Collection|array
     */
    public function getProducts(): Collection|array
    {
        return $this->products;
    }

    public function addProduct(Product $product): void
    {
        $this->products[] = $product;
    }
}