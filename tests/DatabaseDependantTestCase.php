<?php

namespace App\Tests;

use Doctrine\ORM\Tools\SchemaTool;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class DatabaseDependantTestCase extends KernelTestCase
{
    /** @var EntityManagerInterface */
    protected $entityManager;

    protected function setUp(): void
    {
        $kernel = self::bootKernel();

        $this->entityManager = $kernel->getContainer()->get('doctrine')->getManager();

        SchemaLoader::load($this->entityManager);
    }

    protected function tearDown(): void
    {
        parent::tearDown();

        $this->entityManager->close();
        $this->entityManager = null;
    }

    public function assertDatabaseHas(string $entityName, array $criteria)
    {
        $result = $this->entityManager->getRepository($entityName)->findOneBy($criteria);

        $mappedString = $this->getMappedDataAsString($criteria);

        $failureMessage = "A {$entityName} record could not be found with the following attributes: {$mappedString}";

        $this->assertTrue((bool)$result, $failureMessage);
    }

    public function assertDatabaseNotHas(string $entityName, array $criteria)
    {
        $result = $this->entityManager->getRepository($entityName)->findOneBy($criteria);

        $mappedString = $this->getMappedDataAsString($criteria);

        $failureMessage = "A {$entityName} record WAS found with the following attributes: {$mappedString}";

        $this->assertFalse((bool)$result, $failureMessage);
    }

    public function getMappedDataAsString(array $criteria, string $separator = ' = '): string
    {
        $mappedData = array_map(function($key, $value) use ($separator)
        {
            return $key . $separator . $value;
        }, array_keys($criteria), $criteria);

        return implode(', ', $mappedData);
    }
}