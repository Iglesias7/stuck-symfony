<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\TagsRepository")
 */
class Tags
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $Name;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Posts", inversedBy="Tags")
     */
    private $Posts;

    public function __construct()
    {
        $this->Posts = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->Name;
    }

    public function setName(string $Name): self
    {
        $this->Name = $Name;

        return $this;
    }

    /**
     * @return Collection|posts[]
     */
    public function getPosts(): Collection
    {
        return $this->Posts;
    }

    public function addPost(posts $post): self
    {
        if (!$this->Posts->contains($post)) {
            $this->Posts[] = $post;
        }

        return $this;
    }

    public function removePost(posts $post): self
    {
        if ($this->Posts->contains($post)) {
            $this->Posts->removeElement($post);
        }

        return $this;
    }
}
