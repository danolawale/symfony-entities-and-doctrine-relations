<?php

namespace App\DataFixtures;

use App\DataFixtures\GenericEntityFixtures;
use Doctrine\Common\DataFixtures\FixtureInterface;

final class AppFixturesFactory
{
    public function __invoke(string $entityName): FixtureInterface
    {
        $fixture = method_exists($entityName, 'getFixturesHandler') ? $entityName::getFixturesHandler() : null;

        if(null === $fixture)
        {
            $fixture = new GenericEntityFixtures($entityName);
            $fixture->setEntityName($entityName);

            return $fixture;
        }

        return new $fixture;
    }
}