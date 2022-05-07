<?php

namespace App\DataFixtures;

use App\Entity\Product;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
   
    public function load(ObjectManager $manager): void
    {
        $user = new User();
        $user->setUsername('danolawale');
        $user->setPassword(password_hash('password', PASSWORD_DEFAULT));

        $product = new Product();
        $product->setName('Laptop XP 355');
        $product->setDescription("Windows Professional Laptop 2022 Model");
        $product->setPrice('75525');

        $manager->persist($user);
        $manager->persist($product);

        $manager->flush();
    }
}
