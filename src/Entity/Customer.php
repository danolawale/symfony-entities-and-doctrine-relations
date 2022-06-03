<?php

namespace App\Entity;

use App\Entity\Cart;
use Doctrine\Common\Collections\ArrayCollection;
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

    #[ORM\OneToMany(targetEntity:"Membership", mappedBy:"member")]
    private $groupMemberships;

    /*public function __construct()
    {
        $this->groupMemberships = new ArrayCollection();
    }*/

    public function getId(): int
    {
        return $this->id;
    }

    public function getCart(): Cart
    {
        return $this->cart;
    }
}