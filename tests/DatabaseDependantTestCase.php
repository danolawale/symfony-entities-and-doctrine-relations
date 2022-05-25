<?php

namespace App\Tests;

use Doctrine\ORM\Tools\SchemaTool;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use App\DataFixtures\AppFixturesFactory;
use App\DataFixtures\EntityFixturesInteface;
use Monolog\Handler\Handler;

class DatabaseDependantTestCase extends KernelTestCase
{
    /** @var EntityManagerInterface */
    protected $entityManager;

    protected function setUp(): void
    {
        $kernel = self::bootKernel();

        $this->entityManager = $kernel->getContainer()->get('doctrine')->getManager();

        SchemaLoader::load($this->entityManager);

        $this->createDataset();
    }

    protected function tearDown(): void
    {
        parent::tearDown();

        $this->entityManager->close();
        $this->entityManager = null;
    }

    protected function _createTestDataset(): array
    {
        return [];
    }

    protected function createDataset(?array $dataset = null)
    {
        $dataset ??= $this->_createTestDataset();

        if($dataset && !empty($dataset))
        {
            $fixtureFactory = new AppFixturesFactory();

            $fixtures = array_map(function($entityName, $values) use ($fixtureFactory)
            {
                $handler = ($fixtureFactory)($entityName);

                if($handler instanceof EntityFixturesInteface)
                {
                    $handler->setFixturesData($values);

                    return $handler->load($this->entityManager);
                }
                else
                {
                    throw new \Exception("Invalid fixture for entity {$entityName}");
                }

                
            },array_keys($dataset), $dataset);
        }
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