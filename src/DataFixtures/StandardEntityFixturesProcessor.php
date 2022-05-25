<?php

namespace App\DataFixtures;

use Doctrine\Persistence\ObjectManager;

final class StandardEntityFixturesProcessor
{
    protected array $data;

    public function load(ObjectManager $manager, array $dataset, string $entityName): void
    {
        $metadata = $manager->getClassMetadata($entityName);

        foreach($dataset as $datum)
        {
            $entity = new $entityName();

            foreach($datum as $key => $value)
            {
                if($fieldName = $metadata->getFieldName($key))
                {
                    $methodName = "set". $this->getMethodName($fieldName);

                    $entity->$methodName($value);
                }
            }

            $manager->persist($entity);
        }

        $manager->flush();

        $this->entityName = null;
        $this->data = [];
    }

    private function getMethodName(string $fieldName): string
    {
        return str_replace(' ', '', ucwords(str_replace('_', ' ', $fieldName)));
    }
}