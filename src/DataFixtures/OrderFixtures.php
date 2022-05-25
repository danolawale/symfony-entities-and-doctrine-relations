<?php

namespace App\DataFixtures;

use App\Entity\Order;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class OrderFixtures extends Fixture implements EntityFixturesInteface
{
   protected array $data;

   private StandardEntityFixturesProcessor $standardEntityFixturesProcessor;

   public function __construct()
   {
       $this->standardEntityFixturesProcessor = new StandardEntityFixturesProcessor;
   }

    public function load(ObjectManager $manager): void
    {
        $dataset = $this->getFixturesData();

        $this->standardEntityFixturesProcessor->load($manager, $dataset, Order::class);
    }

    public function setFixturesData(array $data): void
    {
        $this->data = $data;
    }

    public function getFixturesData(): array
    {
        return $this->data ?: $this->getCustomFixturesData();
    }

    public function getCustomFixturesData(): array
    {
        return [
            [
                'customer_name' => 'Test User',
                'shipping_address_1' => '1',
                'shipping_postcode' => 'TT1 1TT',
                'shipping_country_code' => 'GB',
                'shipping_address_1' => '1',
            ]
        ];
    }
}
