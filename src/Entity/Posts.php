<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\PostsRepository")
 */
class Posts
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $Title;

    /**
     * @ORM\Column(type="text")
     */
    private $Body;

    /**
     * @ORM\Column(type="datetime")
     */
    private $Timestamp;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Users", inversedBy="Posts")
     * @ORM\JoinColumn(nullable=false)
     */
    private $User;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Comments", mappedBy="Post", orphanRemoval=true)
     */
    private $Comments;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Posts", inversedBy="Responses")
     */
    private $Parent;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\Posts", cascade={"persist", "remove"})
     */
    private $Accepted;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Tags", mappedBy="Posts")
     */
    private $Tags;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Votes", mappedBy="Post", orphanRemoval=true)
     */
    private $Votes;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Posts", mappedBy="Parent")
     */
    private $Responses;

    public function __construct()
    {
        $this->Comments = new ArrayCollection();
        $this->Tags = new ArrayCollection();
        $this->Votes = new ArrayCollection();
        $this->Responses = new ArrayCollection();
    }

    public function score(){
        $i = 0;
        foreach($this->Votes as $vote){
            $i += $vote->getUpDown();
        }
        return $i;
    }

    public function nbResponses(){
        $nb = 0;
        foreach($this->Responses as $Responses){
            $nb++;
        }
        return $nb;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->Title;
    }

    public function setTitle(?string $Title): self
    {
        $this->Title = $Title;

        return $this;
    }

    public function getBody(): ?string
    {
        return $this->Body;
    }

    public function setBody(string $Body): self
    {
        $this->Body = $Body;

        return $this;
    }

    public function getTimestamp(): ?\DateTimeInterface
    {
        return $this->Timestamp;
    }

    public function setTimestamp(\DateTimeInterface $Timestamp): self
    {
        $this->Timestamp = $Timestamp;

        return $this;
    }

    public function getUser(): ?Users
    {
        return $this->User;
    }

    public function setUser(?Users $User): self
    {
        $this->User = $User;

        return $this;
    }

    /**
     * @return Collection|Comments[]
     */
    public function getComments(): Collection
    {
        return $this->Comments;
    }

    public function addComment(Comments $comment): self
    {
        if (!$this->Comments->contains($comment)) {
            $this->Comments[] = $comment;
            $comment->setPost($this);
        }

        return $this;
    }

    public function removeComment(Comments $comment): self
    {
        if ($this->Comments->contains($comment)) {
            $this->Comments->removeElement($comment);
            // set the owning side to null (unless already changed)
            if ($comment->getPost() === $this) {
                $comment->setPost(null);
            }
        }

        return $this;
    }

    public function getParent(): ?posts
    {
        return $this->Parent;
    }

    public function setParent(?posts $Parent): self
    {
        $this->Parent = $Parent;

        return $this;
    }

    public function getAccepted(): ?posts
    {
        return $this->Accepted;
    }

    public function setAccepted(?posts $Accepted): self
    {
        $this->Accepted = $Accepted;

        return $this;
    }

    /**
     * @return Collection|Tags[]
     */
    public function getTags(): Collection
    {
        return $this->Tags;
    }

    public function addTag(Tags $tag): self
    {
        if (!$this->Tags->contains($tag)) {
            $this->Tags[] = $tag;
            $tag->addPost($this);
        }

        return $this;
    }

    public function removeTag(Tags $tag): self
    {
        if ($this->Tags->contains($tag)) {
            $this->Tags->removeElement($tag);
            $tag->removePost($this);
        }

        return $this;
    }

    /**
     * @return Collection|Votes[]
     */
    public function getVotes(): Collection
    {
        return $this->Votes;
    }

    public function addVote(Votes $vote): self
    {
        if (!$this->Votes->contains($vote)) {
            $this->Votes[] = $vote;
            $vote->setPost($this);
        }

        return $this;
    }

    public function removeVote(Votes $vote): self
    {
        if ($this->Votes->contains($vote)) {
            $this->Votes->removeElement($vote);
            // set the owning side to null (unless already changed)
            if ($vote->getPost() === $this) {
                $vote->setPost(null);
            }
        }

        return $this;
    }
    /**
     * @return Collection|Votes[]
     */
    public function getResponses(): Collection
    {
        return $this->Responses;
    }

    public function addResponses(Posts $post): self
    {
        if (!$this->Responses->contains($post)) {
            $this->Responses[] = $post;
            $Responses->setPost($this);
        }

        return $this;
    }

    public function removeResponses(Posts $post): self
    {
        if ($this->Responses->contains($post)) {
            $this->Responses->removeElement($post);
            // set the owning side to null (unless already changed)
            // if ($vote->getPost() === $this) {
            //     $vote->setPost(null);
            // }
        }

        return $this;
    }
}
