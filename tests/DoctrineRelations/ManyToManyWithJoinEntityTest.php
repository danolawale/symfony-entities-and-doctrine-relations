<?php
namespace App\Tests\DoctrineRelations;

use App\Entity\Customer;
use App\Entity\Enums\MembershipLevelTypes;
use App\Entity\Membership;
use App\Entity\PrimeDiscountGroup;
use App\Tests\DatabaseDependantTestCase;

class ManyToManyWithJoinEntityTest extends DatabaseDependantTestCase
{
    public function testTwoGroupsOneCustomer(): void
    {
        $primeGroup2 = new PrimeDiscountGroup;
        $primeGroup2->setName('Discount Group 2');
        $this->entityManager->persist($primeGroup2);

        $customer1 = $this->entityManager->getRepository(Customer::class)->find(1);

        //1 customer in two different groups
        $membership = new Membership; //each row in the table represent an instance of the Membership class
        $membership->setLevel((MembershipLevelTypes::HYPE)->value);

        $membership->setPrimeDiscountGroup($primeGroup2);
        $membership->setMember($customer1);
        $this->entityManager->persist($membership);

        $this->entityManager->flush();

        $this->assertEquals(2, $membership->getPrimeDiscountGroup()->getId());
        $this->assertEquals(1, $membership->getMember()->getId());

        //find groups customer1 belongs
        $groups = $this->entityManager->getRepository(Membership::class)->findAll(['member_id' => 1]);
        $this->assertCount(2, $groups);
        $this->assertEquals('standard', $groups[0]->getLevel());
        $this->assertEquals(1, $groups[0]->getMember()->getId());
        $this->assertEquals(1, $groups[0]->getPrimeDiscountGroup()->getId());

        $this->assertEquals('hype', $groups[1]->getLevel());
        $this->assertEquals(1, $groups[1]->getMember()->getId());
        $this->assertEquals(2, $groups[1]->getPrimeDiscountGroup()->getId());
    }

    public function testTwoMembersOneGroup(): void
    {
        $primeGroup1 = $this->entityManager->getRepository(PrimeDiscountGroup::class)->find(1);

        $customer2 = new Customer;
        $this->entityManager->persist($customer2);

        $membership = new Membership; //each row in the table represent an instance of the Membership class
        $membership->setPrimeDiscountGroup($primeGroup1);
        $membership->setMember($customer2);
        $membership->setLevel((MembershipLevelTypes::SUPER)->value);

        $this->entityManager->persist($membership);

        $this->entityManager->flush();

        $groups = $this->entityManager->getRepository(Membership::class)->findAll(['prime_discount_group_id' => 1]);

        $this->assertCount(2, $groups);
        $this->assertEquals('standard', $groups[0]->getLevel());
        $this->assertEquals(1, $groups[0]->getMember()->getId());
        $this->assertEquals(1, $groups[0]->getPrimeDiscountGroup()->getId());

        $this->assertEquals('super', $groups[1]->getLevel());
        $this->assertEquals(2, $groups[1]->getMember()->getId());
        $this->assertEquals(1, $groups[1]->getPrimeDiscountGroup()->getId());
    }

    public function testUpdateMembership()
    {
        $primeGroup1 = $this->entityManager->getRepository(PrimeDiscountGroup::class)->find(1);

        $customer2 = new Customer;
        $this->entityManager->persist($customer2);

        //two customers in one group
        $existingMembership = $this->entityManager->getRepository(
            Membership::class)->findAll(['prime_discount_group_id' => 1]);
        
        $this->assertEquals(1, $existingMembership[0]->getMember()->getId());
        
        //now update
        $existingMembership[0]->setMember($customer2);

        $this->entityManager->persist($existingMembership[0]);
        
        $this->entityManager->flush();

        $this->assertEquals(2, $existingMembership[0]->getMember()->getId());
    }

    protected function _createTestDataset(): array
    {
        return $this->getSortedDataset([
            Membership::class => [
                [
                    'id' => 1,
                    'prime_discount_group_id' => 1,
                    'member_id' => 1,
                    'level' => (MembershipLevelTypes::STANDARD)->value,
                    'created_at' => (new \DateTimeImmutable())->setTimezone(new \DateTimeZone('UTC'))
                ]
            ],
            Customer::class => [
                [
                    'id' => 1
                ]
            ],
            PrimeDiscountGroup::class => [
                [
                    'id' => 1,
                    'name' => 'Discount Group 1'
                ],
            ],
            
        ]);
    }
}