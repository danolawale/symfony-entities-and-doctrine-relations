<?php

namespace App\Entity;

use App\Repository\OrderRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: OrderRepository::class)]
#[ORM\Table(name: '`orders`')]
class Order
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 128)]
    private $customer_name;

    #[ORM\Column(type: 'string', length: 64)]
    private $shipping_address_1;

    #[ORM\Column(type: 'string', length: 64, nullable: true)]
    private $shipping_address_2;

    #[ORM\Column(type: 'string', length: 64, nullable: true)]
    private $shipping_address_3;

    #[ORM\Column(type: 'string', length: 16, nullable: true)]
    private $shipping_postcode;

    #[ORM\Column(type: 'string', length: 2)]
    private $shipping_country_code;

   /**
     * @var \DatetimeInterface
     */
    #[ORM\Column(type: 'datetime', name: 'created_at')]
    private $createdAt;

    #[ORM\OneToMany(targetEntity:"Item", mappedBy: "order")]
    private $items;

    public function __construct()
    {
        $this->createdAt = new \DateTimeImmutable(); //to use current time on instantiation
        $this->items = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCustomerName(): ?string
    {
        return $this->customer_name;
    }

    public function setCustomerName(string $customer_name): self
    {
        $this->customer_name = $customer_name;

        return $this;
    }

    public function getShippingAddress1(): ?string
    {
        return $this->shipping_address_1;
    }

    public function setShippingAddress1(string $shipping_address_1): self
    {
        $this->shipping_address_1 = $shipping_address_1;

        return $this;
    }

    public function getShippingAddress2(): ?string
    {
        return $this->shipping_address_2;
    }

    public function setShippingAddress2(?string $shipping_address_2): self
    {
        $this->shipping_address_2 = $shipping_address_2;

        return $this;
    }

    public function getShippingAddress3(): ?string
    {
        return $this->shipping_address_3;
    }

    public function setShippingAddress3(?string $shipping_address_3): self
    {
        $this->shipping_address_3 = $shipping_address_3;

        return $this;
    }

    public function getShippingPostcode(): ?string
    {
        return $this->shipping_postcode;
    }

    public function setShippingPostcode(?string $shipping_postcode): self
    {
        $this->shipping_postcode = $shipping_postcode;

        return $this;
    }

    public function getShippingCountryCode(): ?string
    {
        return $this->shipping_country_code;
    }

    public function setShippingCountryCode(string $shipping_country_code): self
    {
        $this->shipping_country_code = $shipping_country_code;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->createdAt;
    }

    public function getItems(): Collection|array
    {
        return $this->items;
    }

    public function addItem(Item $item): self
    {
        $this->items[] = $item;

        return $this;
    }
}
