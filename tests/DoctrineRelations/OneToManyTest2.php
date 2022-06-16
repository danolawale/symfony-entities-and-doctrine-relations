<?php

namespace App\Tests\DoctrineRelations;

use App\Entity\Item;
use App\Entity\Order;
use App\Tests\AbstractUnitTestCase;

class OneToManyTest2 extends AbstractUnitTestCase
{
    public function test_create(): void
    {
        $customerName = 'Daniel Maestro';
        $shippingAddress1 = '10';
        $shippingAddress2 = 'Major Street';
        $shippingPostcode = 'M11 1BB';
        $shippingCountryCode = 'GB';

        $order = new Order();
        $order->setCustomerName($customerName);
        $order->setShippingAddress1($shippingAddress1);
        $order->setShippingAddress2($shippingAddress2);
        $order->setShippingPostcode($shippingPostcode);
        $order->setShippingCountryCode($shippingCountryCode);

        $item = new Item();
        $item->setQuantity(2);
        $item->setDescription("Nike's Tennis Rackets");

        //$order->addItem($item);
        $item->setOrder($order);
        $this->entityManager->persist($item);
        $this->entityManager->persist($order);
        $this->entityManager->flush();

        $this->assertEquals(2, $order->getId());

        $this->assertDatabaseHas(Order::class, [
            'customer_name' => $customerName,
            'shipping_postcode' => $shippingPostcode
        ]);

        $this->assertEquals(2, $item->getOrder()->getId());
        $this->assertCount(1, $order->getItems());
    }

    public function test_update(): void
    {
        $order = $this->entityManager->getRepository(Order::class)->findOneBy([
            'customer_name' => 'Test User'
        ]);
        $this->assertCount(1, $order->getItems());

        $item = new Item();
        $item->setQuantity(1);
        $item->setDescription("Nike's Tennis Rackets");
        
        $order->setShippingAddress1('20');
        $order->setShippingAddress2('Lane Mark Street');

        $item->setOrder($order);
        $this->entityManager->persist($item);
        $this->entityManager->persist($order);
        $this->entityManager->flush();

        $this->assertEquals(1, $order->getId());

        $this->assertDatabaseHas(Order::class, [
            'customer_name' => 'Test User',
            'shipping_address_1' => '20',
            'shipping_address_2' => 'Lane Mark Street'
        ]);

        $this->assertCount(2, $order->getItems());
        $this->assertEquals(1, $order->getItems()[1]->getOrder()->getId());
    }

    protected function _createTestDataset(): array
    {
        return [
            Order::class => [
                [
                    'customer_name' => 'Test User',
                    'shipping_address_1' => '1',
                    'shipping_postcode' => 'TT1 1TT',
                    'shipping_country_code' => 'GB',
                    'shipping_address_1' => '1',
                ]
            ],
            Item::class => [
                [
                    'order_id' => 1,
                    'quantity' => 1,
                    'description' => "Test Item1"
                ]
            ] 
        ];
    }
}