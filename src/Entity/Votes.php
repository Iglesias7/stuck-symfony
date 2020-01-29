<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\VotesRepository")
 */
class Votes
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="integer")
     */
    private $UpDown;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Posts", inversedBy="Votes")
     * @ORM\JoinColumn(nullable=false)
     */
    private $Post;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Users", inversedBy="Votes")
     * @ORM\JoinColumn(nullable=false)
     */
    private $User;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUpDown(): ?int
    {
        return $this->UpDown;
    }

    public function setUpDown(int $UpDown): self
    {
        $this->UpDown = $UpDown;

        return $this;
    }

    public function getPost(): ?posts
    {
        return $this->Post;
    }

    public function setPost(?posts $Post): self
    {
        $this->Post = $Post;

        return $this;
    }

    public function getUser(): ?users
    {
        return $this->User;
    }

    public function setUser(?users $User): self
    {
        $this->User = $User;

        return $this;
    }
}
