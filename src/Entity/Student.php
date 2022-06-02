<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

//this is an example of self join because the mentor is also a student

#[ORM\Entity]
#[ORM\Table(name: '`student`')]
class Student
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\OneToOne(targetEntity:"Student")]
    #[ORM\JoinColumn(name:"mentor_id", referencedColumnName:"id")]
    private $mentor;

    public function getId(): int
    {
        return $this->id;
    }

    public function getMentor(): ?self
    {
        return $this->mentor;
    }

    public function setMentor(Student $mentor): void
    {
        $this->mentor = $mentor;
    }
}