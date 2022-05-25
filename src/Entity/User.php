<?php

namespace App\Entity;

use App\Repository\UserRepository;
use DateTimeImmutable;
use Doctrine\ORM\Mapping as ORM;
use phpDocumentor\Reflection\Types\This;

#[ORM\Table(name: 'users')]
#[ORM\Entity(repositoryClass: UserRepository::class)]
class User
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 50)]
    private $username;

    #[ORM\Column(type: 'string', length: 255)]
    private $password;

    /**
     * @var \DatetimeInterface
     */
    #[ORM\Column(type: 'datetime', name: 'created_at')]
    private $createdAt;

    public function __construct()
    {
        $this->createdAt = new \DateTimeImmutable(); //to use current time on instantiation
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUsername(): ?string
    {
        return $this->username;
    }

    public function setUsername(string $username): self
    {
        $this->username = $username;

        return $this;
    }

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->createdAt;
    }

    public static function getFixturesHandler(): string
    {
        return \App\DataFixtures\UserFixtures::class;
    }
}
