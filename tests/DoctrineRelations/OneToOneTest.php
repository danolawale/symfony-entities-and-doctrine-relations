<?php 

namespace App\Tests\DoctrineRelations;

use App\Tests\DatabaseDependantTestCase;
use App\Entity\Customer;
use App\Entity\Cart;

class OneToOneTest extends DatabaseDependantTestCase
{
    public function testCreate(): void
    {
        $customer = new Customer;
        $this->entityManager->persist($customer);

        $cart = new Cart;
        $cart->setCustomer($customer);
        $this->entityManager->persist($cart);

        $this->entityManager->flush();

        $this->assertEquals(2, $customer->getId());
        $this->assertEquals(2, $cart->getId());
        $this->assertEquals(2, $cart->getCustomer()->getId());
    }

    protected function _createTestDataset(): array
    {
        return [
            Customer::class => [
                [
                    'id' => 1
                ],
            ],
            Cart::class => [
                [
                    'id' => 1,
                    'customer_id' => 1
                ]
            ]
        ];
    }
}