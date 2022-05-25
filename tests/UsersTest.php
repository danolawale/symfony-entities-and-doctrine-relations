<?php

namespace App\Tests;

use App\Entity\User;

class UsersTest extends DatabaseFixturesTestCase
{
    public function test_dataset_is_loaded()
    {
        $user = $this->entityManager->getRepository(User::class)->findOneBy(['id' => 1]);
        
        $this->assertEquals(1, $user->getId());

        $users = $this->entityManager->getRepository(User::class)->findAll();

        $this->assertCount(2, $users);
    }

    protected function _createTestDataset(): array
    {
        return [
            User::class => [
                [
                    'username' => 'test_user1',
                    'password' => 'test_pass1'
                ],
                [
                    'username' => 'test_user2',
                    'password' => 'test_pass2'
                ]
            ]
        ];
    }
}
