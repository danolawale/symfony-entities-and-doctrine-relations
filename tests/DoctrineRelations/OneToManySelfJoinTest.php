<?php

namespace App\Tests\DoctrineRelations;

use App\Entity\Category;
use App\Tests\AbstractUnitTestCase;

class OneToManySelfJoinTest extends AbstractUnitTestCase
{
    public function testCreate(): void
    {
        $parent1 = $this->entityManager->getRepository(Category::class)->find(1);
        $parent2 = new Category();
        $parent2->setName('Parent Cat 2');

        $child2 = new Category();
        $child2->setName('Child Cat 2');
        $child2->setParent($parent1);

        $child3 = new Category();
        $child3->setName('Child Cat 3');
        $child3->setParent($parent2);

        $this->entityManager->persist($child2);
        $this->entityManager->persist($parent2);
        $this->entityManager->persist($child3);
        $this->entityManager->flush();

        $this->assertEquals(4, $parent2->getId());
        $this->assertEquals(3, $child2->getId());
        $this->assertEquals(1, $child2->getParent()->getId());
        $this->assertEquals(5, $child3->getId());
        $this->assertEquals(4, $child3->getParent()->getId());
    }

    protected function _createTestDataset(): array
    {
        return [
            Category::class => [
                [
                    'id' => 1,
                    'name' => 'Parent Cat 1',
                    'parent_id' => null
                ],
                [
                    'id' => 2,
                    'name' => 'Child Cat 1',
                    'parent_id' => 1
                ],
            ],
        ];
    }
}