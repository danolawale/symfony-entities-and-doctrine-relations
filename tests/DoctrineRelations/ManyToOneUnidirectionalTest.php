<?php

namespace App\Tests\DoctrineRelations;

use App\Entity\Address;
use App\Entity\User;
use App\Tests\AbstractUnitTestCase;

class ManyToOneUnidirectionalTest extends AbstractUnitTestCase
{
    public function testCreate(): void
    {
        $address1 = new Address;
        $address1
            ->setAddressLine1('115')
            ->setPostcode('TT1 1TT')
            ->setCountryCode('GB');

        $user = new User;
        $user
            ->setUsername('dannyMajor')
            ->setPassword('test')
            ->setAddress($address1);

        $user2 = new User;
        $user2
            ->setUsername('dannyMajor')
            ->setPassword('test')
            ->setAddress($address1);

        $this->entityManager->persist($address1);
        $this->entityManager->persist($user);
        $this->entityManager->persist($user2);

        $this->entityManager->flush();

        $this->assertEquals(2, $user->getId());
        $this->assertEquals(2, $user->getAddress()->getId());

        $this->assertEquals(3, $user2->getId());
        $this->assertEquals(2, $user2->getAddress()->getId());
    }

    protected function _createTestDataset(): array
    {
        return [
            Address::class => [
                [
                    'id' => 1,
                    'address_line1' => '10',
                    'address_line2' => 'London Street',
                    'post_code' => 'EC1 1YT',
                    'country_code' => 'GB'
                ]
                ],
            User::class => [
                [
                    'id' => 1,
                    'username' => 'Test User',
                    'password' => 'password',
                    'address_id' => 1
                ],
            ]
        ];
    }
}