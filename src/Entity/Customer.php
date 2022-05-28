<?php

namespace App\Entity;

use App\Entity\Cart;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
#[ORM\Table(name: '`customer`')]
class Customer 
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    //one customer has one cart
    #[ORM\OneToOne(targetEntity:"Cart", mappedBy:"customer")]
    private $cart;

    public function getId(): int
    {
        return $this->id;
    }

    public function getCart(): Cart
    {
        return $this->cart;
    }
}