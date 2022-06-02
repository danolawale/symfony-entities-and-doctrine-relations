<?php

namespace App\Tests;

use App\Entity\Manufacturer;
use App\Entity\Product;

class ProductsTest extends DatabaseDependantTestCase
{
    public function test_can_create_product(): void
    {
        $manufacturer = new Manufacturer;
        $manufacturer->setName('Test Manufacturer');
        $this->entityManager->persist($manufacturer);

        $name = 'Test Product';
        $description = "This is a test product for testing";

        $product = new Product;
        $product->setName($name);
        $product->setDescription($description);
        $product->setManufacturer($manufacturer);
        $product->setPrice(95500);

        $this->entityManager->persist($product);
        $this->entityManager->flush();

        $this->assertEquals(1, $product->getId());

        $this->assertDatabaseHas(Product::class, [
            'name' => $name,
            'description' => $description
        ]);

        $this->assertDatabaseNotHas(Product::class, [
            'name' => $name,
            'description' => 'foo'
        ]);
    }
}