<?php

namespace App\Entity;

use App\Entity\Customer;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
#[ORM\Table(name: '`cart`')]
class Cart 
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    //one cart belongs to a customer
    //the owning side is the side holding the foreign key.
    //inversedBy is specified on the owning side of a biderectional association
    #[ORM\OneToOne(targetEntity:"Customer", inversedBy:"cart")]
    #[ORM\JoinColumn(name:"customer_id", nullable:false, referencedColumnName:"id")] //nullable is false because we don't want carts without customer
    private $customer;

    public function getId(): int
    {
        return $this->id;
    }

    public function getCustomer(): Customer
    {
        return $this->customer;
    }

    public function setCustomer(Customer $customer): void
    {
        $this->customer = $customer;
    }
}