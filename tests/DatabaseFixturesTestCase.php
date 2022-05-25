<?php

namespace App\Tests;

use App\DataFixtures\AppFixturesFactory;
use App\DataFixtures\EntityFixturesInteface;
use Monolog\Handler\Handler;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Component\HttpKernel\Kernel;

class DatabaseFixturesTestCase extends KernelTestCase
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
}