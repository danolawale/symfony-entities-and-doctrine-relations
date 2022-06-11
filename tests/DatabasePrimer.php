<?php
// Prime class and prime static method from
// https://www.sitepoint.com/quick-tip-testing-symfony-apps-with-a-disposable-database/

namespace App\Tests;

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Tools\SchemaTool;
use Symfony\Component\HttpKernel\KernelInterface;

class DatabasePrimer
{
    public static function prime(KernelInterface $kernel)
    {
        // Make sure we are in the test environment
        if ('test' !== $kernel->getEnvironment()) {
            throw new \LogicException('Primer must be executed in the test environment');
        }

        // Get the entity manager from the service container
        $entityManager = $kernel->getContainer()->get('doctrine.orm.entity_manager');

        // Run the schema update tool using our entity metadata
        $metadatas = $entityManager->getMetadataFactory()->getAllMetadata();
        $schemaTool = new SchemaTool($entityManager);
        $schemaTool->updateSchema($metadatas);

        // If you are using the Doctrine Fixtures Bundle you could load these here
    }

    public static function truncateAll(KernelInterface $kernel)
    {
        // Make sure we are in the test environment
        if ('test' !== $kernel->getEnvironment()) {
            throw new \LogicException('Primer must be executed in the test environment');
        }

        // Get the entity and schema manager from the service container
        $entityManager = $kernel->getContainer()->get('doctrine.orm.entity_manager');
        $schemaManager = $kernel->getContainer()
            ->get('doctrine.dbal.default_connection')
            ->getSchemaManager();

        // Get all tables
        $tables = $schemaManager->listTableNames();

        // Get more required stuff
        $connection = $entityManager->getConnection();
        $platform   = $connection->getDatabasePlatform();

        // Truncate all tables
        foreach ($tables as $table) {
            $connection->executeUpdate($platform->getTruncateTableSQL($table, false /* whether to cascade */));
        }
    }
}