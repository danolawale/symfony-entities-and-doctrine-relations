<?php

namespace App\DataFixtures;

use Doctrine\Common\DataFixtures\FixtureInterface;

final class AppFixturesFactory
{
    public function __invoke(string $entity): FixtureInterface
    {
        $fixture = $entity::getFixturesHandler();

        return new $fixture;
    }
}