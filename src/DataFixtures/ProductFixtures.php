<?php

namespace App\DataFixtures;

use App\Entity\Product;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class ProductFixtures extends Fixture implements EntityFixturesInteface
{
   private array $data;

    public function load(ObjectManager $manager): void
    {
        $metadata = $manager->getClassMetadata(User::class);

        $dataset = $this->getFixturesData();

        foreach($dataset as $datum)
        {
            $product = new Product();

            foreach($datum as $key => $value)
            {
                if($fieldName = $metadata->getFieldName($key))
                {
                    $methodName = "set". ucfirst($fieldName);

                    $product->$methodName($value);
                }
            }

            $manager->persist($product);
        }

        $manager->flush();
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
                'name' => 'custom_product',
                'description' => 'description for custom product',
                'price' => 55525
            ]
        ];
    }
}
