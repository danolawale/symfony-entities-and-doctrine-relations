<?php

namespace App\DataFixtures;

use App\Entity\Product;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class UserFixtures extends Fixture implements EntityFixturesInteface
{
   private array $data;

    public function load(ObjectManager $manager): void
    {
        $metadata = $manager->getClassMetadata(User::class);

        $dataset = $this->getFixturesData();

        foreach($dataset as $datum)
        {
            $user = new User();

            foreach($datum as $key => $value)
            {
                if($fieldName = $metadata->getFieldName($key))
                {
                    $methodName = "set". ucfirst($fieldName);

                    if($key === 'password')
                    {
                        $value = password_hash($value, PASSWORD_DEFAULT);
                    }

                    $user->$methodName($value);
                }
            }

            $manager->persist($user);
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
                'username' => 'custom_user',
                'password' => 'custom_pass'
            ]
        ];
    }
}
