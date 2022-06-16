<?php 

namespace App\Tests\DoctrineRelations;

use App\Entity\InterestGroup;
use App\Entity\User;
use App\Tests\AbstractUnitTestCase;

class ManyToManyTest extends AbstractUnitTestCase
{
    public function test(): void
    {
        $productGroup = new InterestGroup;
        $productGroup->setName('Product Group');
        $this->entityManager->persist($productGroup);

        $member = new User;
        $member->setUsername('test')->setPassword('pass');
        $member->joinInterestGroup($productGroup);
        $this->entityManager->persist($member);

        $member2 = new User;
        $member2->setUsername('test2')->setPassword('pass');
        $member2->joinInterestGroup($productGroup);
        $this->entityManager->persist($member2);

        $this->entityManager->flush();

        $this->assertCount(2, $productGroup->getMembers());
        $this->assertEquals(2, $productGroup->getMembers()[0]->getId());
        $this->assertEquals(3, $productGroup->getMembers()[1]->getId());
    }

    protected function _createTestDataset(): array
    {
        return [
            User::class => [
                [
                    'id' => 1,
                    'username' => 'testuser',
                    'password' => 'password'
                ]
                ],
            InterestGroup::class => [
                [
                    'id' => 1,
                    'name' => 'Group1'
                ],
            ]
        ];
    }
}