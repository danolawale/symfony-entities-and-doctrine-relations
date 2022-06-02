<?php //one to many self join

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
#[ORM\Table(name: '`category`')]
class Category
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string')]
    private $name;

    /**
     * This is the inverse side of the relationship
     */
    #[ORM\OneToMany(targetEntity:"Category", mappedBy:"parent", cascade:["persist"])]
    private $children;

    /**
     * This is the owning side of the relationship - with the foreign key
     */
    #[ORM\ManyToOne(targetEntity:"Category", inversedBy:"children")]
    #[ORM\JoinColumn(name:"parent_id", referencedColumnName:"id")]
    private $parent;

    public function __construct()
    {
        $this->children = new ArrayCollection();
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): void
    {
        $this->name = $name;
    }

    public function getChildren(): string
    {
        return $this->children;
    }
    
    /**
     * addChild
     *
     * @param  Category $child
     * @return void
     */
    public function addChild(Category $child): void
    {
        if(!$this->children->contains($child))
        {
            $this->children[] = $child;
        }
    }

    public function getParent(): ?Category
    {
        return $this->parent;
    }

    public function setParent(?Category $parent): void
    {
        $this->addChild($this);

        $this->parent = $parent;
    }
}