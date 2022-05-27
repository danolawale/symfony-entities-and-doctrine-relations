<?php

namespace App\DataFixtures;

use App\Entity\Product;
use App\Entity\User;
use App\Entity\Order;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
   private array $data;

    public function load(ObjectManager $manager): void
    {
        $user = new User();
        $user->setUsername('danolawale');
        $user->setPassword(password_hash('password', PASSWORD_DEFAULT));

        $product = new Product();
        $product->setName('Laptop XP 355');
        $product->setDescription("Windows Professional Laptop 2022 Model");
        $product->setPrice('75525');

        $order = new Order();
        $order->setCustomerName('Jeremiah Appiah');
        $order->setShippingAddress1('Prince Street');
        $order->setShippingCountryCode('GB');
        $order->setShippingPostcode('M11 1BB');

        $manager->persist($user);
        $manager->persist($product);
        $manager->persist($order);

        $manager->flush();
    }
}
