<?php

namespace App\Tests;

use App\Entity\Order;

class OrdersTest extends DatabaseDependantTestCase
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

        $this->entityManager->persist($order);
        $this->entityManager->flush();

        $this->assertEquals(2, $order->getId());

        $this->assertDatabaseHas(Order::class, [
            'customer_name' => $customerName,
            'shipping_postcode' => $shippingPostcode
        ]);
    }

    public function test_update(): void
    {
        $order = $this->entityManager->getRepository(Order::class)->findOneBy([
            'customer_name' => 'Test User'
        ]);
        
        $order->setShippingAddress1('20');
        $order->setShippingAddress2('Lane Mark Street');

        $this->entityManager->persist($order);
        $this->entityManager->flush();

        $this->assertEquals(1, $order->getId());

        $this->assertDatabaseHas(Order::class, [
            'customer_name' => 'Test User',
            'shipping_address_1' => '20',
            'shipping_address_2' => 'Lane Mark Street'
        ]);
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
            ]
        ];
    }
}