<?php

namespace App\Tests\DoctrineRelations;

use App\Entity\Manufacturer;
use App\Entity\Product;
use App\Tests\DatabaseDependantTestCase;

class OneToManyTest extends DatabaseDependantTestCase
{
    public function testCreate(): void
    {
        $manufacturer = new Manufacturer;
        $manufacturer->setName('Test Products Manufacturing Company.');
        $this->entityManager->persist($manufacturer);

        $product1 = new Product;
        $product1->setName('Test Product1');
        $product1->setDescription('Test Product 1');
        $product1->setManufacturer($manufacturer);
        $product1->setPrice(3000);
        $this->entityManager->persist($product1);

        $product2 = new Product;
        $product2->setName('Test Product2');
        $product2->setDescription('Test Product 2');
        $product2->setManufacturer($manufacturer);
        $product2->setPrice(3500);
        $this->entityManager->persist($product2);

        $this->entityManager->flush();

        $this->assertCount(2, $manufacturer->getProducts());

    }

    protected function _createTestDataset(): array
    {
        return [
            Manufacturer::class => [
                [
                    'id' => 1,
                    'name' => 'ACME'
                ],
            ],
            Product::class => [
                [
                    'id' => 1,
                    'name' => 'ACME Sensors',
                    'description' => 'ACME Line of Sensors',
                    'manufacturer_id' => 1,
                    'price' => 450
                ]
            ]
        ];
    }
}